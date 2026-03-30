@extends('layout.app')

@section('content')
    <x-hero-section :title="__('blog.page_title')" :backgroundImage="asset('front/assets/images/faqsheroimage.png')" />


    <div class="limited-container"
        style="max-width: unset; background-color: white; z-index: 1; position: relative; padding-top: 30px;">
        <div class="" style="background: white; z-index: 1; max-width: 1230px; margin: auto; width: 100%;">
            <!-- Search and Category Filter -->
            <div class="filter-container"
                style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding: 16px; max-width: 100vw;">

                <div class="category-pills" id="categoryPills" style="cursor: pointer;">
                    <div class="pills {{ !request('category') ? 'active' : '' }}" data-category="">{{ __('blog.all') }}</div>
                    @foreach ($categories as $category)
                        <div class="pills {{ request('category') == $category->id ? 'active' : '' }}"
                            data-category="{{ $category->id }}">{{ $category->name }}</div>
                    @endforeach
                </div>

                <div class="search-box" style="flex: 1; max-width: 400px;">
                    <form action="{{ route('blogs') }}" method="GET" id="search-form">
                        <input type="text" name="search" id="search-input" class="form-control"
                            placeholder="{{ __('blog.search_placeholder') }}" value="{{ request('search') }}">
                        <!-- Preserve category in search form -->
                        @if (request('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                    </form>
                </div>

            </div>

            <!-- Blog Listing -->
            <div class="listing_continer" style="display: flex; justify-content: center; max-width: 100vw;">
                <div class="row row-gap30 gap-2" style="width: 100%; max-width: 1230px;" id="product-container">
                    @forelse ($posts as $post)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="location-card card-container">
                                <a href="{{ route('blog.show', $post->slug) }}"><img
                                        src="{{ $post->image ? asset($post->image) : asset('front/assets/images/candy.svg') }}"
                                        alt="{{ app()->isLocale('ar') ? $post->title_ar : $post->title }}"
                                        style="width: 100%; height: auto;"></a>
                                <a href="{{ route('blog.show', $post->slug) }}">
                                    <h4 class="location-title">
                                        {{ app()->isLocale('ar') ? $post->title_ar : $post->title }}</h4>
                                </a>
                                <div class="location-detail">
                                    <span class="auther-detail">
                                        {{ __('blog.author') }} {{ $post->added_by ?? 'Unknown' }}
                                        {{ __('blog.date') }} {{ $post->created_at->format('F j, Y') }}
                                    </span>
                                    <p class="blog-sub-title">
                                        {{ app()->isLocale('ar') ? Str::limit($post->short_description_ar ?? '', 100) : Str::limit($post->short_description ?? '', 100) }}
                                    </p>
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="btn btn-link">{{ __('blog.read_more') }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p>{{ __('blog.no_blogs') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Pagination -->
            <div id="pagination-container" style="margin: 0px auto 40px auto; text-align: center;">
                {{ $posts->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
    <!-- CONTAINER END -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const pillsContainer = document.getElementById("categoryPills");
            const pills = pillsContainer.querySelectorAll(".pills");
            const searchForm = document.getElementById('search-form');
            const searchInput = document.getElementById('search-input');

            // Category filter functionality
            pills.forEach((pill) => {
                pill.addEventListener("click", function() {
                    // Remove active class from all pills
                    pills.forEach((p) => p.classList.remove("active"));
                    // Add active class to clicked pill
                    this.classList.add("active");

                    // Get the selected category
                    const categoryId = this.getAttribute('data-category');

                    // Update the URL with the selected category and preserve search query
                    const url = new URL(window.location);
                    if (categoryId) {
                        url.searchParams.set('category', categoryId);
                    } else {
                        url.searchParams.delete('category');
                    }

                    // Preserve the search query in the URL
                    if (searchInput.value) {
                        url.searchParams.set('search', searchInput.value);
                    } else {
                        url.searchParams.delete('search');
                    }

                    // Redirect to the updated URL
                    window.location.href = url.toString();
                });
            });

            // Trigger form submission on Enter key press
            searchInput.addEventListener('keypress', function(event) {
                if (event.key === 'Enter' || event.keyCode === 13) {
                    event.preventDefault(); // Prevent default form submission if needed
                    searchForm.submit(); // Submit the form
                }
            });
        });
    </script>
@endsection
