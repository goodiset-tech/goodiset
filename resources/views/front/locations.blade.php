@extends('layout.app')

@section('content')
    @php
        use App\Models\Admins\Setting;
        $pro = Setting::where(['id' => '1'])->first();
        $locations = \App\Models\Location::all();
    @endphp

    <link rel="stylesheet" href="{{ asset('front/locations.css') }}">

    <!-- ===== HERO SECTION ===== -->
    <x-hero-section :title="$page ? (app()->getLocale() == 'ar' ? $page->name_ar : $page->name) : __('locations.hero_title')" :backgroundImage="asset($page->page_image ? 'img/slider/' . $page->page_image : 'front/assets/images/faqsheroimage.png')" :subTitle="$page ? (app()->getLocale() == 'ar' ? $page->sub_title_ar : $page->sub_title) : ''" />

    <!-- ===== STORES SECTION ===== -->
    <section class="container">
        <div class="section-title">
            <h2 class="section_heading center red n_m_b">{{ __('locations.visit_title') }}</h2>
            @if (isset($locations) && $locations->count())
                <div class="container">
                    <div class="map-wrapper">
                        <div id="map"></div>
                    </div>
                </div>
            @endif
    </section>
    <!-- ===== FAQ SECTION ===== -->
    <section class="faq-section">
        <div class="container">
            <h2 class="section_heading center red n_m_b">{{ __('locations.faq_title') }}</h2>
            <p class="section_subheading center">{{ __('locations.faq_subtitle') }}</p>
            @foreach ($faqs as $faq)
                <div class="faq-item">
                    <h5>{{ app()->isLocale('ar') ? $faq->question_ar : $faq->question }}</h5>
                    <div class="faq-answer">{{ app()->isLocale('ar') ? $faq->answer_ar : $faq->answer }}</div>
                </div>
            @endforeach
        </div>
    </section>


    {{-- ✅ GOOGLE MAPS ASYNC LOADER (ONLY ONCE PER PAGE) --}}
    {{-- GOOGLE MAPS LOADER (SAFE, ONCE) --}}
    <script>
        if (!window._gmapsLoaded) {
            window._gmapsLoaded = new Promise((resolve, reject) => {
                window.initMap = resolve;

                const script = document.createElement('script');
                script.src =
                    'https://maps.googleapis.com/maps/api/js' +
                    '?key=AIzaSyASCMQagE0IHqYPiniGuCf-_jh5XHlwMy8' +
                    '&libraries=places,marker' +
                    '&language={{ app()->getLocale() }}' +
                    '&callback=initMap';

                script.async = true;
                script.defer = true;
                script.onerror = reject;
                document.head.appendChild(script);
            });
        }
    </script>

    <script>
        (async () => {
            await window._gmapsLoaded;

            const locations = @json($locations);
            if (!locations || !locations.length) return;

            // logo URL: use site setting if present, fallback to theme logo
            const logoUrl =
                "{{ $pro && ($pro->site_logo ?? $pro->logo) ? asset($pro->site_logo ?? $pro->logo) : asset('front/assets/images/logo.png') }}";

            const map = new google.maps.Map(document.getElementById('map'), {
                zoom: 11,
                center: {
                    lat: Number(locations[0].latitude),
                    lng: Number(locations[0].longitude),
                },
            });

            const bounds = new google.maps.LatLngBounds();
            const infoWindow = new google.maps.InfoWindow();
            const directionsText = "{{ __('locations.directions') }}";

            const placesService = new google.maps.places.PlacesService(map);
            const directionsService = new google.maps.DirectionsService();
            const directionsRenderer = new google.maps.DirectionsRenderer({
                suppressMarkers: true
            });
            directionsRenderer.setMap(map);

            function makeLogoMarkerDataUrl(logoUrl, size = 64) {
                return new Promise((resolve) => {
                    const canvas = document.createElement('canvas');
                    canvas.width = size;
                    canvas.height = size;
                    const ctx = canvas.getContext('2d');

                    // Draw red heart shape
                    const heartPath = new Path2D();
                    const w = size / 2;
                    heartPath.moveTo(w, w + 8);
                    heartPath.bezierCurveTo(w - 12, w - 5, w - 20, w - 10, w - 20, w - 15);
                    heartPath.bezierCurveTo(w - 20, w - 22, w - 14, w - 28, w - 8, w - 28);
                    heartPath.bezierCurveTo(w - 2, w - 28, w + 2, w - 24, w, w - 20);
                    heartPath.bezierCurveTo(w - 2, w - 24, w - 2, w - 28, w + 8, w - 28);
                    heartPath.bezierCurveTo(w + 14, w - 28, w + 20, w - 22, w + 20, w - 15);
                    heartPath.bezierCurveTo(w + 20, w - 10, w + 12, w - 5, w, w + 8);
                    ctx.fillStyle = '#c62828';
                    ctx.fill(heartPath);
                    ctx.strokeStyle = '#8b1f1f';
                    ctx.lineWidth = 1;
                    ctx.stroke(heartPath);

                    // Draw white circle background
                    ctx.fillStyle = '#ffffff';
                    ctx.beginPath();
                    ctx.arc(w, w - 5, 12, 0, Math.PI * 2);
                    ctx.fill();

                    // Load and draw logo
                    const img = new Image();
                    img.crossOrigin = 'anonymous';
                    img.onload = () => {
                        ctx.save();
                        ctx.beginPath();
                        ctx.arc(w, w - 5, 10, 0, Math.PI * 2);
                        ctx.clip();
                        ctx.drawImage(img, w - 10, w - 15, 20, 20);
                        ctx.restore();
                        resolve(canvas.toDataURL());
                    };
                    img.onerror = () => {
                        // If logo fails to load, just resolve with heart
                        resolve(canvas.toDataURL());
                    };
                    img.src = logoUrl;
                });
            }

            const svgUrl = makeLogoMarkerDataUrl(logoUrl, 64);
            const defaultIcon = {
                url: svgUrl,
                scaledSize: new google.maps.Size(90, 90),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(28, 56)
            };

            function createInfoContent(data) {
                const photoHtml = data.photo ?
                    `<div style="margin-bottom:8px"><img src="${data.photo}" style="width:100%;height:140px;object-fit:cover;border-radius:8px"></div>` :
                    '';
                const ratingHtml = data.rating ?
                    `<div style="margin:6px 0;color:#f5a623">${'⭐'.repeat(Math.round(data.rating))} <span style="color:#333">(${data.rating})</span></div>` :
                    '';
                const addressHtml = data.address ?
                    `<div style="color:#666;margin-bottom:6px">${data.address}</div>` : '';

                return `
                    <div style="font-family:inherit;max-width:300px;padding:0px 12px 12px 0px;">
                        ${photoHtml}
                        <h4 style="margin:0 0 6px 0;color:#c62828">${data.name || ''}</h4>
                        ${addressHtml}
                        ${ratingHtml}
                        <div style="display:flex;gap:8px;margin-top:8px">
                            <button class="gm-directions-btn" data-query="${encodeURIComponent(data.name + ' ' + (data.address || ''))}" style="flex:1;padding:8px;border-radius:6px;border:0;background:#c62828;color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px">
                               <span style="font-weight:600">${directionsText}</span>
                            </button>
                        </div>
                    </div>
                `;
            }

            // store markers for reference
            const markers = [];

            for (const loc of locations) {
                const position = {
                    lat: Number(loc.latitude),
                    lng: Number(loc.longitude)
                };
                bounds.extend(position);

                const marker = new google.maps.Marker({
                    position,
                    map,
                    title: loc.location_name || '',
                    icon: defaultIcon,
                    zIndex: 999
                });

                markers.push(marker);

                // prepare basic data
                const basic = {
                    name: loc.location_name || '',
                    address: loc.address || loc.location_address || '',
                    rating: loc.rating || null,
                    photo: loc.image ? loc.image : null,
                    lat: position.lat,
                    lng: position.lng,
                    placeId: loc.google_place_id || null
                };

                // if google_place_id exists, fetch richer details
                if (loc.google_place_id) {
                    placesService.getDetails({
                        placeId: loc.google_place_id,
                        fields: ['name', 'formatted_address', 'rating', 'photos', 'geometry']
                    }, (place, status) => {
                        const data = Object.assign({}, basic);
                        if (status === google.maps.places.PlacesServiceStatus.OK && place) {
                            data.name = place.name || data.name;
                            data.address = place.formatted_address || data.address;
                            data.rating = place.rating || data.rating;
                            if (place.photos && place.photos.length) data.photo = place.photos[0].getUrl({
                                maxWidth: 400
                            });
                        }

                        marker.addListener('click', () => {
                            infoWindow.setContent(createInfoContent(data));
                            infoWindow.open(map, marker);
                        });
                    });
                } else {
                    marker.addListener('click', () => {
                        infoWindow.setContent(createInfoContent(basic));
                        infoWindow.open(map, marker);
                    });
                }
            }

            map.fitBounds(bounds, {
                padding: 80
            });

            // delegate directions button clicks from infoWindow — open Google Maps search (previous "Open" link)
            google.maps.event.addListener(infoWindow, 'domready', () => {
                document.querySelectorAll('.gm-directions-btn').forEach(btn => {
                    if (btn._bound) return; // avoid double-bind
                    btn._bound = true;
                    btn.addEventListener('click', (e) => {
                        const query = btn.dataset.query || '';
                        const url =
                            `https://www.google.com/maps/search/?api=1&query=${query}`;
                        window.open(url, '_blank');
                    });
                });
            });

        })();
    </script>
@endsection
