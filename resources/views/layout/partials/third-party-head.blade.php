<script>
    function loadThirdPartyScripts() {
        if (window.thirdPartyScriptsLoaded) return;
        window.thirdPartyScriptsLoaded = true;

        // Seoella Code
        (function(window, document, elementTag, widgetName, scriptUrl) {
            window['SeoellaJSWidget'] = widgetName;
            window[widgetName] = window[widgetName] || function() {
                (window[widgetName].q = window[widgetName].q || []).push(arguments);
            };
            var scriptElement = document.createElement(elementTag);
            var firstScriptElement = document.getElementsByTagName(elementTag)[0];
            scriptElement.id = widgetName;
            scriptElement.src = scriptUrl;
            scriptElement.async = true;
            scriptElement.onload = function() {
                window[widgetName]('init', 'ffdee627-6646-44cf-a103-2c45249dae02');
            };
            firstScriptElement.parentNode.insertBefore(scriptElement, firstScriptElement);
        })(window, document, 'script', 'seoella',
            'data:text/javascript;base64,CihmdW5jdGlvbiAod2luZG93LCBkb2N1bWVudCwgZWxlbWVudFRhZywgd2lkZ2V0TmFtZSwgc2NyaXB0VXJsKSB7CiAgd2luZG93WydTZW9lbGxhSlNXaWRnZXQnXSA9IHdpZGdldE5hbWU7CiAgd2luZG93W3dpZGdldE5hbWVdID0gd2luZG93W3dpZGdldE5hbWVdIHx8IGZ1bmN0aW9uICgpIHsKICAgICh3aW5kb3dbd2lkZ2V0TmFtZV0ucSA9IHdpbmRvd1t3aWRnZXROYW1lXS5xIHx8IFtdKS5wdXNoKGFyZ3VtZW50cyk7CiAgfTsKCiAgdmFyIHNjcmlwdEVsZW1lbnQgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KGVsZW1lbnRUYWcpOwogIHZhciBmaXJzdFNjcmlwdEVsZW1lbnQgPSBkb2N1bWVudC5nZXRFbGVtZW50c0J5VGFnTmFtZShlbGVtZW50VGFnKVswXTsKICAKICBzY3JpcHRFbGVtZW50LmlkID0gd2lkZ2V0TmFtZTsKICBzY3JpcHRFbGVtZW50LnNyYyA9IHNjcmlwdFVybDsKICBzY3JpcHRFbGVtZW50LmFzeW5jID0gdHJ1ZTsKCiAgLy8gV2FpdCB1bnRpbCB0aGUgc2NyaXB0IGlzIGZ1bGx5IGxvYWRlZCBiZWZvcmUgY2FsbGluZyBpbml0CiAgc2NyaXB0RWxlbWVudC5vbmxvYWQgPSBmdW5jdGlvbigpIHsKICAgIHdpbmRvd1t3aWRnZXROYW1lXSgnaW5pdCcsICdmZmRlZTYyNy02NjQ2LTQ0Y2YtYTEwMy0yYzQ1MjQ5ZGFlMDInKTsKICB9OwoKICBmaXJzdFNjcmlwdEVsZW1lbnQucGFyZW50Tm9kZS5pbnNlcnRCZWZvcmUoc2NyaXB0RWxlbWVudCwgZmlyc3RTY3JpcHRFbGVtZW50KTsKfSkod2luZG93LCBkb2N1bWVudCwgJ3NjcmlwdCcsICdzZW9lbGxhJywgJ2h0dHBzOi8vc2VvZWxsYS1zdGFnaW5nLnMzLmFtYXpvbmF3cy5jb20vc2NyaXB0X3YxLmpzJyk7Cg=='
        );

        // Google tag (gtag.js)
        // var gtagScript = document.createElement('script');
        // gtagScript.async = true;
        // gtagScript.src = "https://www.googletagmanager.com/gtag/js?id=G-7PDLMFP780";
        // document.head.appendChild(gtagScript);

        // window.dataLayer = window.dataLayer || [];

        // function gtag() {
        //     dataLayer.push(arguments);
        // }
        // gtag('js', new Date());
        // gtag('config', 'G-7PDLMFP780');

        // Google Tag Manager
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-KD4877QQ');

        // Tracking ownership note:
        // Meta and TikTok pixels are intentionally managed directly in this file.
        // To prevent duplicate PageView/events, keep Meta/TikTok tags disabled in GTM.
        // Meta tag manager
        
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '4013696122240068');
        fbq('track', 'PageView');
        try {
            window.dispatchEvent(new CustomEvent('meta-pixel-ready'));
        } catch (e) {}

        // Snap Pixel Code
        (function(e, t, n) {
            if (e.snaptr) return;
            var a = e.snaptr = function() {
                a.handleRequest ? a.handleRequest.apply(a, arguments) : a.queue.push(arguments)
            };
            a.queue = [];
            var s = 'script';
            var r = t.createElement(s);
            r.async = !0;
            r.src = n;
            var u = t.getElementsByTagName(s)[0];
            u.parentNode.insertBefore(r, u);
        })(window, document, 'https://sc-static.net/scevent.min.js');

        snaptr('init', '7f7dc926-46e6-4816-b1d7-a995ba8b43ab', {
            'user_email': '{{ session()->has('user') ? session('user')['email'] : session('cart')['email'] ?? '' }}',
            'user_phone_number': '{{ session()->has('user') ? session('user')['phone'] : session('cart')['phone'] ?? '' }}'
        });
        const c = document.cookie.match(/(?:^|;\s*)uuid_c1=([^;]+)/);
        const uuidC1 = c ? decodeURIComponent(c[1]) : null;

        const pageViewPayload = {
            'user_email': '{{ session()->has('user') ? session('user')['email'] : session('cart')['email'] ?? '' }}',
            'user_phone_number': '{{ session()->has('user') ? session('user')['phone'] : session('cart')['phone'] ?? '' }}'
        };
        if (uuidC1) pageViewPayload.uuid_c1 = uuidC1;

        snaptr('track', 'PAGE_VIEW', pageViewPayload);

        // TikTok Pixel Code
        !function (w, d, t) {
            w.TiktokAnalyticsObject=t;var ttq=w[t]=w[t]||[];ttq.methods=["page","track","identify","instances","debug","on","off","once","ready","alias","group","enableCookie","disableCookie","holdConsent","revokeConsent","grantConsent"],ttq.setAndDefer=function(t,e){t[e]=function(){t.push([e].concat(Array.prototype.slice.call(arguments,0)))}};for(var i=0;i<ttq.methods.length;i++)ttq.setAndDefer(ttq,ttq.methods[i]);ttq.instance=function(t){for(
            var e=ttq._i[t]||[],n=0;n<ttq.methods.length;n++)ttq.setAndDefer(e,ttq.methods[n]);return e},ttq.load=function(e,n){var r="https://analytics.tiktok.com/i18n/pixel/events.js",o=n&&n.partner;ttq._i=ttq._i||{},ttq._i[e]=[],ttq._i[e]._u=r,ttq._t=ttq._t||{},ttq._t[e]=+new Date,ttq._o=ttq._o||{},ttq._o[e]=n||{};n=document.createElement("script")
            ;n.type="text/javascript",n.async=!0,n.src=r+"?sdkid="+e+"&lib="+t;e=document.getElementsByTagName("script")[0];e.parentNode.insertBefore(n,e)};


            ttq.load('D6M0V7BC77UE81ODJ4NG');
            ttq.page();
            }(window, document, 'ttq');

        try {
            window.dispatchEvent(new CustomEvent('third-party-pixel-ready'));
        } catch (e) {}

    }

    // Thank-you / conversion pages: load pixels immediately so Purchase (CompletePayment) is not
    // blocked waiting for interaction or the 5s timer (reduces missed TikTok conversions).
    try {
        var __p = (location.pathname || '');
        if (__p.indexOf('/thanks') !== -1) {
            loadThirdPartyScripts();
        }
    } catch (e) {}

    // Trigger on interaction
    ['mousemove', 'keydown', 'scroll', 'touchstart', 'click'].forEach(event => {
        window.addEventListener(event, loadThirdPartyScripts, {
            once: true,
            passive: true
        });
    });

    // Fallback trigger after 5 seconds
    setTimeout(loadThirdPartyScripts, 5000);
</script>
