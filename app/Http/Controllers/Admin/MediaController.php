<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ImageOptimizerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class MediaController extends Controller
{
    public function __construct(
        protected ImageOptimizerService $optimizerService
    ) {}

    /**
     * Display a listing of media files across storage and public assets.
     */
    public function index(Request $request): View
    {
        $category = $request->query('category', 'all'); // all, media, projects, branding, testimonials, assets
        $search = trim((string) $request->query('search', ''));
        $extensionFilter = strtolower(trim((string) $request->query('format', 'all')));
        $page = max(1, (int) $request->query('page', 1));
        $perPage = 28;

        $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'avif'];
        $items = [];

        // 1. Scan storage/app/public directory
        $storageDisk = Storage::disk('public');
        $allStorageFiles = $storageDisk->allFiles();

        foreach ($allStorageFiles as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (! in_array($ext, $allowedExtensions, true)) {
                continue;
            }

            // Determine category
            $itemCategory = 'media';
            if (str_starts_with($file, 'projects')) {
                $itemCategory = 'projects';
            } elseif (str_starts_with($file, 'uploads/branding') || str_starts_with($file, 'branding')) {
                $itemCategory = 'branding';
            } elseif (str_starts_with($file, 'testimonials')) {
                $itemCategory = 'testimonials';
            }

            $sizeBytes = $storageDisk->size($file) ?: 0;
            $fullPath = $storageDisk->path($file);
            $lastModified = $storageDisk->lastModified($file) ?: time();

            $dimensions = null;
            if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true) && file_exists($fullPath)) {
                $imgInfo = @getimagesize($fullPath);
                if ($imgInfo && isset($imgInfo[0], $imgInfo[1])) {
                    $dimensions = "{$imgInfo[0]} × {$imgInfo[1]}";
                }
            }

            $items[] = [
                'name' => basename($file),
                'path' => $file,
                'source' => 'storage',
                'category' => $itemCategory,
                'url' => asset('storage/'.$file),
                'size_bytes' => $sizeBytes,
                'size_formatted' => $this->formatBytes($sizeBytes),
                'extension' => $ext,
                'is_webp' => ($ext === 'webp'),
                'dimensions' => $dimensions,
                'last_modified' => $lastModified,
                'date_formatted' => date('Y-m-d H:i', $lastModified),
                'can_delete' => true,
            ];
        }

        // 2. Scan public/assets directory if requested or for 'assets' category
        if ($category === 'all' || $category === 'assets') {
            $assetsPath = public_path('assets');
            if (File::isDirectory($assetsPath)) {
                $assetFiles = File::allFiles($assetsPath);
                foreach ($assetFiles as $file) {
                    $ext = strtolower($file->getExtension());
                    if (! in_array($ext, $allowedExtensions, true)) {
                        continue;
                    }

                    $relPath = str_replace('\\', '/', $file->getRelativePathname());
                    $sizeBytes = $file->getSize();
                    $lastModified = $file->getMTime();

                    $dimensions = null;
                    if (in_array($ext, ['jpg', 'jpeg', 'png', 'webp'], true)) {
                        $imgInfo = @getimagesize($file->getRealPath());
                        if ($imgInfo && isset($imgInfo[0], $imgInfo[1])) {
                            $dimensions = "{$imgInfo[0]} × {$imgInfo[1]}";
                        }
                    }

                    $items[] = [
                        'name' => $file->getFilename(),
                        'path' => 'assets/'.$relPath,
                        'source' => 'asset',
                        'category' => 'assets',
                        'url' => asset('assets/'.$relPath),
                        'size_bytes' => $sizeBytes,
                        'size_formatted' => $this->formatBytes($sizeBytes),
                        'extension' => $ext,
                        'is_webp' => ($ext === 'webp'),
                        'dimensions' => $dimensions,
                        'last_modified' => $lastModified,
                        'date_formatted' => date('Y-m-d H:i', $lastModified),
                        'can_delete' => false, // Keep core system theme assets protected from accidental UI deletion
                    ];
                }
            }
        }

        // Calculate Global Statistics before filtering
        $totalFiles = count($items);
        $totalBytes = array_sum(array_column($items, 'size_bytes'));
        $webpCount = count(array_filter($items, fn ($i) => $i['is_webp']));
        $webpPercentage = $totalFiles > 0 ? round(($webpCount / $totalFiles) * 100, 1) : 0;

        // Apply filters
        $filteredItems = array_filter($items, function ($item) use ($category, $search, $extensionFilter) {
            // Category filter
            if ($category !== 'all' && $item['category'] !== $category) {
                return false;
            }

            // Extension filter
            if ($extensionFilter !== 'all' && $item['extension'] !== $extensionFilter) {
                return false;
            }

            // Search filter
            if ($search !== '' && ! str_contains(mb_strtolower($item['name']), mb_strtolower($search))) {
                return false;
            }

            return true;
        });

        // Sort: newest first
        usort($filteredItems, fn ($a, $b) => $b['last_modified'] <=> $a['last_modified']);

        // Manual Pagination
        $totalFiltered = count($filteredItems);
        $offset = ($page - 1) * $perPage;
        $pagedSlice = array_slice($filteredItems, $offset, $perPage);

        $mediaList = new LengthAwarePaginator(
            $pagedSlice,
            $totalFiltered,
            $perPage,
            $page,
            ['path' => route('admin.media.index'), 'query' => $request->query()]
        );

        $stats = [
            'total_files' => $totalFiles,
            'total_size_formatted' => $this->formatBytes($totalBytes),
            'webp_count' => $webpCount,
            'webp_percentage' => $webpPercentage,
            'non_webp_count' => $totalFiles - $webpCount,
        ];

        return view('admin.media.index', compact('mediaList', 'stats', 'category', 'search', 'extensionFilter'));
    }

    /**
     * Store new uploaded files with automatic WebP compression.
     */
    public function store(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'files' => 'nullable|array',
            'files.*' => 'file|mimes:jpeg,jpg,png,webp,gif,svg|max:15360',
            'file' => 'nullable|file|mimes:jpeg,jpg,png,webp,gif,svg|max:15360',
            'quality' => 'nullable|integer|min:40|max:100',
            'max_width' => 'nullable|integer|min:400|max:3840',
        ]);

        $uploadedFiles = [];
        if ($request->hasFile('files')) {
            $uploadedFiles = $request->file('files');
        } elseif ($request->hasFile('file')) {
            $uploadedFiles = [$request->file('file')];
        }

        if (empty($uploadedFiles)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'لم يتم إرسال أي ملف للرفع'], 422);
            }

            return back()->with('error', 'يرجى اختيار ملف صورة واحد على الأقل للرفع.');
        }

        $quality = (int) ($request->input('quality', 82));
        $maxWidth = (int) ($request->input('max_width', 1600));

        $results = [];
        $totalOriginalSize = 0;
        $totalOptimizedSize = 0;

        foreach ($uploadedFiles as $file) {
            $res = $this->optimizerService->optimizeAndStore(
                $file,
                directory: 'media',
                disk: 'public',
                maxWidth: $maxWidth,
                quality: $quality
            );

            // Mirror to public/storage/media for hosting environments without functional symlinks
            try {
                $publicMediaDir = public_path('storage/media');
                if (! is_dir($publicMediaDir)) {
                    @mkdir($publicMediaDir, 0755, true);
                }
                $src = storage_path('app/public/'.$res['path']);
                $dest = public_path('storage/'.$res['path']);
                if (file_exists($src) && ! file_exists($dest)) {
                    @copy($src, $dest);
                }
            } catch (\Throwable $e) {
                // Ignore mirror failures on read-only environments
            }

            $totalOriginalSize += $res['original_size'];
            $totalOptimizedSize += $res['optimized_size'];
            $results[] = $res;
        }

        $savedPercent = $totalOriginalSize > 0
            ? round((($totalOriginalSize - $totalOptimizedSize) / $totalOriginalSize) * 100, 1)
            : 0;

        $count = count($results);
        $message = "تم رفع وتحسين {$count} ملف بنجاح بتنسيق WebP (وفرت تقريباً {$savedPercent}% من الحجم الأصلي).";

        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'data' => $results,
                'saved_percent' => $savedPercent,
            ]);
        }

        return redirect()->route('admin.media.index')->with('success', $message);
    }

    /**
     * Delete a media item safely from storage.
     */
    public function destroy(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        $path = $request->input('path');

        // Security check: Reject directory traversal attempts
        if (str_contains($path, '..') || str_contains($path, '\\') || str_starts_with($path, '/') || str_starts_with($path, '.')) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'مسار الملف غير صالح أمنياً'], 400);
            }

            return back()->with('error', 'مسار الملف غير صالح أمنياً.');
        }

        // Prevent deletion of protected system assets
        if (str_starts_with($path, 'assets/')) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'أصول النظام الأساسية محمية ولا يمكن حذفها'], 403);
            }

            return back()->with('error', 'أصول وقوالب النظام الأساسية محمية ضد الحذف المباشر.');
        }

        $storageDisk = Storage::disk('public');

        if (! $storageDisk->exists($path)) {
            if ($request->wantsJson()) {
                return response()->json(['success' => false, 'message' => 'الملف المطلوب غير موجود بالفعل'], 404);
            }

            return back()->with('error', 'الملف المطلوب غير موجود أو تم حذفه مسبقاً.');
        }

        // Delete from storage
        $storageDisk->delete($path);

        // Also clean up mirrored copy in public/storage if present
        $mirroredPath = public_path('storage/'.$path);
        if (file_exists($mirroredPath) && is_file($mirroredPath)) {
            @unlink($mirroredPath);
        }

        $message = 'تم حذف ملف الصورة بنجاح من مكتبة الوسائط.';

        if ($request->wantsJson()) {
            return response()->json(['success' => true, 'message' => $message]);
        }

        return redirect()->route('admin.media.index')->with('success', $message);
    }

    /**
     * Batch convert existing images in storage to WebP.
     */
    public function batchOptimize(Request $request): RedirectResponse
    {
        $storageDisk = Storage::disk('public');
        $allFiles = $storageDisk->allFiles();

        $optimizedCount = 0;
        $savedBytesTotal = 0;

        foreach ($allFiles as $file) {
            $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
            if (! in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
                continue;
            }

            $sourcePath = $storageDisk->path($file);
            $webpRelPath = preg_replace('/\.(jpe?g|png)$/i', '.webp', $file);
            $webpFullPath = $storageDisk->path($webpRelPath);

            // Skip if webp already exists
            if (file_exists($webpFullPath)) {
                continue;
            }

            $res = $this->optimizerService->optimizeLocalFile($sourcePath, $webpFullPath, 1600, 82);
            if ($res) {
                $optimizedCount++;
                $savedBytesTotal += $res['savings_bytes'];

                // Mirror to public/storage
                try {
                    $mirrorDest = public_path('storage/'.$webpRelPath);
                    $mirrorDir = dirname($mirrorDest);
                    if (! is_dir($mirrorDir)) {
                        @mkdir($mirrorDir, 0755, true);
                    }
                    @copy($webpFullPath, $mirrorDest);
                } catch (\Throwable) {
                }
            }
        }

        $savedMb = round($savedBytesTotal / (1024 * 1024), 2);
        $message = "تم تحسين وضغط {$optimizedCount} صورة وتحويلها إلى WebP بنجاح (تم توفير {$savedMb} ميجابايت).";

        return redirect()->route('admin.media.index')->with('success', $message);
    }

    /**
     * Helper to format bytes to human-readable size.
     */
    protected function formatBytes(int $bytes, int $precision = 1): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB'];
        $power = min((int) floor(log($bytes, 1024)), count($units) - 1);

        return round($bytes / (1024 ** $power), $precision).' '.$units[$power];
    }
}
