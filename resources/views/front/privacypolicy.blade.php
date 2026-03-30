@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where(['id' => '1'])->first();
    @endphp

    <x-hero-section :title="$page ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('privacy.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="!isset($page) ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <div class="outer_privacy_policy_container">

        <div class="limited-container privacy_policy_container">
            <p>{{ __('privacy.intro_paragraph') }}</p>
            <ul>

                <li>

                    <h1 class="section_heading red">{{ __('privacy.information_we_collect') }}</h1>
                    <div>
                        <h4 class="section_heading red">{{ __('privacy.personal_information') }}</h4>
                        <p>{{ __('privacy.personal_info_paragraph') }}</p>
                    </div>
                    <div>
                        <h4 class="section_heading red">{{ __('privacy.usage_information') }}</h4>
                        <p>{{ __('privacy.usage_info_paragraph') }}</p>
                    </div>

                </li>
                <li>
                    <h1 class="section_heading red">{{ __('privacy.use_of_information') }}</h1>
                    <div>
                        <h4 class="section_heading red">{{ __('privacy.personal_information') }}</h4>
                        <p>{{ __('privacy.personal_info_use_paragraph') }}</p>
                    </div>
                    <div>
                        <h4 class="section_heading red">{{ __('privacy.usage_information') }}</h4>
                        <p>{{ __('privacy.usage_info_use_paragraph') }}</p>
                    </div>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('privacy.data_security') }}</h1>
                    <p>{{ __('privacy.data_security_paragraph') }}</p>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('privacy.your_choices') }}</h1>
                    <p>{{ __('privacy.your_choices_paragraph') }}</p>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('privacy.changes_to_terms') }}</h1>
                    <p>{{ __('privacy.changes_paragraph') }}</p>
                </li>
                {{-- <li>
                    <h1 class="section_heading red">{{ __('privacy.contact_us') }}</h1>
                    <p>{{ __('privacy.contact_paragraph') }} <br> <br> <br>

                        {{ __('privacy.contact_address') }}: <?= $pro->footer_text ?> <br>
                        {{ __('privacy.contact_email') }}: {{ $pro->email }} <br>
                        {{ __('privacy.contact_phone') }}: {{ $pro->phone }}</p>
                </li> --}}
            </ul>
        </div>
    </div>
@endsection
