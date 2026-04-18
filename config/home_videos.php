<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Home page video uploads (admin)
    |--------------------------------------------------------------------------
    | Laravel "max" for files is in kilobytes. Match PHP upload_max_filesize / post_max_size
    | and your web server (e.g. nginx client_max_body_size) to avoid silent failures.
    */
    'max_upload_kb' => (int) env('HOME_VIDEO_MAX_UPLOAD_KB', 512000),

    /*
    | Try to create a poster image from the first second of the video (requires ffmpeg on the server).
    | Set HOME_VIDEO_EXTRACT_POSTER=false to disable.
    */
    'extract_poster' => filter_var(env('HOME_VIDEO_EXTRACT_POSTER', true), FILTER_VALIDATE_BOOLEAN),

    'ffmpeg_binary' => env('HOME_VIDEO_FFMPEG', 'ffmpeg'),

];
