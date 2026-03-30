<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\File;

class OptimizeCategoryImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'images:optimize-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Optimize existing category images in public/images/category';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $directory = public_path('images/category');
        if (!File::isDirectory($directory)) {
            $this->error("Directory $directory does not exist.");
            return;
        }

        $files = File::files($directory);
        $this->info("Found " . count($files) . " files to process.");

        $bar = $this->output->createProgressBar(count($files));
        $bar->start();

        foreach ($files as $file) {
            $filePath = $file->getRealPath();
            $extension = strtolower($file->getExtension());
            $filename = $file->getFilename();

            // Only process common image formats
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'webp'])) {
                try {
                    $img = Image::make($filePath);

                    // Determine Type based on filename or dimensions

                    if (str_contains($filename, '_home')) {
                        // Homepage images
                        $img->resize(400, 400, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } elseif (str_contains($filename, '_')) {
                        // Likely Banners (based on uniqid pattern in controller)
                        $img->resize(1200, 400, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    } else {
                        // Likely image_one
                        $img->resize(200, 200, function ($constraint) {
                            $constraint->aspectRatio();
                            $constraint->upsize();
                        });
                    }

                    // Save as WebP
                    $newPath = $directory . '/' . pathinfo($filename, PATHINFO_FILENAME) . '.webp';
                    $img->encode('webp', 100)->save($newPath);

                    // Normalize slashes for comparison on Windows
                    $normalizedFilePath = str_replace('\\', '/', $filePath);
                    $normalizedNewPath = str_replace('\\', '/', $newPath);

                    if ($normalizedFilePath !== $normalizedNewPath) {
                        @unlink($filePath);
                    }
                } catch (\Exception $e) {
                    $this->error("\nError processing $filename: " . $e->getMessage());
                }
            }
            $bar->advance();
        }

        $bar->finish();
        $this->info("\nOptimization complete!");
    }
}
