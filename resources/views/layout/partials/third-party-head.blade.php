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

    }

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
