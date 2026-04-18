<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HomePageVideo extends Model
{
    protected $table = 'home_page_videos';

    protected $fillable = [
        'title',
        'title_ar',
        'video_path',
        'poster_path',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function displayTitle(): string
    {
        if (app()->isLocale('ar') && filled($this->title_ar)) {
            return $this->title_ar;
        }

        return (string) ($this->title ?? '');
    }
}
