    @if (isset($meta) && $meta)

        @if (Session::has('title'))
            <title>{{ $meta->title }}</title>
        @else
            <title>{{ Session::get('title') }}</title>
        @endif
        <meta property="og:title" content="{{ $meta->title }}" />
        <meta property="og:description" content="{{ $meta->description }}">
        <meta name="title" content="{{ $meta->title }}" />
        <meta name="description" content="{{ $meta->description }}" />
        <meta name="keywords" content="{{ $meta->keywords }}" />
        <meta name="robots"
            content="{{ str_contains(request()->getHost(), 'staging') ? 'noindex, nofollow' : 'index, follow' }}">
        <meta property="og:site_name" content="{{ $Site->site_title }}">
        <meta property="og:url" content="{{ url('/') . $_SERVER['REQUEST_URI'] }}" />
        @if ($meta->image)
            <meta property="og:image" content="{{ $meta->image }}" />
            <meta property="og:image:secure_url" content="{{ $meta->image }}">
            <meta property="og:type" content="product">
            <meta property="og:image:width" content="600">
            <meta property="og:image:height" content="600">
            <meta property="og:price:currency" content="AED">
            <meta name="twitter:card" content="summary_large_image">
            <meta property="product:price:currency" content="AED" />
            <meta property="product:condition" content="new" />
            <meta name="twitter:title" content="{{ $meta->title }} ">
            <meta name="twitter:description" content="{{ $meta->description }}">
        @endif
        <meta name="googlebot" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
        <meta name="bingbot" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
        <link rel="alternate" type="application/rss+xml" href="{{ url('/') }}/sitemap.xml" />
    @elseif(isset($tags))
        <title>{{ $tags }} | {{ getSetting('phone') }} | {{ getSetting('site_title') }}</title>
        <meta name="title" content="{{ $tags }} |{{ getSetting('phone') }} | Shopping Online" />
        <meta
            name="description"content="{{ $tags }} | {{ getSetting('phone') }} | Buy Original {{ $tags }} Online in Pakistan" />
        <meta name="keywords" content="{{ $tags }}" />
        <meta property=og:title content="{{ $tags }} Archives" />
        <meta property=og:site_name content="{{ getSetting('site_title') }}" />
        <meta name="robots"
            content="{{ str_contains(request()->getHost(), 'dev') ? 'noindex, nofollow' : 'index, follow' }}">
        <meta property=og:locale content=en_US />
        <meta property=og:type content=article />
        <meta property="og:url" content="{{ url('/') }}/tags/{{ $slug }}" />
        <meta name="googlebot" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
        <meta name="bingbot" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
        <link rel="canonical" href="{{ url('/') }}/tags/{{ $slug }}" />
    @else
        @if (Session::has('title'))
            <title>{{ Session::get('title') }} | {{ getSetting('title') }}</title>
            <meta name="description" content="{{ getSetting('description') }}" />
        @else
            <title>{{ getSetting('site_title') }} | {{ getSetting('title') }}</title>
            <meta name="description" content="{{ getSetting('description') }}" />
        @endif
        <meta name="robots"
            content="{{ str_contains(request()->getHost(), 'staging') ? 'noindex, nofollow' : 'index, follow' }}">
    @endif

    @if (isset($meta) && !empty($meta->scheme))
        <script type="application/ld+json">
            {!! $meta->scheme !!}
        </script>
    @endif

    <?php $Settings = \App\Models\Admins\Setting::where(['id' => '1'])->get(); ?>
    @foreach ($Settings as $Setting)
        <link rel="shortcut icon" href="{{ asset('') }}{{ $Setting->logo1 }}" type="image/x-icon" />
    @endforeach
    <link rel="canonical" href="{{ url('/') . $_SERVER['REQUEST_URI'] }}">
    <meta name="format-detection" content="telephone=no">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google-site-verification" content="JHrE1iLm-tfiHYBEJjDHwQI47lpPvkiUbqKNJn3yGCs" />
