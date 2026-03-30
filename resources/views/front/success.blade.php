@extends('layout.app')
<?php
use App\Models\Catagorie;
use App\Models\Subcatagorie;
use App\Models\Childcatagorie;
use App\Models\Admins\Product;
use App\Models\Gallerie;
use Illuminate\Support\Facades\Session;
use App\Models\Admins\Setting;
use App\Models\Admins\Rating;
use App\Models\Admins\Slider;
?>
@section('content')
    <div class="section contact_us">
        <div class="container">
            <div class="contact_us_wrapper">
                <div class="row">
                    <div class="side_image col-md-6">
                    </div>
                    <div class="form col-md-6" style="display: flex; flex-direction: column; justify-content: center;">
                        <h1 class="section_heading left red">Sweet Success! Your Account is Ready</h1>
                        <div class="form_content" style="margin-top: 20px;">
                            <div class="content_outer">
                                <p style="font-size: 18px; color: #303030; margin-bottom: 30px;">
                                    Start exploring our collection of sweet treats and enjoy member-only perks.
                                </p>
                            </div>
                            <div class="login_form_content">
                                <a href="{{ url('/') }}/login" class="btn btn_primary width_100">
                                    Login to Your Account
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if (!empty($snapPayload))
        <script>
            (function() {
                // Read uuid_c1 cookie if available
                var uuidC1Match = document.cookie.match(/(?:^|;\s*)uuid_c1=([^;]+)/);
                var uuidC1 = uuidC1Match ? decodeURIComponent(uuidC1Match[1]) : null;

                // Build payload from server-passed values
                var basePayload = {
                    sign_up_method: @json($snapPayload['sign_up_method'] ?? 'form')
                };

                // Only add fields if present (avoid sending empty strings)
                var email = @json($snapPayload['user_email'] ?? null);
                if (email) basePayload.user_email = email;

                var phone = @json($snapPayload['user_phone_number'] ?? null);
                if (phone) basePayload.user_phone_number = phone;

                var hem = @json($snapPayload['user_hashed_email'] ?? null);
                if (hem) basePayload.user_hashed_email = hem;

                var hph = @json($snapPayload['user_hashed_phone_number'] ?? null);
                if (hph) basePayload.user_hashed_phone_number = hph;

                if (uuidC1) basePayload.uuid_c1 = uuidC1;

                try {
                    if (typeof snaptr === 'function') {
                        snaptr('track', 'SIGN_UP', basePayload);
                        console.log('Snap SIGN_UP sent:', basePayload);
                    } else {
                        console.warn('snaptr is not defined.');
                    }
                } catch (e) {
                    console.error('Error sending snaptr SIGN_UP event:', e);
                }
            })();
        </script>
    @endif
@endsection
