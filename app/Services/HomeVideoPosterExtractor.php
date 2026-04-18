<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;

class HomeVideoPosterExtractor
{
    /**
     * Create a JPEG poster next to other home video posters. Returns public-relative path or null.
     */
    public function tryCreate(string $absoluteVideoPath): ?string
    {
        if (! config('home_videos.extract_poster', true)) {
            return null;
        }

        if (! is_readable($absoluteVideoPath)) {
            return null;
        }

        $posterDir = public_path('images/home-page-videos');
        if (! File::isDirectory($posterDir)) {
            File::makeDirectory($posterDir, 0755, true);
        }

        $posterName = pathinfo($absoluteVideoPath, PATHINFO_FILENAME) . '_poster.jpg';
        $absolutePoster = $posterDir . DIRECTORY_SEPARATOR . $posterName;

        $binary = config('home_videos.ffmpeg_binary', 'ffmpeg');

        $commands = [
            [$binary, '-y', '-nostdin', '-ss', '1', '-i', $absoluteVideoPath, '-frames:v', '1', '-q:v', '3', $absolutePoster],
            [$binary, '-y', '-nostdin', '-ss', '0', '-i', $absoluteVideoPath, '-frames:v', '1', '-q:v', '3', $absolutePoster],
        ];

        foreach ($commands as $argv) {
            try {
                $process = new Process($argv);
                $process->setTimeout(180);
                $process->run();
                if ($process->isSuccessful() && is_file($absolutePoster) && filesize($absolutePoster) > 0) {
                    return 'images/home-page-videos/' . $posterName;
                }
            } catch (\Throwable $e) {
                Log::warning('home_video.ffmpeg_exception', ['message' => $e->getMessage()]);
            }
        }

        Log::info('home_video.poster_skipped', [
            'video' => $absoluteVideoPath,
            'hint' => 'Install ffmpeg or set HOME_VIDEO_EXTRACT_POSTER=false',
        ]);

        return null;
    }
}
