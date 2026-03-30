@props(['title', 'backgroundImage' => null, 'subTitle' => null])

@php
    // Attempt to resolve background image if not provided
    if (!$backgroundImage && isset($page)) {
        $backgroundImage = asset(
            $page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png',
        );
    }
@endphp

<section class="hero_section confetti-section">

    <div class="confetti-layer"></div> <!-- ✅ Confetti background layer (height controlled in Sass) -->

    <div class="container">
        <div class="hero-banner"
            style="background-image: url({{ $backgroundImage }}) {{ str_contains($backgroundImage, 'important') ? '' : '!important' }};">
            <div class="headings">
                <h1 class="hero-title">{{ $title }}</h1>
                <p class="hero-subtitle">{{ $subTitle }}</p>
            </div>
        </div>
    </div>

</section>
