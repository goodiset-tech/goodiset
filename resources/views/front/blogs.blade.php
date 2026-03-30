@extends('layout.app')
@section('content')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">{{ __('blog.page_title') }}</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="/">{{ __('blog.breadcrumb_home') }}</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">{{$category_id->title_english}}</p>
            </div>
        </div>
    </div>

    <!-- CONTAIN START -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5">
            <div class="col-md-12">
                <div class="blog-listing">
                    <div class="row">
                        @foreach($post as $v)
                            <div class="col-lg-3 col-xs-12">
                                <div class="blog-item">
                                    <div class="blog-media mb-30">
                                        <img src="{{asset($v->image)}}" width="340px" height="175px" alt="Electrro">
                                        <a href="/blog/{{$v->slug}}" title="{{ __('blog.read_more') }}" class="read">&nbsp;</a>
                                    </div>
                                    <div class="blog-detail">
                                        <span class="post-date">{{ __('blog.post_date') }}: {{ date(" F d Y ", strtotime($v->created_at)) }}</span>
                                        <h3><a href="/blog/{{$v->slug}}">{{$v->title_english}}</a></h3>
                                        <hr>
                                        <div class="post-info">
                                            <ul>
                                                <li><span>{{ __('blog.by') }}</span><a href="#"> Admin</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- CONTAINER END -->
@endsection
