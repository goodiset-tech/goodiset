@extends('layout.app')

@section('content')
    <style>
        #blog-detail-content iframe {
            width: -webkit-fill-available !important;
        }
    </style>

    <x-hero-section :title="app()->isLocale('ar') ? $blog->title_ar : $blog->title" :backgroundImage="asset($blog->image)" />

    <div class="outer_privacy_policy_container">
        <div class="limited-container" id="blog-detail-content" style="padding: 20px 10px">
            {{-- <h3>{{ $blog->title }}</h3> --}}
            <div>
                {{-- <h4>{{ $blog->category->name ?? 'General' }}</h4> --}}
                <p>{!! app()->isLocale('ar') ? $blog->content_ar : $blog->content !!}</p>
            </div>

            @if ($blog->short_description)
                <div>
                    {{-- <h3>Summary</h3> --}}
                    <p>{{ app()->isLocale('ar') ? $blog->short_description_ar : $blog->short_description }}</p>
                </div>
            @endif
        </div>

        @if ($relatedBlogs->isNotEmpty())
            <div class="trending_section" style="background-color: #FFFAFA; padding-bottom: 0;">
                <h3 class="trending-heading">Related Posts</h3>
                <div class="gift_box_outer" style="background-color: #FFFAFA;">
                    <div class="gift_box_section">
                        <div class="gift_boxes" style="padding: 20px 0;">
                            <div class="row">
                                @foreach ($relatedBlogs as $relatedBlog)
                                    <div class="col-12 col-md-6 col-lg-4">
                                        <div class="location-card card-container">
                                            @if ($relatedBlog->image)
                                                <img src="{{ asset($relatedBlog->image) }}"
                                                    style="width: 100%; height: auto;"
                                                    alt="{{ app()->isLocale('ar') ? $relatedBlog->title_ar : $relatedBlog->title }}">
                                            @else
                                                <img src="{{ asset('images/placeholder.jpg') }}"
                                                    style="width: 100%; height: auto;" alt="Placeholder">
                                            @endif
                                            <h4 class="location-title">
                                                {{ app()->isLocale('ar') ? $relatedBlog->title_ar : $relatedBlog->title }}
                                            </h4>
                                            <div class="location-detail">
                                                <span class="auther-detail">
                                                    By {{ $relatedBlog->added_by ?? 'Unknown' }}
                                                    On {{ $relatedBlog->created_at->format('M d, Y') }}
                                                </span>
                                                <p class="blog-sub-title">
                                                    {{ Str::limit($relatedBlog->short_description ?? $relatedBlog->content, 100) }}
                                                </p>
                                                <a href="{{ url('/blog/' . $relatedBlog->slug) }}" class="btn btn-link">Read
                                                    More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
