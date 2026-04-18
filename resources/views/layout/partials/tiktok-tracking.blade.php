@php
    use App\Helpers\TikTokTracking;
@endphp
<script>
    // TikTok Event Tracking
    function initTikTokTracking() {
        if (typeof ttq === 'undefined') return;

        @php
            $ttUserData = TikTokTracking::getHashedUserData();
            
        @endphp

        // User identification (omit empty fields so TikTok receives only usable hashes)
        var ttIdentify = {};
        @if (! empty($ttUserData['email']))
            ttIdentify.email = @json($ttUserData['email']);
        @endif
        @if (! empty($ttUserData['phone_number']))
            ttIdentify.phone_number = @json($ttUserData['phone_number']);
        @endif
        @if (! empty($ttUserData['external_id']))
            ttIdentify.external_id = @json($ttUserData['external_id']);
        @endif
        if (Object.keys(ttIdentify).length) {
            ttq.identify(ttIdentify);
        }
    }

    // Initialize when ttq is ready
    if (typeof ttq !== 'undefined') {
        initTikTokTracking();
    } else {
        // Fallback: retry when ttq becomes available
        var checkTtq = setInterval(function() {
            if (typeof ttq !== 'undefined') {
                clearInterval(checkTtq);
                initTikTokTracking();
            }
        }, 100);
    }
</script>
