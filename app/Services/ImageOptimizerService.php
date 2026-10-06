<?php

namespace App\Services;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageOptimizerService
{
    /**
     * Supported image mime types for conversion to WebP
     */
    protected array $supportedMimes = [
        'image/jpeg',
        'image/jpg',
        'image/png',
        'image/webp',
    ];

    /**
     * Optimize an uploaded file, convert it to WebP format, and save to storage.
     *
     * @return array{
     *     filename: string,
     *     path: string,
     *     url: string,
     *     width: int,
     *     height: int,
     *     original_size: int,
     *     optimized_size: int,
     *     savings_bytes: int,
     *     savings_percent: float,
     *     is_webp: bool
     * }
     */
    public function optimizeAndStore(
        UploadedFile $file,
        string $directory = 'uploads/media',
        string $disk = 'public',
        int $maxWidth = 1600,
        int $quality = 82
    ): array {
        $originalSize = $file->getSize() ?: 0;
        $mime = $file->getMimeType();

        // If not a supported image or GD is not available, store normally
        if (! in_array($mime, $this->supportedMimes, true) || ! extension_loaded('gd') || ! function_exists('imagewebp')) {
            $storedPath = $file->store($directory, $disk);
            $storedSize = Storage::disk($disk)->size($storedPath);

            return [
                'filename' => basename($storedPath),
                'path' => $storedPath,
                'url' => Storage::disk($disk)->url($storedPath),
                'width' => 0,
                'height' => 0,
                'original_size' => $originalSize,
                'optimized_size' => $storedSize,
                'savings_bytes' => 0,
                'savings_percent' => 0.0,
                'is_webp' => false,
            ];
        }

        @ini_set('memory_limit', '512M');

        try {
            $realPath = $file->getRealPath();
            $image = match ($mime) {
                'image/jpeg', 'image/jpg' => @imagecreatefromjpeg($realPath),
                'image/png' => @imagecreatefrompng($realPath),
                'image/webp' => @imagecreatefromwebp($realPath),
                default => @imagecreatefromstring(file_get_contents($realPath)),
            };

            if (! $image) {
                throw new Exception('تعذر قراءة ملف الصورة بواسطة GD');
            }

            $origWidth = imagesx($image);
            $origHeight = imagesy($image);

            // Resize if exceeds maximum allowed width
            $targetWidth = $origWidth;
            $targetHeight = $origHeight;

            if ($origWidth > $maxWidth && $maxWidth > 0) {
                $targetWidth = $maxWidth;
                $targetHeight = (int) round(($origHeight / $origWidth) * $maxWidth);

                $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);

                imagecopyresampled(
                    $resizedImage,
                    $image,
                    0,
                    0,
                    0,
                    0,
                    $targetWidth,
                    $targetHeight,
                    $origWidth,
                    $origHeight
                );

                imagedestroy($image);
                $image = $resizedImage;
            } else {
                imagealphablending($image, false);
                imagesavealpha($image, true);
            }

            // Generate unique webp filename
            $randomName = Str::random(32);
            $webpFilename = "{$randomName}.webp";
            $storageRelativePath = trim($directory, '/').'/'.$webpFilename;

            // Ensure destination folder exists in storage
            $fullStorageDir = Storage::disk($disk)->path(trim($directory, '/'));
            if (! is_dir($fullStorageDir)) {
                @mkdir($fullStorageDir, 0755, true);
            }

            $fullTargetPath = Storage::disk($disk)->path($storageRelativePath);

            // Save as WebP
            $success = imagewebp($image, $fullTargetPath, $quality);
            imagedestroy($image);

            if (! $success || ! file_exists($fullTargetPath)) {
                throw new Exception('فشل تصدير الصورة بتنسيق WebP');
            }

            $optimizedSize = filesize($fullTargetPath) ?: $originalSize;
            $savingsBytes = max(0, $originalSize - $optimizedSize);
            $savingsPercent = $originalSize > 0 ? round(($savingsBytes / $originalSize) * 100, 1) : 0.0;

            return [
                'filename' => $webpFilename,
                'path' => $storageRelativePath,
                'url' => Storage::disk($disk)->url($storageRelativePath),
                'width' => $targetWidth,
                'height' => $targetHeight,
                'original_size' => $originalSize,
                'optimized_size' => $optimizedSize,
                'savings_bytes' => $savingsBytes,
                'savings_percent' => $savingsPercent,
                'is_webp' => true,
            ];
        } catch (Exception $e) {
            Log::warning('WebP optimization failed, falling back to original upload: '.$e->getMessage());

            $storedPath = $file->store($directory, $disk);
            $storedSize = Storage::disk($disk)->size($storedPath);

            return [
                'filename' => basename($storedPath),
                'path' => $storedPath,
                'url' => Storage::disk($disk)->url($storedPath),
                'width' => 0,
                'height' => 0,
                'original_size' => $originalSize,
                'optimized_size' => $storedSize,
                'savings_bytes' => 0,
                'savings_percent' => 0.0,
                'is_webp' => false,
            ];
        }
    }

    /**
     * Optimize an existing file in the filesystem and create a WebP equivalent.
     *
     * @return array{
     *     source_path: string,
     *     webp_path: string,
     *     original_size: int,
     *     optimized_size: int,
     *     savings_bytes: int,
     *     savings_percent: float
     * }|null
     */
    public function optimizeLocalFile(
        string $sourcePath,
        ?string $destinationPath = null,
        int $maxWidth = 1600,
        int $quality = 82
    ): ?array {
        if (! file_exists($sourcePath) || ! is_file($sourcePath)) {
            return null;
        }

        $extension = strtolower(pathinfo($sourcePath, PATHINFO_EXTENSION));
        if (! in_array($extension, ['jpg', 'jpeg', 'png', 'webp'], true)) {
            return null;
        }

        $originalSize = filesize($sourcePath) ?: 0;
        if ($originalSize === 0) {
            return null;
        }

        $dest = $destinationPath ?: preg_replace('/\.(jpe?g|png)$/i', '.webp', $sourcePath);

        @ini_set('memory_limit', '512M');

        try {
            $image = match ($extension) {
                'jpg', 'jpeg' => @imagecreatefromjpeg($sourcePath),
                'png' => @imagecreatefrompng($sourcePath),
                'webp' => @imagecreatefromwebp($sourcePath),
                default => @imagecreatefromstring(file_get_contents($sourcePath)),
            };

            if (! $image) {
                return null;
            }

            $origWidth = imagesx($image);
            $origHeight = imagesy($image);

            if ($origWidth > $maxWidth && $maxWidth > 0) {
                $targetWidth = $maxWidth;
                $targetHeight = (int) round(($origHeight / $origWidth) * $maxWidth);

                $resizedImage = imagecreatetruecolor($targetWidth, $targetHeight);
                imagealphablending($resizedImage, false);
                imagesavealpha($resizedImage, true);

                imagecopyresampled(
                    $resizedImage,
                    $image,
                    0,
                    0,
                    0,
                    0,
                    $targetWidth,
                    $targetHeight,
                    $origWidth,
                    $origHeight
                );

                imagedestroy($image);
                $image = $resizedImage;
            } else {
                imagealphablending($image, false);
                imagesavealpha($image, true);
            }

            $success = imagewebp($image, $dest, $quality);
            imagedestroy($image);

            if (! $success || ! file_exists($dest)) {
                return null;
            }

            $optimizedSize = filesize($dest) ?: $originalSize;
            $savingsBytes = max(0, $originalSize - $optimizedSize);
            $savingsPercent = $originalSize > 0 ? round(($savingsBytes / $originalSize) * 100, 1) : 0.0;

            return [
                'source_path' => $sourcePath,
                'webp_path' => $dest,
                'original_size' => $originalSize,
                'optimized_size' => $optimizedSize,
                'savings_bytes' => $savingsBytes,
                'savings_percent' => $savingsPercent,
            ];
        } catch (Exception $e) {
            Log::error("Failed to optimize local image {$sourcePath}: ".$e->getMessage());

            return null;
        }
    }
}
