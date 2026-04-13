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

        // User identification
        @if (!empty($ttUserData['email']) || !empty($ttUserData['phone_number']) || !empty($ttUserData['external_id']))
            ttq.identify({
                "email": "{{ $ttUserData['email'] }}",
                "phone_number": "{{ $ttUserData['phone_number'] }}",
                "external_id": "{{ $ttUserData['external_id'] }}"
            });
        @endif
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
