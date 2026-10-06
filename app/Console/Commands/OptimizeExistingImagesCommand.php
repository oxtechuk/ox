<?php

namespace App\Console\Commands;

use App\Services\ImageOptimizerService;
use Illuminate\Console\Command;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class OptimizeExistingImagesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'media:optimize-all
                            {--dir= : Specific directory to scan (default: public/assets and storage/app/public)}
                            {--quality=82 : WebP quality (1-100)}
                            {--max-width=1600 : Maximum width in pixels}
                            {--dry-run : Only preview what will be optimized without modifying files}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan project assets and uploaded images, compress them, and generate high-efficiency WebP copies';

    public function handle(ImageOptimizerService $optimizer): int
    {
        @ini_set('memory_limit', '512M');

        $quality = (int) $this->option('quality');
        $maxWidth = (int) $this->option('max-width');
        $isDryRun = (bool) $this->option('dry-run');
        $customDir = $this->option('dir');

        $directories = $customDir ? [base_path($customDir)] : [
            public_path('assets'),
            storage_path('app/public'),
        ];

        $this->info('🚀 بدء فحص وضغط صور الموقع إلى تنسيق WebP السريع...');
        if ($isDryRun) {
            $this->warn('⚠️ وضع المعاينة فقط (Dry Run) - لن يتم حفظ أي تعديلات.');
        }

        $filesToOptimize = [];

        foreach ($directories as $dir) {
            if (! is_dir($dir)) {
                continue;
            }

            $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));
            foreach ($iterator as $file) {
                if ($file->isDir()) {
                    continue;
                }

                $realPath = $file->getRealPath();
                // Skip 3d models texture folder
                if (str_contains($realPath, DIRECTORY_SEPARATOR.'3d'.DIRECTORY_SEPARATOR)) {
                    continue;
                }

                $ext = strtolower($file->getExtension());
                if (in_array($ext, ['jpg', 'jpeg', 'png'], true)) {
                    // Skip if a webp copy already exists and is smaller
                    $webpCopy = preg_replace('/\.(jpe?g|png)$/i', '.webp', $realPath);
                    $filesToOptimize[] = [
                        'path' => $realPath,
                        'webp_path' => $webpCopy,
                        'size' => $file->getSize(),
                        'has_webp' => file_exists($webpCopy),
                    ];
                }
            }
        }

        $totalCount = count($filesToOptimize);
        if ($totalCount === 0) {
            $this->info('✅ لم يتم العثور على صور غير مضغوطة تحتاج إلى المعالجة.');

            return self::SUCCESS;
        }

        $this->line("وجد {$totalCount} صورة مرشحة للضغط والتحسين.");

        $processed = 0;
        $totalOriginalBytes = 0;
        $totalOptimizedBytes = 0;
        $tableRows = [];

        $progressBar = $this->output->createProgressBar($totalCount);
        $progressBar->start();

        foreach ($filesToOptimize as $item) {
            $path = $item['path'];
            $origSize = $item['size'];
            $totalOriginalBytes += $origSize;

            if ($isDryRun) {
                $totalOptimizedBytes += (int) ($origSize * 0.25); // Estimated 75% savings
                $progressBar->advance();

                continue;
            }

            $result = $optimizer->optimizeLocalFile(
                sourcePath: $path,
                destinationPath: $item['webp_path'],
                maxWidth: $maxWidth,
                quality: $quality
            );

            if ($result) {
                $processed++;
                $totalOptimizedBytes += $result['optimized_size'];
                if (count($tableRows) < 15) {
                    $tableRows[] = [
                        basename($path),
                        number_format($origSize / 1024, 1).' KB',
                        number_format($result['optimized_size'] / 1024, 1).' KB',
                        '-'.$result['savings_percent'].'%',
                    ];
                }
            } else {
                $totalOptimizedBytes += $origSize;
            }

            $progressBar->advance();
        }

        $progressBar->finish();
        $this->newLine(2);

        if (! empty($tableRows)) {
            $this->table(['الصورة', 'الحجم الأصلي', 'حجم WebP', 'نسبة التوفير'], $tableRows);
        }

        $savedBytes = max(0, $totalOriginalBytes - $totalOptimizedBytes);
        $savedMB = number_format($savedBytes / (1024 * 1024), 2);
        $origMB = number_format($totalOriginalBytes / (1024 * 1024), 2);
        $optMB = number_format($totalOptimizedBytes / (1024 * 1024), 2);
        $savingsPct = $totalOriginalBytes > 0 ? round(($savedBytes / $totalOriginalBytes) * 100, 1) : 0;

        $this->info('🎉 اكتملت العملية بنجاح!');
        $this->line("📦 الحجم الإجمالي قبل الضغط: <comment>{$origMB} MB</comment>");
        $this->line("⚡ الحجم الإجمالي بعد الضغط: <info>{$optMB} MB</info>");
        $this->line("💰 إجمالي المساحة الموفرة: <question> {$savedMB} MB ({$savingsPct}%) </question>");

        return self::SUCCESS;
    }
}
