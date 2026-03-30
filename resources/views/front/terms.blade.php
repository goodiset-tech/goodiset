@extends('layout.app')
@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where(['id' => '1'])->first();
    @endphp

    <x-hero-section :title="$page ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('terms.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="$page ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <div class="outer_privacy_policy_container">

        <div class="limited-container privacy_policy_container">
            <p>{{ __('terms.intro_paragraph') }}</p>
            <ul>
                <li>
                    <h1 class="section_heading red">{{ __('terms.information_we_collect') }}</h1>
                    <div>
                        <h4 class="section_heading red">{{ __('terms.personal_information') }}</h4>
                        <p>{{ __('terms.personal_info_paragraph') }}</p>
                    </div>
                    <div>
                        <h4 class="section_heading red">{{ __('terms.usage_information') }}</h4>
                        <p>{{ __('terms.usage_info_paragraph') }}</p>
                    </div>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('terms.use_of_information') }}</h1>
                    <div>
                        <h4 class="section_heading red">{{ __('terms.use_personal_information') }}</h4>
                        <p>{{ __('terms.personal_info_use_paragraph') }}</p>
                    </div>
                    <div>
                        <h4 class="section_heading red">{{ __('terms.use_usage_information') }}</h4>
                        <p>{{ __('terms.usage_info_use_paragraph') }}</p>
                    </div>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('terms.data_security') }}</h1>
                    <p>{{ __('terms.data_security_paragraph') }}</p>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('terms.your_choices') }}</h1>
                    <p>{{ __('terms.your_choices_paragraph') }}</p>
                </li>
                <li>
                    <h1 class="section_heading red">{{ __('terms.changes_to_terms') }}</h1>
                    <p>{{ __('terms.changes_paragraph') }}</p>
                </li>
                {{-- <li>
                    <h1 class="section_heading red">{{ __('terms.contact_us') }}</h1>
                    <p>{{ __('terms.contact_paragraph') }} <br> <br> <br>
                        {{ __('terms.contact_address') }}: <?= $pro->footer_text ?> <br>
                        {{ __('terms.contact_email') }}: {{ $pro->email }} <br>
                        {{ __('terms.contact_phone') }}: {{ $pro->phone }}
                    </p>
                </li> --}}
            </ul>
        </div>
    </div>
@endsection
