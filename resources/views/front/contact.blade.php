@extends('layout.app')
@section('content')
    <?php
    use App\Models\Location;
    $pro = DB::table('setting')->first();
    $location = Location::limit('3')->get();
    ?>

    <x-hero-section :title="$page ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('contact_us.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="$page ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <div class="contactus-container">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="contactus-tabs">
                        <div class="tabs-container">
                            <div class="tabs-heading">
                                <h1 class="heading1 section_heading red">{{ __('contact_us.tabs_heading') }}</h1>
                                <div class="tabs">
                                    <button class="tab active" data-target="customers">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <g clip-path="url(#clip0_1393_8790)">
                                                <path
                                                    d="M31.7187 30.1252C29.4097 30.1252 27.5312 28.2467 27.5312 25.9377C27.5312 23.618 29.4204 21.6721 31.7187 21.6721C34.0171 21.6721 35.9062 23.618 35.9062 25.9377C35.9062 28.2467 34.0278 30.1252 31.7187 30.1252Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M25.8048 35.9974L27.3507 32.5055C28.5964 31.6416 30.094 31.1252 31.7184 31.1252C35.9788 31.1252 39.4996 34.5803 39.4996 38.8284V39.5002H28.4516L25.8048 35.9974Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M6.1691 9.45672L5.9375 9.33567L5.7059 9.45672L2.96452 10.8895L3.4898 7.71711L3.53312 7.45551L3.34086 7.2729L1.09507 5.13988L4.22449 4.69853L4.50453 4.65904L4.61497 4.39867L5.94306 1.2676L7.3054 4.4027L7.41642 4.65818L7.69209 4.69824L10.7227 5.13855L8.52939 7.27748L8.34257 7.45967L8.3852 7.71711L8.91048 10.8895L6.1691 9.45672Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M22.5819 7.26579L22.3929 7.44875L22.4366 7.70816L22.9725 10.8879L20.2316 9.45548L20 9.33446L19.7684 9.45548L17.0275 10.8879L17.5634 7.70816L17.6071 7.44875L17.4181 7.26579L15.221 5.13927L18.2898 4.69835L18.569 4.65823L18.6791 4.39853L20.006 1.26751L21.3698 4.40287L21.4809 4.65818L21.7564 4.69823L24.7805 5.1378L22.5819 7.26579Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M34.2941 9.45672L34.0625 9.33567L33.8309 9.45672L31.0895 10.8895L31.6148 7.71711L31.6574 7.45967L31.4706 7.27748L29.2787 5.13991L32.3508 4.69834L32.6299 4.65823L32.74 4.39867L34.0681 1.2676L35.4304 4.4027L35.5418 4.659L35.8184 4.69843L38.9063 5.13854L36.6591 7.2729L36.4669 7.45551L36.5102 7.71711L37.0355 10.8895L34.2941 9.45672Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M8.28125 30.1252C5.97225 30.1252 4.09375 28.2467 4.09375 25.9377C4.09375 23.618 5.98291 21.6721 8.28125 21.6721C10.5796 21.6721 12.4688 23.618 12.4688 25.9377C12.4688 28.2467 10.5903 30.1252 8.28125 30.1252Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M0.5 38.8284C0.5 34.5803 4.02088 31.1252 8.28125 31.1252C9.90088 31.1252 11.3944 31.6386 12.6379 32.4981L14.1325 36.3911L11.5615 39.5002H0.5V38.8284Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M15.8125 23.5159C15.8125 21.2139 17.698 19.3284 20 19.3284C22.302 19.3284 24.1875 21.2139 24.1875 23.5159C24.1875 25.8286 22.2913 27.7815 20 27.7815C17.7087 27.7815 15.8125 25.8286 15.8125 23.5159Z"
                                                    fill="white" stroke="#303030" />
                                                <path
                                                    d="M27.7031 36.4846V39.5002H12.2969V36.4846C12.2969 34.9935 12.7344 33.6303 13.4645 32.4352C14.8321 30.2526 17.2542 28.7815 20 28.7815C22.7458 28.7815 25.1679 30.2526 26.5355 32.4352C27.2656 33.6303 27.7031 34.9935 27.7031 36.4846Z"
                                                    fill="white" stroke="#303030" />
                                            </g>
                                            <defs>
                                                <clipPath id="clip0_1393_8790">
                                                    <rect width="40" height="40" fill="white" />
                                                </clipPath>
                                            </defs>
                                        </svg>
                                        {{ __('contact_us.tab_customers') }}
                                    </button>
                                    <button class="tab" data-target="franchise">
                                        <img src="{{ asset('') }}front/assets/images/franchise.svg" alt="Franchise" />
                                        {{ __('contact_us.tab_franchise') }}
                                    </button>
                                    <button class="tab" data-target="retailers">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M36.6145 8.01245H3.38477V36.4539H36.6145V8.01245Z" fill="white" />
                                            <path d="M36.6152 8.01245H32.3965V36.4539H36.6152V8.01245Z" fill="white" />
                                            <path
                                                d="M36.7309 8.01227H3.26953V3.34336C3.26953 2.97031 3.57188 2.66797 3.94492 2.66797H36.0555C36.4286 2.66797 36.7309 2.97031 36.7309 3.34336V8.01227Z"
                                                fill="white" />
                                            <path
                                                d="M36.0551 2.66797H32.5117V6.18273H36.7305V3.34336C36.7305 2.97031 36.428 2.66797 36.0551 2.66797Z"
                                                fill="white" />
                                            <path
                                                d="M3.38535 16.4788C1.85598 16.4788 0.616211 15.239 0.616211 13.7096V11.4536H6.15441V13.7096C6.15441 15.239 4.91465 16.4788 3.38535 16.4788Z"
                                                fill="white" />
                                            <path
                                                d="M8.92344 16.4788C7.39406 16.4788 6.1543 15.239 6.1543 13.7096V11.4536H11.6925V13.7096C11.6926 15.239 10.4528 16.4788 8.92344 16.4788Z"
                                                fill="#F2F2F2" />
                                            <path
                                                d="M14.4615 16.4788C12.9321 16.4788 11.6924 15.239 11.6924 13.7096V11.4536H17.2306V13.7096C17.2306 15.239 15.9908 16.4788 14.4615 16.4788Z"
                                                fill="white" />
                                            <path
                                                d="M19.9996 16.4788C18.4702 16.4788 17.2305 15.239 17.2305 13.7096V11.4536H22.7687V13.7096C22.7688 15.239 21.529 16.4788 19.9996 16.4788Z"
                                                fill="#F2F2F2" />
                                            <path
                                                d="M25.5387 16.4788C24.0093 16.4788 22.7695 15.239 22.7695 13.7096V11.4536H28.3077V13.7096C28.3077 15.239 27.068 16.4788 25.5387 16.4788Z"
                                                fill="white" />
                                            <path
                                                d="M31.0768 16.4788C29.5474 16.4788 28.3076 15.239 28.3076 13.7096V11.4536H33.8458V13.7096C33.8459 15.239 32.6061 16.4788 31.0768 16.4788Z"
                                                fill="#F2F2F2" />
                                            <path
                                                d="M36.6148 16.4788C35.0855 16.4788 33.8457 15.239 33.8457 13.7096V11.4536H39.3839V13.7096C39.384 15.239 38.1442 16.4788 36.6148 16.4788Z"
                                                fill="white" />
                                            <path d="M6.15441 11.4538H0.616211L3.26652 6.18286H8.04754L6.15441 11.4538Z"
                                                fill="white" />
                                            <path d="M11.6926 11.4538H6.1543L8.04742 6.18286H12.8284L11.6926 11.4538Z"
                                                fill="white" />
                                            <path d="M17.2306 11.4538H11.6924L12.8282 6.18286H17.6093L17.2306 11.4538Z"
                                                fill="white" />
                                            <path d="M22.7688 11.4538H17.2305L17.6091 6.18286H22.3901L22.7688 11.4538Z"
                                                fill="white" />
                                            <path d="M28.3075 11.4538H22.7693L22.3906 6.18286H27.1716L28.3075 11.4538Z"
                                                fill="white" />
                                            <path d="M33.846 11.4538H28.3077L27.1719 6.18286H31.9529L33.846 11.4538Z"
                                                fill="white" />
                                            <path d="M39.3835 11.4538H33.8453L31.9521 6.18286H36.7332L39.3835 11.4538Z"
                                                fill="white" />
                                            <path
                                                d="M38.1493 33.8555H1.85063C1.15211 33.8555 0.585938 34.4217 0.585938 35.1202V36.9736C0.585938 37.1716 0.746484 37.3321 0.944453 37.3321H39.0555C39.2535 37.3321 39.4141 37.1716 39.4141 36.9736V35.1202C39.4141 34.4217 38.8478 33.8555 38.1493 33.8555Z"
                                                fill="white" />
                                            <path
                                                d="M38.1496 33.8555H35.1826V37.332H39.0559C39.2539 37.332 39.4144 37.1716 39.4144 36.9735V35.1202C39.4143 34.4217 38.8481 33.8555 38.1496 33.8555Z"
                                                fill="white" />
                                            <path
                                                d="M33.3417 30.1382H16.2852C16.0069 30.1382 15.7812 29.9126 15.7812 29.6343V20.2488C15.7812 19.9705 16.0069 19.7449 16.2852 19.7449H33.3417C33.62 19.7449 33.8456 19.9705 33.8456 20.2488V29.6343C33.8456 29.9127 33.62 30.1382 33.3417 30.1382Z"
                                                fill="white" />
                                            <path
                                                d="M33.3421 19.7449H29.6143V30.1382H33.3421C33.6204 30.1382 33.8461 29.9126 33.8461 29.6343V20.2488C33.8461 19.9704 33.6204 19.7449 33.3421 19.7449Z"
                                                fill="white" />
                                            <path
                                                d="M13.3855 33.8553H5.60352V20.2488C5.60352 19.9705 5.82914 19.7449 6.10742 19.7449H12.8816C13.1598 19.7449 13.3855 19.9705 13.3855 20.2488V33.8553Z"
                                                fill="white" />
                                            <path
                                                d="M12.8822 19.7449H9.1543V33.8554H13.3861V20.2488C13.3861 19.9704 13.1605 19.7449 12.8822 19.7449Z"
                                                fill="white" />
                                            <path
                                                d="M11.2109 27.7153C11.5345 27.7153 11.7969 27.453 11.7969 27.1294V26.0747C11.7969 25.7511 11.5345 25.4888 11.2109 25.4888C10.8873 25.4888 10.625 25.7511 10.625 26.0747V27.1294C10.625 27.453 10.8873 27.7153 11.2109 27.7153Z"
                                                fill="#303030" />
                                            <path
                                                d="M38.1494 33.2694H37.2007V17.0124C38.7722 16.7343 39.9698 15.3597 39.9698 13.7096V11.4537C39.9698 11.4422 39.9688 11.4309 39.9681 11.4196C39.9677 11.4133 39.9677 11.407 39.9672 11.4006C39.9651 11.3775 39.9619 11.3548 39.9572 11.3326C39.957 11.3313 39.9565 11.33 39.9562 11.3288C39.9516 11.3074 39.9455 11.2866 39.9387 11.2662C39.937 11.2611 39.9349 11.2559 39.933 11.2509C39.9266 11.2334 39.9194 11.2163 39.9113 11.1997C39.9098 11.1966 39.9089 11.1934 39.9074 11.1905L37.3166 6.0382V3.34336C37.3166 2.64789 36.7508 2.08203 36.0553 2.08203H9.41063C9.08703 2.08203 8.82469 2.34438 8.82469 2.66797C8.82469 2.99156 9.08703 3.25391 9.41063 3.25391H36.0553C36.1046 3.25391 36.1448 3.29406 36.1448 3.34336V5.5968H3.85523V3.34336C3.85523 3.29406 3.89539 3.25391 3.94469 3.25391H6.68437C7.00797 3.25391 7.27031 2.99156 7.27031 2.66797C7.27031 2.34438 7.00797 2.08203 6.68437 2.08203H3.94469C3.24922 2.08203 2.68336 2.64789 2.68336 3.34336V6.0382L0.0926562 11.1905C0.0911719 11.1935 0.0901562 11.1967 0.08875 11.1997C0.0807031 11.2163 0.0735156 11.2334 0.0670312 11.2509C0.0651563 11.256 0.063125 11.2611 0.0614063 11.2662C0.0545313 11.2866 0.0485156 11.3074 0.0439062 11.3288C0.0435937 11.33 0.0432031 11.3313 0.0428906 11.3326C0.0382031 11.3548 0.0349219 11.3775 0.0328906 11.4006C0.0323437 11.407 0.0323437 11.4133 0.0319531 11.4196C0.0313281 11.4309 0.0302344 11.4422 0.0302344 11.4537V13.7096C0.0302344 15.3596 1.22789 16.7343 2.79938 17.0124V33.2694H1.85063C0.830156 33.2694 0 34.0996 0 35.1201V36.9734C0 37.4941 0.423672 37.9178 0.944453 37.9178H39.0555C39.5763 37.9178 40 37.4941 40 36.9734V35.1201C40 34.0996 39.1698 33.2694 38.1494 33.2694ZM38.7979 13.7097C38.7979 14.9135 37.8185 15.8929 36.6147 15.8929C35.4109 15.8929 34.4315 14.9135 34.4315 13.7097V12.0397H38.7979V13.7097ZM36.3723 6.76867L38.4334 10.8677H34.2577L32.7855 6.76867H36.3723ZM31.5403 6.76867L33.0125 10.8677H28.7805L27.8971 6.76867H31.5403ZM33.2597 12.0396V13.7096C33.2597 14.9134 32.2803 15.8928 31.0765 15.8928C29.8727 15.8928 28.8933 14.9134 28.8933 13.7096V12.0396H33.2597ZM26.6984 6.76867L27.5817 10.8677H23.3145L23.0201 6.76867H26.6984ZM27.7214 12.0396V13.7096C27.7214 14.9134 26.742 15.8928 25.5383 15.8928C24.3345 15.8928 23.3551 14.9134 23.3551 13.7096V12.0396H27.7214ZM18.1548 6.76867H21.8451L22.1395 10.8677H17.8604L18.1548 6.76867ZM17.8168 12.0396H22.1832V13.7096C22.1832 14.9134 21.2038 15.8928 20 15.8928C18.7962 15.8928 17.8168 14.9134 17.8168 13.7096V12.0396ZM20 17.0647C21.1488 17.0647 22.1641 16.4841 22.7691 15.6013C23.3741 16.4841 24.3895 17.0647 25.5383 17.0647C26.687 17.0647 27.7024 16.4841 28.3073 15.6013C28.9123 16.4841 29.9277 17.0647 31.0765 17.0647C32.2252 17.0647 33.2406 16.4841 33.8456 15.6013C34.3453 16.3305 35.1252 16.8525 36.0288 17.0124V33.2694H13.9716V20.2487C13.9716 19.6478 13.4827 19.1589 12.8817 19.1589H6.10758C5.50664 19.1589 5.01773 19.6478 5.01773 20.2487V33.2694H3.97125V17.0124C4.87484 16.8525 5.65477 16.3305 6.15445 15.6013C6.75945 16.4841 7.77484 17.0647 8.92359 17.0647C10.0723 17.0647 11.0877 16.4841 11.6927 15.6013C12.2977 16.4841 13.3131 17.0647 14.4618 17.0647C15.6105 17.0647 16.6259 16.4841 17.2309 15.6013C17.8359 16.4841 18.8512 17.0647 20 17.0647ZM12.7997 20.3308V33.2694H6.18961V20.3308H12.7997ZM6.74031 13.7097V12.0397H11.1067V13.7097C11.1067 14.9135 10.1273 15.8929 8.92352 15.8929C7.71969 15.8929 6.74031 14.9134 6.74031 13.7097ZM13.3016 6.76867H16.9799L16.6855 10.8677H12.4183L13.3016 6.76867ZM12.2786 12.0396H16.6449V13.7096C16.6449 14.9134 15.6655 15.8928 14.4617 15.8928C13.2579 15.8928 12.2786 14.9134 12.2786 13.7096V12.0396ZM12.1028 6.76867L11.2195 10.8677H6.98742L8.45961 6.76867H12.1028ZM3.62773 6.76867H7.21445L5.74227 10.8677H1.56664L3.62773 6.76867ZM1.20211 13.7097V12.0397H5.56852V13.7097C5.56852 14.9135 4.58914 15.8929 3.38531 15.8929C2.18148 15.8929 1.20211 14.9134 1.20211 13.7097ZM38.8281 36.7459H1.17188V35.12C1.17188 34.7457 1.47633 34.4412 1.85063 34.4412H38.1493C38.5236 34.4412 38.828 34.7457 38.828 35.12V36.7459H38.8281Z"
                                                fill="#303030" />
                                            <path
                                                d="M15.1953 20.2488V29.6344C15.1953 30.2353 15.6842 30.7242 16.2852 30.7242H33.3416C33.9426 30.7242 34.4315 30.2353 34.4315 29.6344V20.2488C34.4315 19.6478 33.9426 19.1589 33.3416 19.1589H26.1766C25.853 19.1589 25.5906 19.4213 25.5906 19.7449C25.5906 20.0685 25.853 20.3308 26.1766 20.3308H33.2597V29.5523H16.3672V20.3308H23.418C23.7416 20.3308 24.0039 20.0685 24.0039 19.7449C24.0039 19.4213 23.7416 19.1589 23.418 19.1589H16.2852C15.6842 19.1589 15.1953 19.6478 15.1953 20.2488Z"
                                                fill="#303030" />

                                        </svg>
                                        {{ __('contact_us.tab_retailers') }}
                                    </button>
                                    <button class="tab" data-target="event-organizer">
                                        <img src="{{ asset('') }}front/assets//images/event_organizer.svg"
                                            alt="Event Organizer" />
                                        {{ __('contact_us.tab_organizer') }}
                                    </button>
                                </div>
                            </div>

                            <div class="form-containerr contact_us_form_container">
                                <!-- Customers -->
                                <form method="post" action="{{ route('contact-us') }}" id="customers"
                                    class="form contect_us_form active" novalidate>
                                    <div class="fields">
                                        @csrf
                                        <div class="field">
                                            <label for="cust_name">{{ __('contact_us.full_name') }}</label>
                                            <input type="hidden" name="contact_type" value="Customers">
                                            <input required type="text" name="name" id="cust_name"
                                                placeholder="{{ __('contact_us.full_name') }}">
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="cust_email">{{ __('contact_us.email') }}</label>
                                                <input required type="email" name="email" id="cust_email"
                                                    placeholder="{{ __('contact_us.email') }}">
                                            </div>
                                            <div class="field">
                                                <label for="cust_phone">{{ __('contact_us.phone') }}</label>
                                                <input required type="tel" name="phone" id="cust_phone"
                                                    placeholder="{{ __('contact_us.phone') }}">
                                            </div>
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="cust_company">{{ __('contact_us.company_name') }}</label>
                                                <input required type="text" name="company" id="cust_company"
                                                    placeholder="{{ __('contact_us.company_name') }}">
                                            </div>
                                            <div class="field">
                                                <label for="cust_category">{{ __('contact_us.category') }}</label>
                                                <select required name="category" id="cust_category">
                                                    <option value="">{{ __('contact_us.select_placeholder') }}
                                                    </option>
                                                    <option value="General Inquiry">
                                                        {{ __('contact_us.category.general_inquiry') }}
                                                    </option>
                                                    <option value="Product/Service Support">
                                                        {{ __('contact_us.category.product_service_support') }}</option>
                                                    <option value="Sales and Pricing">
                                                        {{ __('contact_us.category.sales_pricing') }}
                                                    </option>
                                                    <option value="Partnership Opportunities">
                                                        {{ __('contact_us.category.partnership_opportunities') }}</option>
                                                    <option value="Feedback and Suggestions">
                                                        {{ __('contact_us.category.feedback_suggestions') }}</option>
                                                    <option value="Billing and Payment Issues">
                                                        {{ __('contact_us.category.billing_payment_issues') }}</option>
                                                    <option value="Press and Media">
                                                        {{ __('contact_us.category.press_media') }}
                                                    </option>
                                                    <option value="Complaints">{{ __('contact_us.category.complaints') }}
                                                    </option>
                                                    <option value="Suggestions">
                                                        {{ __('contact_us.category.suggestions') }}</option>
                                                    <option value="Compliments">
                                                        {{ __('contact_us.category.compliments') }}</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label for="cust_msg">{{ __('contact_us.message') }}</label>
                                            <textarea name="meg" id="cust_msg" required placeholder="{{ __('contact_us.message') }}" rows="5"></textarea>
                                            <input type="hidden" value="submit" name="submit">
                                        </div>
                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                        </div>
                                        <button class="contactus-btn"
                                            type="submit">{{ __('contact_us.submit_btn') }}</button>
                                    </div>
                                </form>

                                <!-- Franchise -->
                                <form method="post" action="{{ route('contact-us') }}" id="franchise"
                                    class="form contect_us_form" novalidate>
                                    <div class="fields">
                                        @csrf
                                        <div class="field">
                                            <label for="fra_name">{{ __('contact_us.full_name') }}</label>
                                            <input type="hidden" name="contact_type" value="Franchise">
                                            <input required type="text" name="name" id="fra_name"
                                                placeholder="{{ __('contact_us.full_name') }}">
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="fra_email">{{ __('contact_us.email') }}</label>
                                                <input required type="email" name="email" id="fra_email"
                                                    placeholder="{{ __('contact_us.email') }}">
                                            </div>
                                            <div class="field">
                                                <label for="fra_phone">{{ __('contact_us.phone') }}</label>
                                                <input required type="text" name="phone" id="fra_phone"
                                                    placeholder="{{ __('contact_us.phone') }}">
                                            </div>
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="fra_country">{{ __('contact_us.country') }}</label>
                                                <input required type="text" name="country" id="fra_country"
                                                    placeholder="{{ __('contact_us.country') }}">
                                            </div>
                                            <div class="field">
                                                <label
                                                    for="fra_location_interest">{{ __('contact_us.location_interest') }}</label>
                                                <input required type="text" name="event_location"
                                                    id="fra_location_interest"
                                                    placeholder="{{ __('contact_us.location_interest') }}">
                                            </div>
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="fra_model_type">{{ __('contact_us.model_type') }}</label>
                                                <select required name="model_type" id="fra_model_type">
                                                    <option value="">{{ __('contact_us.select_placeholder') }}
                                                    </option>
                                                    <option value="Kiosk">{{ __('contact_us.model_type.kiosk') }}
                                                    </option>
                                                    <option value="Inside Mall">
                                                        {{ __('contact_us.model_type.inside_mall') }}</option>
                                                    <option value="Outdoor Retail">
                                                        {{ __('contact_us.model_type.outdoor_retail') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="field">
                                                <label
                                                    for="fra_budget">{{ __('contact_us.estimated_investment_budget') }}</label>
                                                <select required name="estimated_investment_budget" id="fra_budget">
                                                    <option value="">{{ __('contact_us.select_placeholder') }}
                                                    </option>
                                                    <option value="AED 1M to 1.5M">
                                                        {{ __('contact_us.estimated_investment_budget.range_1_1_5m') }}
                                                    </option>
                                                    <option value="AED 1.5M to 2M">
                                                        {{ __('contact_us.estimated_investment_budget.range_1_5_2m') }}
                                                    </option>
                                                    <option value="AED 2M+">
                                                        {{ __('contact_us.estimated_investment_budget.range_2m_plus') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label for="fra_msg">{{ __('contact_us.message') }}</label>
                                            <textarea name="meg" id="fra_msg" required placeholder="{{ __('contact_us.message') }}" rows="5"></textarea>
                                        </div>
                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                        </div>
                                        <input type="hidden" value="submit" name="submit">
                                        <button class="contactus-btn"
                                            type="submit">{{ __('contact_us.submit_btn') }}</button>
                                    </div>
                                </form>

                                <!-- Retailers -->
                                <form method="post" action="{{ route('contact-us') }}" id="retailers"
                                    class="form contect_us_form" novalidate>
                                    <div class="fields">
                                        @csrf
                                        <div class="field">
                                            <label for="ret_name">{{ __('contact_us.full_name') }}</label>
                                            <input type="hidden" name="contact_type" value="Retailers">
                                            <input required type="text" name="name" id="ret_name"
                                                placeholder="{{ __('contact_us.full_name') }}">
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="ret_email">{{ __('contact_us.email') }}</label>
                                                <input required type="email" name="email" id="ret_email"
                                                    placeholder="{{ __('contact_us.email') }}">
                                            </div>
                                            <div class="field">
                                                <label for="ret_phone">{{ __('contact_us.phone') }}</label>
                                                <input required type="text" name="phone" id="ret_phone"
                                                    placeholder="{{ __('contact_us.phone') }}">
                                            </div>
                                        </div>
                                        <div class="two-fields">
                                            <div Bronze class="field">
                                                <label for="ret_company">{{ __('contact_us.company_name') }}</label>
                                                <input required type="text" name="company" id="ret_company"
                                                    placeholder="{{ __('contact_us.company_name') }}">
                                            </div>
                                            <div class="field">
                                                <label for="ret_shops">{{ __('contact_us.shops_count') }}</label>
                                                <input required type="text" name="shop_count" id="ret_shops"
                                                    placeholder="{{ __('contact_us.shops_count') }}">
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label for="ret_kilos">{{ __('contact_us.monthly_kilo_order') }}</label>
                                            <select required name="monthly_kilo_order" id="ret_kilos">
                                                <option value="">{{ __('contact_us.select_placeholder') }}</option>
                                                <option value="50-100k">{{ __('contact_us.monthly_kilo_order.50_100k') }}
                                                </option>
                                                <option value="100-200k">
                                                    {{ __('contact_us.monthly_kilo_order.100_200k') }}</option>
                                                <option value="200-400k">
                                                    {{ __('contact_us.monthly_kilo_order.200_400k') }}</option>
                                                <option value="400-600k">
                                                    {{ __('contact_us.monthly_kilo_order.400_600k') }}</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label for="ret_msg">{{ __('contact_us.message') }}</label>
                                            <textarea name="meg" id="ret_msg" required placeholder="{{ __('contact_us.message') }}" rows="5"></textarea>
                                        </div>
                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                        </div>
                                        <input type="hidden" value="submit" name="submit">
                                        <button class="contactus-btn"
                                            type="submit">{{ __('contact_us.submit_btn') }}</button>
                                    </div>
                                </form>

                                <!-- Event Organizer -->
                                <form method="post" action="{{ route('contact-us') }}" id="event-organizer"
                                    class="form contect_us_form" novalidate>
                                    @csrf
                                    <div class="checkboxs">
                                        <div class="checkbox">
                                            <input type="radio" name="host_type" id="isOrgnizer" value="organizer"
                                                checked>
                                            <label for="isOrgnizer"
                                                style="cursor: pointer">{{ __('contact_us.organizer_radio') }}</label>
                                        </div>
                                        <div class="checkbox">
                                            <input type="radio" name="host_type" id="isHost" value="host">
                                            <label for="isHost"
                                                style="cursor: pointer">{{ __('contact_us.host_radio') }}</label>
                                        </div>
                                    </div>
                                    <div id="organizer" class="fields event-organizers active">
                                        <div class="field">
                                            <label for="org_name">{{ __('contact_us.full_name') }}</label>
                                            <input type="hidden" name="contact_type" value="Event Organizer">
                                            <input required type="text" name="name" id="org_name"
                                                placeholder="{{ __('contact_us.full_name') }}">
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="org_email">{{ __('contact_us.email') }}</label>
                                                <input required type="email" name="email" id="org_email"
                                                    placeholder="{{ __('contact_us.email') }}">
                                            </div>
                                            <div class="field">
                                                <label for="org_phone">{{ __('contact_us.phone') }}</label>
                                                <input required type="text" name="phone" id="org_phone"
                                                    placeholder="{{ __('contact_us.phone') }}">
                                            </div>
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="org_company">{{ __('contact_us.organization_name') }}</label>
                                                <input required type="text" name="organization_name" id="org_company"
                                                    placeholder="{{ __('contact_us.organization_name') }}">
                                            </div>
                                            <div class="field">
                                                <label
                                                    for="org_event_location">{{ __('contact_us.event_location') }}</label>
                                                <input required type="text" name="event_location"
                                                    id="org_event_location"
                                                    placeholder="{{ __('contact_us.event_location') }}">
                                            </div>
                                        </div>
                                        <div class="two-fields">
                                            <div class="field">
                                                <label for="org_event_type">{{ __('contact_us.event_type') }}</label>
                                                <select required name="event_type" id="org_event_type">
                                                    <option value="">{{ __('contact_us.select_placeholder') }}
                                                    </option>
                                                    <option value="Corporate">{{ __('contact_us.event_type.corporate') }}
                                                    </option>
                                                    <option value="Wedding">{{ __('contact_us.event_type.wedding') }}
                                                    </option>
                                                    <option value="Festival">{{ __('contact_us.event_type.festival') }}
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="field">
                                                <label
                                                    for="org_est_att">{{ __('contact_us.estimated_attendance') }}</label>
                                                <select required name="estimated_attendance" id="org_est_att">
                                                    <option value="">{{ __('contact_us.select_placeholder') }}
                                                    </option>
                                                    <option value="50-100">
                                                        {{ __('contact_us.estimated_attendance.50_100') }}
                                                    </option>
                                                    <option value="100-200">
                                                        {{ __('contact_us.estimated_attendance.100_200') }}
                                                    </option>
                                                    <option value="200-400">
                                                        {{ __('contact_us.estimated_attendance.200_400') }}
                                                    </option>
                                                    <option value="400-600">
                                                        {{ __('contact_us.estimated_attendance.400_600') }}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="field">
                                            <label
                                                for="org_pref_types">{{ __('contact_us.preferred_product_types') }}</label>
                                            <select required name="preferred_product_types" id="org_pref_types">
                                                <option value="">{{ __('contact_us.select_placeholder') }}</option>
                                                <option value="Candy Stands">
                                                    {{ __('contact_us.preferred_product_types.candy_stands') }}</option>
                                                <option value="Candy Buffets">
                                                    {{ __('contact_us.preferred_product_types.candy_buffets') }}</option>
                                                <option value="Small Giveaways">
                                                    {{ __('contact_us.preferred_product_types.small_giveaways') }}
                                                </option>
                                                <option value="Gift Bags">
                                                    {{ __('contact_us.preferred_product_types.gift_bags') }}
                                                </option>
                                                <option value="Other">
                                                    {{ __('contact_us.preferred_product_types.other') }}</option>
                                            </select>
                                        </div>
                                        <div class="field">
                                            <label for="org_msg">{{ __('contact_us.message') }}</label>
                                            <textarea name="meg" id="org_msg" required placeholder="{{ __('contact_us.message') }}" rows="5"></textarea>
                                        </div>
                                        <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}">
                                        </div>
                                        <input type="hidden" value="submit" name="submit">
                                        <button class="contactus-btn"
                                            type="submit">{{ __('contact_us.submit_btn') }}</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="contactus-infos"
                        style="background-image: url({{ asset('') }}front/assets/images/GoodisetShop.webp); height: 70%; margin-bottom: 24px;">
                        <div class="address-card">
                            <div class="address">
                                <p class="title">{{ __('contact_us.store_locations') }}</p>
                            </div>
                            @foreach ($location as $loc)
                                <div class="address">
                                    <p class="subtitle">
                                        <i class="fa-solid fa-location-dot"></i> &nbsp; <?= $loc->address ?>
                                    </p>
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <div class="contactus-tabs" style="padding: 40px; height: 30%;">
                        <div class="contactus-infos" style="padding: unset !important;">
                            <div class="address-card"
                                style="background: transparent; backdrop-filter: none; width: 100%; gap: 24px; padding: 70px 0">
                                <div class="address">
                                    <p class="title" style="color: #303030;font-size: 24px; font-weight: 600;">
                                        {{ __('contact_us.contact_info') }}</p>
                                </div>
                                <div class="address">
                                    <p class="subtitle" style="color: #303030;"><i class="fa-solid fa-phone"></i> &nbsp;
                                        {{ getSetting('phone') }}</p>
                                    <p class="subtitle" style="color: #303030;"><i class="fa-solid fa-envelope"></i>
                                        &nbsp;
                                        {{ getSetting('email') }}</p>
                                </div>

                                <div class="address">
                                    <p class="title" style="color: #303030;">{{ __('contact_us.follow_us') }}</p>
                                    <div class="social-icons">
                                        <a href="https://www.facebook.com/share/1CkAwUTTgm/?mibextid=wwXIfr"
                                            class="icon" style="border-color: #303030; color: #303030;"><i
                                                class="fa-brands fa-facebook"></i></a>
                                        <a href="https://www.tiktok.com/@goodiset" class="icon"
                                            style="border-color: #303030; color: #303030;"><i
                                                class="fa-brands fa-tiktok"></i></a>
                                        <a href="https://www.instagram.com/goodiset" class="icon"
                                            style="border-color: #303030; color: #303030;"><i
                                                class="fa-brands fa-instagram"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Localized client-side alerts --}}
    <script>
        const MSG_REQUIRED = @json(__('contact_us.validation_required'));
        const MSG_RECAPTCHA = @json(__('contact_us.validation_recaptcha'));
    </script>

    <script src="{{ asset('') }}front/ContactUs.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            function handleFormSubmit(event) {
                event.preventDefault();

                let activeForm = document.querySelector(".form.contect_us_form.active");
                if (!activeForm || !(activeForm instanceof HTMLFormElement)) {
                    alert("Form not found.");
                    return;
                }

                // reCAPTCHA check (within the active form)
                let recaptchaResponse = activeForm.querySelector(".g-recaptcha-response");
                if (!recaptchaResponse || !recaptchaResponse.value) {
                    alert(MSG_RECAPTCHA);
                    return;
                }

                // Validate required fields
                let isValid = true;
                activeForm.querySelectorAll("[required]").forEach((field) => {
                    if (!field.value.trim()) {
                        isValid = false;
                        field.classList.add("error");
                        field.nextElementSibling?.classList.add("error-message");
                    } else {
                        field.classList.remove("error");
                        field.nextElementSibling?.classList.remove("error-message");
                    }
                });

                if (isValid) {
                    HTMLFormElement.prototype.submit.call(activeForm);
                } else {
                    alert(MSG_REQUIRED);
                }
            }

            document.querySelectorAll(".contactus-btn").forEach((button) => {
                button.addEventListener("click", handleFormSubmit);
            });

            document.querySelectorAll(".form.contect_us_form").forEach((form) => {
                form.setAttribute("novalidate", true);
            });
        });
    </script>
@endsection
