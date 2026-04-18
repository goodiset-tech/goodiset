@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where('id', 1)->first();
    @endphp

    <link rel="stylesheet" href="{{ asset('front/influencers.css') }}">

    <div class="hero-image"
        style="background-image: url({{ asset('') }}{{ $page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.webp' }}); 
        position: unset;">
        <div class="headings">
            <h1 class="hero-title">{{ __('influencers.hero_title') }}</h1>
            <div class="breadcrumbs">
                <img src="{{ asset('') }}front/assets/icons/home.svg" />
                <a href="{{ url('/') }}" target="_blank">{{ __('influencers.breadcrumb_home') }}</a>
                <img src="{{ asset('') }}front/assets/icons/rightarrow.svg" />
                <a href="#" target="_blank">{{ __('influencers.breadcrumb_page') }}</a>
            </div>
        </div>
    </div>

    <!-- HOW IT WORKS -->
    <section class="how-works">
        <div class="how-works__wrap">
            <h2 class="how-works__title">{{ __('influencers.how_title') }} <span class="how-works__bag">💰</span></h2>
            <p class="how-works__subtitle">{{ __('influencers.how_subtitle') }}</p>

            <div class="how-works__grid">
                <!-- 1 — Apply -->
                <div class="how-works__item">
                    <div class="how-works__bubble">
                        <span class="how-works__badge">1</span>
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="9" cy="8" r="3.25" stroke="white" stroke-width="2" />
                            <path d="M3.5 19c0-3.037 2.463-5.5 5.5-5.5s5.5 2.463 5.5 5.5" stroke="white" stroke-width="2"
                                stroke-linecap="round" />
                            <path d="M18 7v6M15 10h6" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="how-works__heading">{{ __('influencers.step1_title') }}</h3>
                    <p class="how-works__text">{{ __('influencers.step1_text') }}</p>
                </div>

                <!-- 2 — Get Approved -->
                <div class="how-works__item">
                    <div class="how-works__bubble">
                        <span class="how-works__badge">2</span>
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="12" cy="12" r="9" stroke="white" stroke-width="2" />
                            <path d="M8 12.5l2.5 2.5L16 9.5" stroke="white" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3 class="how-works__heading">{{ __('influencers.step2_title') }}</h3>
                    <p class="how-works__text">{{ __('influencers.step2_text') }}</p>
                </div>

                <!-- 3 — Share -->
                <div class="how-works__item">
                    <div class="how-works__bubble">
                        <span class="how-works__badge">3</span>
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <rect x="3" y="7" width="18" height="13" rx="3" stroke="white"
                                stroke-width="2" />
                            <path d="M9 7l1.2-2h3.6L15 7" stroke="white" stroke-width="2" stroke-linecap="round" />
                            <circle cx="12" cy="13.5" r="3.25" stroke="white" stroke-width="2" />
                        </svg>
                    </div>
                    <h3 class="how-works__heading">{{ __('influencers.step3_title') }}</h3>
                    <p class="how-works__text">{{ __('influencers.step3_text') }}</p>
                </div>

                <!-- 4 — Earn -->
                <div class="how-works__item">
                    <div class="how-works__bubble">
                        <span class="how-works__badge">4</span>
                        <svg width="30" height="30" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path
                                d="M12 4v16M16.5 8.5c0-1.8-1.8-2.5-4.5-2.5S7 7.3 7 9c0 4 9.5 2.2 9.5 6 0 1.8-1.9 2.7-5 2.7S7 16.8 7 15"
                                stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3 class="how-works__heading">{{ __('influencers.step4_title') }}</h3>
                    <p class="how-works__text">{{ __('influencers.step4_text') }}</p>
                </div>
            </div>
        </div>
    </section>

    <!-- WHY TO JOIN OUR SQUAD -->
    <section class="squad">
        <div class="squad__wrap">
            <h2 class="squad__title">{{ __('influencers.why_title') }}</h2>
            <p class="squad__lead">{{ __('influencers.why_subtitle') }}</p>

            <div class="squad__grid">
                <article class="squad__card">
                    <div class="squad__icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
                            <path d="M12 4v16M16 8.5c0-1.9-2-3-4-3s-4 1.1-4 2.9c0 3.8 8 2.2 8 6.1 0 1.9-2.1 3-4.5 3S7 16.7 7 15"
                                stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>{{ __('influencers.why_card1_title') }}</h3>
                    <p>{{ __('influencers.why_card1_text') }}</p>
                </article>

                <article class="squad__card">
                    <div class="squad__icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
                            <rect x="3" y="8" width="18" height="12" rx="2" stroke="white"
                                stroke-width="2" />
                            <path d="M12 8v12M3 12h18" stroke="white" stroke-width="2" />
                            <path
                                d="M9.2 8C7.4 8 6 6.7 6 5.5S6.9 3.5 8.3 4c1.8.6 3.7 4 3.7 4s2-3.4 3.7-4c1.4-.5 2.3.5 2.3 1.5S16.6 8 14.8 8H9.2Z"
                                stroke="white" stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>{{ __('influencers.why_card2_title') }}</h3>
                    <p>{{ __('influencers.why_card2_text') }}</p>
                </article>

                <article class="squad__card">
                    <div class="squad__icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
                            <path d="M20 10V4h-6L4.6 13.4a3 3 0 0 0 0 4.2l1.8 1.8a3 3 0 0 0 4.2 0L20 10Z" stroke="white"
                                stroke-width="2" stroke-linejoin="round" />
                            <circle cx="16.5" cy="7.5" r="1.5" fill="white" />
                        </svg>
                    </div>
                    <h3>{{ __('influencers.why_card3_title') }}</h3>
                    <p>{{ __('influencers.why_card3_text') }}</p>
                </article>

                <article class="squad__card">
                    <div class="squad__icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
                            <rect x="3" y="5" width="18" height="16" rx="3" stroke="white"
                                stroke-width="2" />
                            <path d="M7 3v4M17 3v4M3 10h18" stroke="white" stroke-width="2" stroke-linecap="round" />
                        </svg>
                    </div>
                    <h3>{{ __('influencers.why_card4_title') }}</h3>
                    <p>{{ __('influencers.why_card4_text') }}</p>
                </article>

                <article class="squad__card">
                    <div class="squad__icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
                            <path d="M4 18h16" stroke="white" stroke-width="2" stroke-linecap="round" />
                            <polyline points="6,14 10,10 13,12 18,7" fill="none" stroke="white" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>{{ __('influencers.why_card5_title') }}</h3>
                    <p>{{ __('influencers.why_card5_text') }}</p>
                </article>

                <article class="squad__card">
                    <div class="squad__icon">
                        <svg viewBox="0 0 24 24" aria-hidden="true" fill="none">
                            <rect x="3" y="7" width="14" height="10" rx="2" stroke="white"
                                stroke-width="2" />
                            <path d="M17 9l4-2v10l-4-2z" stroke="white" stroke-width="2" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <h3>{{ __('influencers.why_card6_title') }}</h3>
                    <p>{{ __('influencers.why_card6_text') }}</p>
                </article>
            </div>
        </div>
    </section>

    <!-- MEET OUR TOP INFLUENCERS -->
    <section class="ti">
        <div class="ti__wrap">
            <h2 class="ti__title">{{ __('influencers.top_title') }}</h2>
            <p class="ti__lead">{{ __('influencers.top_subtitle') }}</p>

            <div class="ti__slider" data-ti>
                <div class="ti__track">
                    <article class="ti__card">
                        <div class="ti__head">
                            <img src="{{ asset('front/assets/images/sarah.webp') }}" alt="Sarah Chen" class="ti__avatar">
                            <div>
                                <h3 class="ti__name">Sarah Chen</h3>
                                <div class="ti__meta">@sweetlife_sarah · 85K</div>
                            </div>
                        </div>
                        <p class="ti__quote">“Goodiset made candy fun and profitable for me! My followers are obsessed.”</p>
                    </article>

                    <article class="ti__card">
                        <div class="ti__head">
                            <img src="{{ asset('front/assets/images/marcus.webp') }}" alt="Marcus Johnson"
                                class="ti__avatar">
                            <div>
                                <h3 class="ti__name">Marcus Johnson</h3>
                                <div class="ti__meta">@candycreator · 120K</div>
                            </div>
                        </div>
                        <p class="ti__quote">“My followers love the free candy drops! Best partnership I’ve ever done.”</p>
                    </article>

                    <article class="ti__card">
                        <div class="ti__head">
                            <img src="{{ asset('front/assets/images/emma.webp') }}" alt="Emma Rodriguez"
                                class="ti__avatar">
                            <div>
                                <h3 class="ti__name">Emma Rodriguez</h3>
                                <div class="ti__meta">@emmasweets · 62K</div>
                            </div>
                        </div>
                        <p class="ti__quote">“I earned $8K in my first 3 months. The custom boxes are a game changer!”</p>
                    </article>

                    <article class="ti__card">
                        <div class="ti__head">
                            <img src="{{ asset('front/assets/images/jake.webp') }}" alt="Jake Williams"
                                class="ti__avatar">
                            <div>
                                <h3 class="ti__name">Jake Williams</h3>
                                <div class="ti__meta">@jakecandy · 95K</div>
                            </div>
                        </div>
                        <p class="ti__quote">“The support team is incredible—quick help with every post I make!”</p>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <!-- EXCLUSIVE VIP PERKS -->
    <section class="perks">
        <div class="perks__wrap">
            <h2 class="perks__title">{{ __('influencers.perks_title') }}</h2>
            <p class="perks__lead">{{ __('influencers.perks_subtitle') }}</p>

            <ul class="perks__list">
                <li class="perks__pill"><span>{{ __('influencers.perk1') }}</span></li>
                <li class="perks__pill"><span>{{ __('influencers.perk2') }}</span></li>
                <li class="perks__pill"><span>{{ __('influencers.perk3') }}</span></li>
                <li class="perks__pill"><span>{{ __('influencers.perk4') }}</span></li>
            </ul>
        </div>
    </section>

    <!-- RESOURCES FOR CREATORS -->
    <section class="rc">
        <div class="rc__wrap">
            <h2 class="rc__title">{{ __('influencers.resources_title') }}</h2>
            <p class="rc__lead">{{ __('influencers.resources_subtitle') }}</p>

            <div class="rc__grid">
                <article class="rc__card">
                    <div class="rc__icon"></div>
                    <h3 class="rc__name">{{ __('influencers.resource1_title') }}</h3>
                    <p class="rc__text">{{ __('influencers.resource1_text') }}</p>
                    <a href="#" class="rc__link">Read More <span aria-hidden="true">›</span></a>
                </article>

                <article class="rc__card">
                    <div class="rc__icon"></div>
                    <h3 class="rc__name">{{ __('influencers.resource2_title') }}</h3>
                    <p class="rc__text">{{ __('influencers.resource2_text') }}</p>
                    <a href="#" class="rc__link">Read More <span aria-hidden="true">›</span></a>
                </article>

                <article class="rc__card">
                    <div class="rc__icon"></div>
                    <h3 class="rc__name">{{ __('influencers.resource3_title') }}</h3>
                    <p class="rc__text">{{ __('influencers.resource3_text') }}</p>
                    <a href="#" class="rc__link">Read More <span aria-hidden="true">›</span></a>
                </article>
            </div>
        </div>
    </section>

    <!-- CONTACT SECTION -->
    <section class="reseller-contact" id="contact">
        <div class="container text-center">
            <h2>{{ __('influencers.contact_title') }}</h2>
            <p class="subtitle">{{ __('influencers.contact_subtitle') }}</p>

            <form class="form reseller-form" action="{{ url('/contact-us') }}" method="POST">
                <input type="hidden" name="contact_type" value="Influencers">
                @csrf
                <div class="form-row">
                    <input type="text" name="name" placeholder="{{ __('influencers.contact_name') }}" required>
                </div>

                <div class="form-row two-cols">
                    <input type="email" name="email" placeholder="{{ __('influencers.contact_email') }}" required>
                    <input type="text" name="phone" placeholder="{{ __('influencers.contact_phone') }}" required>
                </div>

                <div class="form-row two-cols">
                    <input type="text" name="influencer_platform" placeholder="{{ __('influencers.contact_platform') }}" required>
                    <input type="text" name="follower_count" placeholder="{{ __('influencers.contact_followers') }}" required>
                </div>
                <div class="form-row">
                    <input type="text" name="username" placeholder="{{ __('influencers.contact_username') }}" required>
                </div>

                <div class="form-row">
                    <textarea name="meg" rows="4" placeholder="{{ __('influencers.contact_message') }}"></textarea>
                </div>

                <input type="hidden" value="submit" name="submit">
                <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                <button type="submit" class="btn-red contactus-btn">{{ __('influencers.contact_button') }}</button>
            </form>
        </div>
    </section>

    <!-- Tiny slider JS -->
    <script>
        document.querySelectorAll('[data-ti]').forEach(function(root) {
            const track = root.querySelector('.ti__track');
            const prev = root.querySelector('.ti__nav--prev');
            const next = root.querySelector('.ti__nav--next');

            function stepSize() {
                const first = track.querySelector('.ti__card');
                if (!first) return 300;
                const gap = parseInt(getComputedStyle(track).gap || '24', 10);
                return first.offsetWidth + gap;
            }

            if (prev && next) {
                prev.addEventListener('click', () => track.scrollBy({
                    left: -stepSize(),
                    behavior: 'smooth'
                }));
                next.addEventListener('click', () => track.scrollBy({
                    left: stepSize(),
                    behavior: 'smooth'
                }));
            }

            track.addEventListener('wheel', (e) => {
                if (Math.abs(e.deltaX) < Math.abs(e.deltaY))
                    return;
            }, { passive: true });
        });
    </script>
@endsection
