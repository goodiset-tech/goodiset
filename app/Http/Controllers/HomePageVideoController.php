<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\HomePageVideo;
use App\Services\HomeVideoPosterExtractor;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class HomePageVideoController extends Controller
{
    private const VIDEO_EXTENSIONS = ['mp4', 'mov', 'webm', 'm4v', 'avi', 'mkv', 'ogv', '3gp'];

    private function videoDirectory(): string
    {
        return public_path('videos/home-page');
    }

    /**
     * Parse PHP size strings like "8M", "512K", "2G" to bytes.
     */
    private function parseIniSizeToBytes(?string $val): int
    {
        if ($val === null || $val === '') {
            return 0;
        }
        $val = trim($val);
        if ($val === '') {
            return 0;
        }
        $last = strtolower($val[strlen($val) - 1]);
        $num = (float) $val;
        if (in_array($last, ['g', 'm', 'k'], true)) {
            return (int) round($num * match ($last) {
                'g' => 1024 * 1024 * 1024,
                'm' => 1024 * 1024,
                default => 1024,
            });
        }

        return (int) round($num);
    }

    /**
     * Effective max upload (KB) for Laravel validation: never above PHP upload/post limits.
     */
    private function maxUploadKb(): int
    {
        $configured = max(1024, (int) config('home_videos.max_upload_kb', 512000));
        $uploadBytes = $this->parseIniSizeToBytes(ini_get('upload_max_filesize'));
        $postBytes = $this->parseIniSizeToBytes(ini_get('post_max_size'));
        $phpKb = 0;
        if ($uploadBytes > 0 && $postBytes > 0) {
            $phpKb = (int) floor(min($uploadBytes, $postBytes) / 1024);
        } elseif ($uploadBytes > 0) {
            $phpKb = (int) floor($uploadBytes / 1024);
        } elseif ($postBytes > 0) {
            $phpKb = (int) floor($postBytes / 1024);
        }

        if ($phpKb > 0) {
            return min($configured, max(1024, $phpKb));
        }

        return $configured;
    }

    /**
     * Video rules: no "extensions:" rule (can conflict with application/octet-stream). Validate in closure.
     */
    private function videoValidationRules(bool $required): array
    {
        $max = $this->maxUploadKb();

        return [
            'video' => array_values(array_filter([
                $required ? 'required' : 'nullable',
                'file',
                "max:{$max}",
                function (string $attribute, mixed $value, \Closure $fail) use ($required): void {
                    if (! $value instanceof UploadedFile) {
                        if ($required) {
                            $fail('Please choose a video file.');
                        }

                        return;
                    }
                    if (! $value->isValid()) {
                        $fail($this->uploadedFileErrorMessage($value));

                        return;
                    }
                    $ext = strtolower($value->getClientOriginalExtension() ?: ($value->guessExtension() ?: ''));
                    if (! in_array($ext, self::VIDEO_EXTENSIONS, true)) {
                        $fail('Video extension not allowed: .'.$ext.'. Use: '.implode(', ', self::VIDEO_EXTENSIONS).'.');
                    }
                    $mime = strtolower((string) $value->getMimeType());
                    $allowedMimes = [
                        'video/mp4', 'video/webm', 'video/quicktime', 'video/x-msvideo',
                        'video/mpeg', 'video/3gpp', 'video/x-matroska',
                        'application/octet-stream', 'binary/octet-stream',
                    ];
                    if ($mime !== '' && ! in_array($mime, $allowedMimes, true)) {
                        $fail('Video MIME type not allowed (detected: '.$mime.').');
                    }
                },
            ])),
        ];
    }

    private function uploadedFileErrorMessage(UploadedFile $value): string
    {
        return match ($value->getError()) {
            UPLOAD_ERR_INI_SIZE => 'File is larger than PHP upload_max_filesize ('.ini_get('upload_max_filesize').').',
            UPLOAD_ERR_FORM_SIZE => 'File is larger than the HTML MAX_FILE_SIZE limit.',
            UPLOAD_ERR_PARTIAL => 'The file was only partially uploaded. Try again or use a smaller file.',
            UPLOAD_ERR_NO_FILE => 'No file was sent. If the file is large, increase PHP post_max_size (currently '.ini_get('post_max_size').') — it must be >= your file size.',
            UPLOAD_ERR_NO_TMP_DIR => 'Server is missing a temporary folder for uploads.',
            UPLOAD_ERR_CANT_WRITE => 'Server could not write the file to disk.',
            UPLOAD_ERR_EXTENSION => 'A PHP extension blocked this upload.',
            default => 'Upload failed (error code '.$value->getError().').',
        };
    }

    public function index()
    {
        $videos = HomePageVideo::query()->orderBy('sort_order')->orderBy('id')->get();

        return view('admins.blogs.home_videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admins.blogs.home_videos.create', [
            'maxUploadMb' => round($this->maxUploadKb() / 1024, 1),
        ]);
    }

    public function store(Request $request, HomeVideoPosterExtractor $posterExtractor)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            ...$this->videoValidationRules(true),
            'poster' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        /** @var UploadedFile $videoFile */
        $videoFile = $request->file('video');
        if (! $videoFile instanceof UploadedFile) {
            return back()->withInput()->withErrors([
                'video' => 'No video was received. Increase PHP post_max_size and upload_max_filesize (and nginx client_max_body_size if applicable). Current: upload_max_filesize='.ini_get('upload_max_filesize').', post_max_size='.ini_get('post_max_size').'.',
            ]);
        }

        $dir = $this->videoDirectory();
        if (! File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }

        $ext = strtolower($videoFile->getClientOriginalExtension() ?: ($videoFile->guessExtension() ?: 'mp4'));
        $videoName = time() . '_' . uniqid('', true) . '.' . $ext;
        $absoluteVideo = $dir . DIRECTORY_SEPARATOR . $videoName;

        try {
            $videoFile->move($dir, $videoName);
        } catch (\Throwable $e) {
            Log::error('home_video.upload_move_failed', ['message' => $e->getMessage()]);

            return back()->withInput()->withErrors([
                'video' => 'Could not save the file. Check disk space and folder permissions for public/videos/home-page.',
            ]);
        }

        $videoPath = 'videos/home-page/' . $videoName;

        $posterPath = null;
        if ($request->hasFile('poster')) {
            $posterPath = $this->storePosterUpload($request);
        }
        if ($posterPath === null) {
            $posterPath = $posterExtractor->tryCreate($absoluteVideo);
        }

        try {
            HomePageVideo::create([
                'title' => $request->input('title'),
                'title_ar' => $request->input('title_ar'),
                'video_path' => $videoPath,
                'poster_path' => $posterPath,
                'sort_order' => (int) $request->input('sort_order', 0),
                'status' => (bool) (int) $request->input('status', 1),
            ]);
        } catch (\Throwable $e) {
            @unlink($absoluteVideo);
            Log::error('home_video.db_create_failed', ['message' => $e->getMessage()]);

            return back()->withInput()->withErrors(['video' => 'Could not save the record. Please try again.']);
        }

        return redirect()->route('admins.home-videos.index')->with('success', 'Video added successfully.');
    }

    public function edit(HomePageVideo $video)
    {
        return view('admins.blogs.home_videos.edit', [
            'video' => $video,
            'maxUploadMb' => round($this->maxUploadKb() / 1024, 1),
        ]);
    }

    public function update(Request $request, HomePageVideo $video, HomeVideoPosterExtractor $posterExtractor)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            ...$this->videoValidationRules(false),
            'poster' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:5120',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $data = [
            'title' => $request->input('title'),
            'title_ar' => $request->input('title_ar'),
            'sort_order' => (int) $request->input('sort_order', $video->sort_order),
            'status' => (bool) (int) $request->input('status'),
        ];

        if ($request->hasFile('video')) {
            $videoFile = $request->file('video');
            if (! $videoFile instanceof UploadedFile || ! $videoFile->isValid()) {
                return back()->withInput()->withErrors([
                    'video' => $videoFile instanceof UploadedFile
                        ? $this->uploadedFileErrorMessage($videoFile)
                        : 'Invalid video upload.',
                ]);
            }

            $dir = $this->videoDirectory();
            if (! File::isDirectory($dir)) {
                File::makeDirectory($dir, 0755, true);
            }
            if ($video->video_path && file_exists(public_path($video->video_path))) {
                @unlink(public_path($video->video_path));
            }
            if ($video->poster_path && file_exists(public_path($video->poster_path)) && ! $request->hasFile('poster')) {
                @unlink(public_path($video->poster_path));
            }

            $ext = strtolower($videoFile->getClientOriginalExtension() ?: ($videoFile->guessExtension() ?: 'mp4'));
            $videoName = time() . '_' . uniqid('', true) . '.' . $ext;
            $absoluteVideo = $dir . DIRECTORY_SEPARATOR . $videoName;

            try {
                $videoFile->move($dir, $videoName);
            } catch (\Throwable $e) {
                Log::error('home_video.upload_move_failed', ['message' => $e->getMessage()]);

                return back()->withInput()->withErrors([
                    'video' => 'Could not save the file. Check disk space and folder permissions.',
                ]);
            }

            $data['video_path'] = 'videos/home-page/' . $videoName;

            if ($request->hasFile('poster')) {
                $data['poster_path'] = $this->storePosterUpload($request);
            } else {
                $data['poster_path'] = $posterExtractor->tryCreate($absoluteVideo);
            }
        } elseif ($request->hasFile('poster')) {
            if ($video->poster_path && file_exists(public_path($video->poster_path))) {
                @unlink(public_path($video->poster_path));
            }
            $data['poster_path'] = $this->storePosterUpload($request);
        }

        $video->update($data);

        return redirect()->route('admins.home-videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(HomePageVideo $video)
    {
        if ($video->video_path && file_exists(public_path($video->video_path))) {
            @unlink(public_path($video->video_path));
        }
        if ($video->poster_path && file_exists(public_path($video->poster_path))) {
            @unlink(public_path($video->poster_path));
        }
        $video->delete();

        return redirect()->route('admins.home-videos.index')->with('success', 'Video deleted successfully.');
    }

    private function storePosterUpload(Request $request): string
    {
        $posterDir = public_path('images/home-page-videos');
        if (! File::isDirectory($posterDir)) {
            File::makeDirectory($posterDir, 0755, true);
        }
        $poster = $request->file('poster');
        $posterName = time() . '_' . uniqid('', true) . '.' . $poster->getClientOriginalExtension();
        $poster->move($posterDir, $posterName);

        return 'images/home-page-videos/' . $posterName;
    }
}
