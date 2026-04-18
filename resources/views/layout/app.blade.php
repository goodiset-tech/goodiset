<?php
use App\Models\Admins\Pages;
use App\Models\Admins\Setting;
$Site = Setting::where(['id' => '1'])->first();
?>
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ar', 'ur', 'fa', 'he']) ? 'rtl' : 'ltr' }}">

<head>
    @include('layout.partials.meta')
    @include('layout.partials.third-party-head')
    @include('layout.partials.links')
</head>

<body id="body" class="{{ in_array(app()->getLocale(), ['ar', 'ur', 'fa', 'he']) ? 'rtl' : 'ltr' }}">       
    @include('layout.partials.third-party-body')
    <div class="body-container">
        @include('includes.front.header')
        <main>
            @yield('content')
        </main>
        {{ view('front.footer') }}
        <div class="loader_container" id="loader_container">
            <div class="loader"></div>
        </div>
        <div class="loader_container" id="loader_container_overlay">
        </div>

        @include('layout.partials.scripts')
        @include('layout.partials.tiktok-tracking')

    </div>
</body>

</html>
