        <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
        <script>
            var page_link = '{{ $_SERVER['REQUEST_URI'] }}';
            var options = {
                "enabled": true,
                "chatButtonSetting": {
                    "backgroundColor": "#4dc247",
                    "ctaText": "",
                    "borderRadius": "50", // This value will now be used for a circular button
                    "marginLeft": "0",
                    "marginBottom": "10",
                    "marginRight": "20",
                    "position": "right"
                },
                "brandSetting": {
                    "brandName": "{{ $Site->site_title }}",
                    "brandSubTitle": "Typically replies within a day",
                    "brandImg": "{{ asset('') }}{{ getSetting('logo') }}",
                    "welcomeText": "Hi, there!\nHow can I help you?",
                    "messageText": "Hello, I have a question about {{ url('/') . $_SERVER['REQUEST_URI'] }}",
                    "backgroundColor": "#0a5f54",
                    "ctaText": "Start Chat",
                    "borderRadius": "50",
                    "autoShow": false,
                    "phoneNumber": "+971547000534"
                }
            };

            function redirectToWhatsApp() {
                var message = encodeURIComponent(options.brandSetting.messageText);
                var phoneNumber = options.brandSetting.phoneNumber.replace(/\s+/g, '');
                var whatsappUrl = `https://wa.me/${phoneNumber}?text=${message}`;
                window.location.href = whatsappUrl; // Redirects to WhatsApp
            }

            function createWhatsAppButton() {
                var button = document.createElement('button');
                button.innerHTML = `
                   <i class="fab fa-whatsapp" style="color: white; font-size: 20px;"></i>
                `;
                button.setAttribute('title', 'WhatsApp Chat');
                button.style.backgroundColor = options.chatButtonSetting.backgroundColor;
                button.style.borderRadius = "10px"; // Makes the button circular
                button.style.width = "50px"; // Set button width
                button.style.height = "50px"; // Set button height
                button.style.position = "fixed";
                button.style.zIndex = "1000";
                button.style.bottom = options.chatButtonSetting.marginBottom + "px";
                button.style.right = options.chatButtonSetting.marginRight + "px";
                button.style.border = "none";
                button.style.display = "flex";
                button.style.alignItems = "center";
                button.style.justifyContent = "center";
                button.style.cursor = "pointer";
                button.onclick = redirectToWhatsApp;

                document.body.appendChild(button);
            }

            // Defer non-critical DOM manipulation to idle time
            if ('requestIdleCallback' in window) {
                window.requestIdleCallback(createWhatsAppButton);
            } else {
                setTimeout(createWhatsAppButton, 3000);
            }
        </script>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script type="text/javascript" src="https://unpkg.com/default-passive-events"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
        {{-- <script src="{{ asset('') }}front/swiper-bundle.min.js"></script> --}}
        <script src="{{ asset('') }}front/script.js"></script>
        <script>
            (function() {
                const __pcSetQtyUrl = @json(url('/cart/set-qty'));
                const __pcCsrf = @json(csrf_token());
                const __pcToastProductAdded = @json(__('cart.toast.product_added'));

                window.productCardSyncCartLine = function(pid) {
                    const sid = String(pid);
                    const spec = document.getElementById('spec' + sid);
                    if (!spec) return Promise.resolve();
                    const units = parseInt(spec.value, 10) || 1;
                    return fetch(__pcSetQtyUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': __pcCsrf,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                id: sid,
                                qty: units
                            }),
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(data) {
                            if (data.error && typeof toastr !== 'undefined') {
                                toastr.error(data.error_data || 'Unable to update quantity');
                                return data;
                            }
                            if (data.cart && typeof data.cart.qty !== 'undefined') {
                                document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                    .forEach(
                                        function(el) {
                                            el.innerHTML = data.cart.qty;
                                        });
                            }
                            if (data.cart && data.cart.items) {
                                const rawItems = data.cart.items;
                                const list = Array.isArray(rawItems) ? rawItems : Object.values(rawItems);
                                const row = list.find(function(x) {
                                    return String(x.id) === String(sid);
                                });
                                if (row && spec) {
                                    spec.value = String(row.qty);
                                    const gramsBar = document.querySelector(
                                        '.product-card__pre-qty[data-product-id="' + sid + '"]');
                                    const isG = gramsBar && gramsBar.getAttribute('data-qty-grams') === '1';
                                    const disp = isG ? (parseInt(row.qty, 10) * 100) : parseInt(row.qty, 10);
                                    var qIn = document.getElementById('quantity' + sid);
                                    if (qIn) qIn.value = String(disp);
                                    var pIn = document.getElementById('product-pre-qty-in-' + sid);
                                    if (pIn) pIn.value = String(disp);
                                }
                            }
                            if (typeof window.productCardUpdateQtyChrome === 'function') {
                                window.productCardUpdateQtyChrome(sid);
                            }
                            if (!data.error && data.cart) {
                                if (typeof showToastr === 'function') {
                                    showToastr(__pcToastProductAdded, 'success');
                                } else if (typeof toastr !== 'undefined') {
                                    toastr.success(__pcToastProductAdded);
                                }
                            }
                            return data;
                        })
                        .catch(function() {
                            return {};
                        });
                };

                window.productCardUpdateQtyChrome = function(productId) {
                    const id = String(productId);
                    const bar = document.querySelector('.product-card__pre-qty[data-product-id="' + id + '"]');
                    if (!bar) return;
                    const stack = bar.closest('.product-card__buy-stack');
                    const inCart = stack && stack.getAttribute('data-line-in-cart') === '1';
                    const spec = document.getElementById('spec' + id);
                    const units = spec ? (parseInt(spec.value, 10) || 1) : 1;
                    const del = bar.querySelector('.product-card__pre-del');
                    const minus = bar.querySelector('.product-card__qty-btn--minus');
                    const hide = 'product-card__qty-side--hide';
                    if (!minus) return;
                    if (!inCart) {
                        if (del) del.classList.add(hide);
                        minus.classList.remove(hide);
                        return;
                    }
                    if (units <= 1) {
                        if (del) del.classList.remove(hide);
                        minus.classList.add(hide);
                    } else {
                        if (del) del.classList.add(hide);
                        minus.classList.remove(hide);
                    }
                };

                window.productCardSetLineState = function(productId, inCart, row) {
                    const id = String(productId);
                    const stack = document.querySelector('.add-to-cart' + id + '.product-card__buy-stack');
                    if (!stack) return false;
                    const addBtn = stack.querySelector('.product-card__add-btn');
                    const sold = stack.getAttribute('data-soldout') === '1';
                    const bar = stack.querySelector('.product-card__pre-qty[data-product-id="' + id + '"]');
                    if (inCart) {
                        stack.setAttribute('data-line-in-cart', '1');
                        if (addBtn) addBtn.disabled = !!sold;
                        if (row && bar) {
                            const spec = document.getElementById('spec' + id);
                            const isGram = bar.getAttribute('data-qty-grams') === '1';
                            const disp = isGram ? (parseInt(row.qty, 10) * 100) : parseInt(row.qty, 10);
                            if (spec) spec.value = String(row.qty);
                            const pre = document.getElementById('product-pre-qty-in-' + id);
                            if (pre) pre.value = String(disp);
                        }
                    } else {
                        stack.setAttribute('data-line-in-cart', '0');
                        if (addBtn) addBtn.disabled = sold;
                        const spec = document.getElementById('spec' + id);
                        if (spec) spec.value = '1';
                        if (bar) {
                            const isGram = bar.getAttribute('data-qty-grams') === '1';
                            const pre = document.getElementById('product-pre-qty-in-' + id);
                            if (pre) pre.value = isGram ? '100' : '1';
                        }
                    }
                    if (typeof window.productCardUpdateQtyChrome === 'function') {
                        window.productCardUpdateQtyChrome(id);
                    }
                    return true;
                };

                window.productCardStepQty = function(id, delta) {
                    const sid = String(id);
                    const bar = document.querySelector('.product-card__pre-qty[data-product-id="' + sid + '"]');
                    if (!bar) return;
                    const spec = document.getElementById('spec' + sid);
                    const inp = document.getElementById('product-pre-qty-in-' + sid);
                    if (!spec || !inp) return;
                    const isGram = bar.getAttribute('data-qty-grams') === '1';
                    const maxUnits = parseInt(bar.getAttribute('data-max-units') || '9999', 10) || 9999;
                    let u = parseInt(spec.value, 10) || 1;
                    u += delta;
                    if (u < 1) u = 1;
                    if (u > maxUnits) u = maxUnits;
                    spec.value = String(u);
                    inp.value = String(isGram ? u * 100 : u);
                    if (typeof window.productCardUpdateQtyChrome === 'function') {
                        window.productCardUpdateQtyChrome(sid);
                    }
                };

                document.addEventListener('change', function(e) {
                    const inp = e.target;
                    if (!inp.classList || !inp.classList.contains('product-card__pre-qty-input')) return;
                    const bar = inp.closest('.product-card__pre-qty');
                    if (!bar) return;
                    const pid = bar.getAttribute('data-product-id');
                    const spec = document.getElementById('spec' + pid);
                    if (!spec) return;
                    const isGram = bar.getAttribute('data-qty-grams') === '1';
                    const maxUnits = parseInt(bar.getAttribute('data-max-units') || '9999', 10) || 9999;
                    let raw = parseInt(String(inp.value).trim(), 10);
                    if (Number.isNaN(raw) || raw < 1) {
                        raw = isGram ? 100 : 1;
                    }
                    if (isGram) {
                        raw = Math.round(raw / 100) * 100;
                        if (raw < 100) raw = 100;
                        const maxG = maxUnits * 100;
                        if (raw > maxG) raw = maxG;
                        inp.value = String(raw);
                        spec.value = String(raw / 100);
                    } else {
                        if (raw > maxUnits) raw = maxUnits;
                        if (raw < 1) raw = 1;
                        inp.value = String(raw);
                        spec.value = String(raw);
                    }
                    if (typeof window.productCardUpdateQtyChrome === 'function') {
                        window.productCardUpdateQtyChrome(pid);
                    }
                });

                window.refreshCartUiFromSession = function() {
                    return fetch(@json(url('/cart/ui-state')), {
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'application/json',
                            },
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(payload) {
                            var qty = payload.qty != null ? String(payload.qty) : '0';
                            document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                .forEach(
                                    function(el) {
                                        if (el) el.innerHTML = qty;
                                    });
                            var lineMap = {};
                            (payload.lines || []).forEach(function(l) {
                                lineMap[String(l.id)] = l.qty;
                            });
                            document.querySelectorAll('.product-card__buy-stack[data-card-product-id]')
                                .forEach(function(stack) {
                                    var pid = String(stack.getAttribute('data-card-product-id'));
                                    var rowQty = lineMap[pid];
                                    if (rowQty != null && rowQty > 0) {
                                        if (typeof window.productCardSetLineState === 'function') {
                                            window.productCardSetLineState(pid, true, {
                                                id: parseInt(pid, 10),
                                                qty: rowQty
                                            });
                                        }
                                    } else if (typeof window.productCardSetLineState === 'function') {
                                        window.productCardSetLineState(pid, false, null);
                                    }
                                });
                            var __cdr = document.getElementById('cartDrawerRoot');
                            if (__cdr && __cdr.classList.contains('cart-drawer-open') &&
                                typeof window.reloadCartDrawerContent === 'function') {
                                window.reloadCartDrawerContent();
                            }
                            return payload;
                        })
                        .catch(function() {
                            return {};
                        });
                };

                window.addEventListener('pageshow', function(ev) {
                    if (!ev.persisted) return;
                    if (typeof window.refreshCartUiFromSession !== 'function') return;
                    window.refreshCartUiFromSession().then(function() {
                        if (typeof fetchProducts === 'function') {
                            try {
                                fetchProducts();
                            } catch (err) {}
                        }
                    });
                });
            })();
        </script>
        <script>
            (function() {
                var root = document.getElementById('cartDrawerRoot');
                var backdrop = document.getElementById('cartDrawerBackdrop');
                var panel = document.getElementById('cartDrawerPanel');
                var bodyEl = document.getElementById('cartDrawerBody');
                var closeBtn = document.getElementById('cartDrawerClose');
                var cartDrawerLinks = document.querySelectorAll('a[data-cart-drawer-url]');
                if (!root || !backdrop || !panel || !bodyEl || !cartDrawerLinks.length) {
                    return;
                }

                var drawerUrl = cartDrawerLinks[0].getAttribute('data-cart-drawer-url') || '';
                var csrfDrawer = @json(csrf_token());
                var urlInc = @json(url('/cart/increment'));
                var urlDec = @json(url('/cart/decrement'));
                var urlRemove = @json(url('/cart/remove'));
                var urlAdd = @json(url('/cart/add'));

                function postCart(path, data) {
                    var fd = new FormData();
                    fd.append('_token', csrfDrawer);
                    Object.keys(data).forEach(function(k) {
                        if (data[k] !== undefined && data[k] !== null) {
                            fd.append(k, data[k]);
                        }
                    });
                    return fetch(path, {
                        credentials: 'same-origin',
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: fd,
                        method: 'POST'
                    }).then(function(r) {
                        return r.json();
                    });
                }

                function closeCartDrawer() {
                    root.classList.remove('cart-drawer-open');
                    root.setAttribute('aria-hidden', 'true');
                    panel.setAttribute('aria-hidden', 'true');
                    document.body.style.overflow = '';
                    bodyEl.innerHTML = '';
                }

                window.reloadCartDrawerContent = function() {
                    if (!drawerUrl) return Promise.resolve();
                    bodyEl.classList.add('is-loading');
                    return fetch(drawerUrl, {
                            credentials: 'same-origin',
                            headers: {
                                'Accept': 'text/html'
                            },
                        })
                        .then(function(r) {
                            if (!r.ok) throw new Error('drawer');
                            return r.text();
                        })
                        .then(function(html) {
                            bodyEl.innerHTML = html;
                            bodyEl.classList.remove('is-loading');
                        })
                        .catch(function() {
                            bodyEl.classList.remove('is-loading');
                        });
                };

                window.openCartDrawer = function() {
                    root.classList.add('cart-drawer-open');
                    root.setAttribute('aria-hidden', 'false');
                    panel.setAttribute('aria-hidden', 'false');
                    document.body.style.overflow = 'hidden';
                    bodyEl.innerHTML = '<p class="cart-drawer-loading-msg" style="padding:24px;text-align:center;">' +
                        @json(__('cart.drawer.loading')) + '</p>';
                    return window.reloadCartDrawerContent().then(function() {
                        if (closeBtn) closeBtn.focus();
                    });
                };

                cartDrawerLinks.forEach(function(link) {
                    link.addEventListener('click', function(e) {
                        if (e.defaultPrevented) return;
                        if (e.button !== 0) return;
                        if (e.metaKey || e.ctrlKey || e.shiftKey || e.altKey) return;
                        e.preventDefault();
                        window.openCartDrawer();
                    });
                });

                closeBtn.addEventListener('click', function() {
                    closeCartDrawer();
                });
                backdrop.addEventListener('click', function() {
                    closeCartDrawer();
                });
                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape' && root.classList.contains('cart-drawer-open')) {
                        closeCartDrawer();
                    }
                });

                document.addEventListener('click', function(e) {
                    var c = e.target;
                    if (!root.classList.contains('cart-drawer-open')) return;
                    if (c.closest && c.closest('[data-cart-drawer-continue]')) {
                        e.preventDefault();
                        closeCartDrawer();
                        return;
                    }
                    var incP = c.closest && c.closest('.cart-drawer-inc-prod');
                    if (incP) {
                        e.preventDefault();
                        postCart(urlInc, {
                            id: incP.getAttribute('data-product-id'),
                            boxid: ''
                        }).then(function(res) {
                            if (res.error) {
                                alert(res.error_data || 'Error');
                                return;
                            }
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                    var decP = c.closest && c.closest('.cart-drawer-dec-prod');
                    if (decP) {
                        e.preventDefault();
                        postCart(urlDec, {
                            id: decP.getAttribute('data-product-id'),
                            boxid: ''
                        }).then(function(res) {
                            if (res.error) {
                                alert(res.error_data || 'Error');
                                return;
                            }
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                    var rmP = c.closest && c.closest('.cart-drawer-remove-prod');
                    if (rmP) {
                        e.preventDefault();
                        postCart(urlRemove, {
                            id: rmP.getAttribute('data-product-id'),
                            boxId: ''
                        }).then(function() {
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                    var incB = c.closest && c.closest('.cart-drawer-inc-box');
                    if (incB) {
                        e.preventDefault();
                        postCart(urlInc, {
                            id: '',
                            boxid: incB.getAttribute('data-box-id')
                        }).then(function(res) {
                            if (res.error) {
                                alert(res.error_data || 'Error');
                                return;
                            }
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                    var decB = c.closest && c.closest('.cart-drawer-dec-box');
                    if (decB) {
                        e.preventDefault();
                        postCart(urlDec, {
                            id: '',
                            boxid: decB.getAttribute('data-box-id')
                        }).then(function(res) {
                            if (res.error) {
                                alert(res.error_data || 'Error');
                                return;
                            }
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                    var rmB = c.closest && c.closest('.cart-drawer-remove-box');
                    if (rmB) {
                        e.preventDefault();
                        postCart(urlRemove, {
                            id: '',
                            boxId: rmB.getAttribute('data-box-id')
                        }).then(function() {
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                    var addU = c.closest && c.closest('.cart-drawer-upsell-add');
                    if (addU) {
                        e.preventDefault();
                        postCart(urlAdd, {
                            id: addU.getAttribute('data-product-id'),
                            qty: 1
                        }).then(function(res) {
                            if (res.error || res.msg_type === 'danger') {
                                alert((res.error_data || res.msg) || 'Error');
                                return;
                            }
                            window.reloadCartDrawerContent();
                            if (typeof window.refreshCartUiFromSession === 'function') {
                                window.refreshCartUiFromSession();
                            }
                        });
                        return;
                    }
                });
            })();
        </script>
        <script>
            (function() {
                const setQtyUrl = @json(url('/cart/set-qty'));
                const csrf = @json(csrf_token());

                document.addEventListener('focusin', function(e) {
                    const input = e.target;
                    if (!input.classList || !input.classList.contains('quantity_cart')) return;
                    if (input.tagName !== 'INPUT') return;
                    input.dataset.qtyPrev = input.value;
                }, true);

                document.addEventListener('change', function(e) {
                    const input = e.target;
                    if (!input.classList || !input.classList.contains('quantity_cart')) return;
                    if (input.tagName !== 'INPUT') return;
                    const box = input.closest('.quantity-controls');
                    if (!box || input.dataset.qtyCommitting === '1') return;

                    const productId = input.dataset.productId;
                    if (!productId) return;

                    const isGram = box.dataset.qtyGrams === '1';
                    const maxUnits = parseInt(box.dataset.productQtyMax || '0', 10) || 999999;

                    let raw = parseInt(String(input.value).trim(), 10);
                    if (Number.isNaN(raw) || raw < 1) {
                        input.value = input.dataset.qtyPrev != null ? input.dataset.qtyPrev : input
                            .defaultValue;
                        return;
                    }

                    if (isGram) {
                        raw = Math.round(raw / 100) * 100;
                        if (raw < 100) raw = 100;
                        const maxG = maxUnits * 100;
                        if (raw > maxG) raw = maxG;
                        input.value = String(raw);
                    } else {
                        if (raw > maxUnits) raw = maxUnits;
                        if (raw < 1) raw = 1;
                        input.value = String(raw);
                    }

                    const units = isGram ? raw / 100 : raw;
                    const spec = document.getElementById('spec' + productId);
                    const prevUnits = spec ? parseInt(spec.value, 10) || 0 : 0;

                    if (units === prevUnits) return;

                    input.dataset.qtyCommitting = '1';
                    fetch(setQtyUrl, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrf,
                                'Accept': 'application/json',
                            },
                            body: JSON.stringify({
                                id: productId,
                                qty: units
                            }),
                        })
                        .then(function(r) {
                            return r.json();
                        })
                        .then(function(data) {
                            delete input.dataset.qtyCommitting;
                            if (data.error) {
                                if (typeof toastr !== 'undefined') {
                                    toastr.error(data.error_data || 'Unable to update quantity');
                                }
                                if (input.dataset.qtyPrev != null) input.value = input.dataset.qtyPrev;
                                return;
                            }
                            const cart = data.cart;

                            if (cart && typeof cart.qty !== 'undefined') {
                                document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                    .forEach(
                                        function(el) {
                                            el.innerHTML = cart.qty;
                                        });
                            }

                            if (!cart || !Array.isArray(cart.items)) {
                                location.reload();
                                return;
                            }

                            const row = cart.items.find(function(it) {
                                return String(it.id) === String(productId);
                            });

                            if (!row) {
                                if (typeof window.productCardSetLineState === 'function') {
                                    window.productCardSetLineState(productId, false);
                                }
                                var qtyBox = document.querySelector('.quantity_btn_box' + productId);
                                var addBtn = document.querySelector('.add-to-cart' + productId);
                                if (qtyBox) {
                                    qtyBox.style.display = 'none';
                                    if (addBtn && !addBtn.classList.contains('product-card__buy-stack')) {
                                        addBtn.style.display = 'block';
                                    }
                                }
                                if (spec) spec.value = '1';
                                return;
                            }

                            var line = parseInt(row.qty, 10) || 1;
                            if (spec) spec.value = String(line);
                            if (isGram) {
                                input.value = String(line * 100);
                            } else {
                                input.value = String(line);
                            }
                            var preSync = document.getElementById('product-pre-qty-in-' + productId);
                            if (preSync) {
                                preSync.value = isGram ? String(line * 100) : String(line);
                            }
                            var stSync = document.querySelector('.product-card__pre-qty[data-product-id="' +
                                productId + '"]');
                            if (stSync) {
                                var buySync = stSync.closest('.product-card__buy-stack');
                                if (buySync) buySync.setAttribute('data-line-in-cart', '1');
                            }
                            if (typeof window.productCardUpdateQtyChrome === 'function') {
                                window.productCardUpdateQtyChrome(productId);
                            }
                        })
                        .catch(function() {
                            delete input.dataset.qtyCommitting;
                            if (input.dataset.qtyPrev != null) input.value = input.dataset.qtyPrev;
                        });
                });
            })();
        </script>
        <script src="{{ asset('front/assets/confettis.js') }}"></script>
        <script src="{{ asset('front/assets/slider.js') }}"></script>

        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        @if (request()->is('contact-us') ||
                request()->is('login') ||
                request()->is('user_register') ||
                request()->is('about-us') ||
                request()->is('influencers') ||
                request()->is('retailer-reseller') ||
                request()->is('corporate-events') ||
                request()->is('celebrations'))
            <script src="https://www.google.com/recaptcha/api.js" async defer></script>
        @endif
        {{-- <script>
            document.getElementById('selector-btn').addEventListener('click', function() {
                document.getElementById('lang-dropdown').classList.toggle('show');
            });

            // LOCALE SWITCHER
            document.querySelectorAll('.option.language').forEach(option => {
                option.addEventListener('click', function() {
                    const locale = this.getAttribute('data-locale');

                    fetch('{{ route('locale.switch') }}', {
                            method: 'POST',
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                "Content-Type": "application/json",
                                "Accept": "application/json"
                            },
                            body: JSON.stringify({
                                locale
                            })
                        })
                        .then(res => res.json())
                        .then(() => location.reload())
                        .catch(() => location.reload());
                });
            });

            // Unique IDs
            const selectorBtn = document.getElementById("selector-btn");
            const dropdown = document.getElementById("lang-dropdown");
            const selectedText = document.getElementById("selected-text");
            const selectedFlag = document.getElementById("selected-flag");

            $(selectorBtn).on("click", function() {
                $(dropdown).toggleClass("open");
            });

            // Close when clicking outside
            document.addEventListener("click", (e) => {
                if (!document.getElementById("lang-selector").contains(e.target)) {
                    dropdown.classList.remove("open");
                }
            });

            // Function to handle selection
            function selectOption(type, clickedOption) {
                // Remove selected class from same group
                document.querySelectorAll(`.option.${type}`).forEach(opt => {
                    opt.classList.remove("selected");
                    const tick = opt.querySelector(".tick");
                    if (tick) tick.remove();
                });

                // Add selected class to clicked
                clickedOption.classList.add("selected");

                // Add tick mark if missing
                if (!clickedOption.querySelector(".tick")) {
                    const tick = document.createElement("span");
                    tick.className = "tick";
                    tick.textContent = "✔";
                    clickedOption.appendChild(tick);
                }
            }

            // Country Select
            document.querySelectorAll(".option.country").forEach(option => {
                option.addEventListener("click", () => {
                    selectOption("country", option);
                    const flag = option.getAttribute("data-flag");
                    selectedFlag.src = flag; // Update top flag
                });
            });

            // Language Select
            document.querySelectorAll(".option.language").forEach(option => {
                option.addEventListener("click", () => {
                    selectOption("language", option);
                    const lang = option.getAttribute("data-value");
                    selectedText.textContent = lang; // Update top text
                });
            });
        </script> --}}
        <script>
            // document.addEventListener('DOMContentLoaded', function() {
            //     setTimeout(function() {
            //         const loader = document.querySelector('.loader');
            //         loader.style.display = 'none'; // Hides the loader after 0.5 seconds
            //     }, 500); // 500 milliseconds = 0.5 seconds
            // });
        </script>

        <script>
            document.querySelectorAll('.faq-item').forEach(item => {
                item.addEventListener('click', () => item.classList.toggle('active'));
            });

            $(document).ready(function() {
                $('#subscribeForm').on('submit', function(e) {
                    e.preventDefault(); // Prevent the form from submitting normally

                    // Clear previous error messages
                    $('.error-message').hide().text('');

                    // Reset previous error states
                    $('#email').removeClass('error-border');
                    $('#recaptcha').removeClass('error-border');
                    $('#email-error').hide().text('');
                    $('#recaptcha-error').hide().text('');

                    // Validate email
                    var email = $('#email').val().trim();
                    if (email.length === 0) {
                        $('#email').addClass('error-border');
                        $('#error-message').text('Please enter your email.').show();
                        return;
                    }

                    // Validate reCAPTCHA
                    var recaptchaResponse = grecaptcha.getResponse();
                    if (recaptchaResponse.length === 0) {
                        $('#recaptcha').addClass('error-border');
                        $('#error-message').text('Please complete the reCAPTCHA.').show();
                        return;
                    }

                    // Send AJAX request
                    $.ajax({
                        url: '{{ url('/subscribe') }}', // Replace with your backend endpoint
                        type: 'POST',
                        data: {
                            email: email,
                            recaptcha: recaptchaResponse,
                            _token: '{{ csrf_token() }}' // Add CSRF token for Laravel
                        },
                        success: function(response) {
                            if (response.success) {
                                $('#get_off_popup').hide();
                                const popup = document.getElementById('popup');
                                const overlay = document.getElementById('overlay');
                                popup.classList.add('active');
                                overlay.classList.add('active');
                                // Hide the popup
                            } else {
                                $('#error-message').text(response.message)
                                    .show(); // Show error message
                            }
                        },
                        error: function(xhr) {
                            $('#error-message').text('An error occurred. Please try again.').show();
                        }
                    });
                });

                $('#email').on('input', function() {
                    $(this).removeClass('error-border');
                    $('#email-error').hide();
                });
            });
        </script>



        <script>
            $(document).ready(function() {
                // Debounce function to limit AJAX calls
                function debounce(func, wait) {
                    let timeout;
                    return function(...args) {
                        clearTimeout(timeout);
                        timeout = setTimeout(() => func.apply(this, args), wait);
                    };
                }

                const performSearch = debounce(function() {
                    const query = $('#searchBox').val().trim();
                    const MSG_nofound = @json(__('product.not_found'));
                    if (query.length > 2) {
                        $.ajax({
                            url: '{{ url('/') }}/search-products',
                            method: 'GET',
                            data: {
                                text: query
                            },
                            success: function(response) {
                                $('#searchResults').empty().show();
                                if (response.length > 0) {
                                    $("#default_search_products").hide();
                                    $('#searchResults').append(`
                                        <div class="searching_for col-12">
                                            <span>{{ __('header.search.for') }}: <strong style="text-transform: capitalize;">${query}</strong></span>
                                            <button>{{ __('header.search.view_all_button') }}</button>
                                        </div>
                                    `);
                                    response.forEach(product => {
                                        $('#searchResults').append(`
                                            <a href="{{ url('/') }}/product/${product.slug}" class="run_time_search_product col-6 col-sm-3">
                                                <div class="category-card ">
                                                    <div class="image">
                                                        <img loading="lazy" src="{{ asset('') }}${product.thumb}" />
                                                    </div>
                                                    <p class="name">${product.product_name}</p>
                                                </div>
                                            </a>
                                        `);
                                    });
                                } else {
                                    $("#default_search_products").hide();
                                    $('#searchResults').append(
                                        `<div class="no_product_search">${MSG_nofound} <span>${query}</span> </div>`
                                    );
                                }
                            },
                            error: function() {
                                $('#searchResults').empty().show().append(
                                    '<div>Error fetching results</div>');
                            }
                        });
                    } else {
                        $('#searchResults').hide();
                    }
                    if (query == "") {
                        $("#default_search_products").show();
                    }
                }, 300); // 300ms debounce delay

                $('#searchBox').on('input', performSearch);
            });
        </script>


        <script>
            let id, qty, price, productTotal;
            $(document).ready(function() {

                $(document).on('click', '.ion-close', function(e) {
                    e.preventDefault();
                    id = $(this).attr('productId');
                    $('#loader_container_overlay').css('display', 'flex').show();
                    $('#button_loader' + id).css('display', 'flex').show();
                    $.ajax({
                        url: "{{ url('cart/remove') }}",
                        type: "POST",
                        data: {
                            id: id,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            //   location.reload();
                            //   console.log(id);
                            //   removeFromView(id,response);
                            if (typeof window.productCardSetLineState === 'function') {
                                window.productCardSetLineState(id, false);
                            }
                            if (response.cart === null) {
                                document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                    .forEach(function(el) {
                                        el.innerHTML = 0;
                                    });
                                document.querySelectorAll(".quantity_btn_box" + id).forEach((
                                    el) => {
                                    el.style.display = "none";
                                });
                                document.querySelectorAll(".add-to-cart" + id).forEach((el) => {
                                    if (!el.classList.contains('product-card__buy-stack')) {
                                        el.style.display = "unset";
                                    }
                                });
                                // $('#loader_container').hide();
                            } else {
                                document.querySelectorAll('#cartValue, #cartValue1, #cartValue2, #cartValueFab')
                                    .forEach(function(el) {
                                        el.innerHTML = response.cart.qty;
                                    });
                                document.querySelectorAll(".quantity_btn_box" + id).forEach((
                                    el) => {
                                    el.style.display = "none";
                                });
                                document.querySelectorAll(".add-to-cart" + id).forEach((el) => {
                                    if (!el.classList.contains('product-card__buy-stack')) {
                                        el.style.display = "unset";
                                    }
                                });
                                // $('#loader_container').hide();
                            }
                            $('#loader_container_overlay').hide();
                            $('#button_loader' + id).hide();
                            //   location.reload();
                        }
                    });
                });

                $('.ion-close-cart').click(function(e) {
                    e.preventDefault();
                    id = $(this).attr('productId');
                    var boxId = $(this).attr('boxId');
                    $('#button_loader' + id).css('display', 'flex').show();
                    $('#button_loader' + boxId).css('display', 'flex').show();
                    $('#loader_container_overlay').css('display', 'flex').show();
                    $.ajax({
                        url: "{{ url('cart/remove') }}",
                        type: "POST",
                        data: {
                            id: id,
                            boxId: boxId,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.cart === null) {
                                $(`#cart_data`).remove();
                                setTimeout(() => {
                                    $('#loader_container_overlay').hide();
                                    $('#button_loader' + id).hide();
                                }, 1000);
                            }
                            if (response.cart === null) {
                                $('#cart_empty_dev').css('display', 'block');
                                $('#content').css('display', 'block');
                                $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(0);
                                setTimeout(() => {
                                    $('#loader_container_overlay').hide();
                                    $('#button_loader' + id).hide();
                                    $('#button_loader' + boxId).hide();
                                }, 1000);
                            }
                            console.log(response);
                            updateView(response);
                            $(`#product-row-${id}`).remove();
                            $(`#hr${id}`).remove();
                            $(`#box-row${boxId}`).remove();
                            $(`#hr${boxId}`).remove();
                            $('#loader_container_overlay').hide();
                            //   location.reload();
                        }
                    });
                });


                $('.clear').click(function(e) {
                    e.preventDefault();
                    //   id = $(this).attr('productId');
                    $.ajax({
                        url: "{{ url('cart/clear') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            location.reload();
                        }
                    });
                });

                $('.plus').click(function() {
                    id = $(this).attr('productId');
                    var boxid = $(this).attr('boxId');
                    price = $(this).attr('productprice');
                    $('#button_loader' + id).css('display', 'flex').show();
                    $('#button_loader' + boxid).css('display', 'flex').show();
                    $('#loader_container_overlay').css('display', 'flex').show();
                    $.ajax({
                        url: "{{ url('cart/increment') }}",
                        type: "POST",
                        data: {
                            id: id,
                            boxid: boxid,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {
                                alert('Item out of stock');
                            } else {
                                qty = $('#spec' + id).val();
                                // let item = response.cart.items.find(item => item.id == id);
                                // if (item) {
                                //     // document.getElementById("quantity" + id).textContent = item.qty;
                                // } else {
                                //     console.error("Item with id " + id + " not found in the cart.");
                                // }
                                updateView(response, price);

                                setTimeout(() => {
                                    $('#button_loader' + id).hide();
                                    $('#button_loader' + boxid).hide();
                                    $('#loader_container_overlay').hide();
                                }, 1000);
                            }
                        }
                    });
                });

                $('.minus').click(function() {
                    id = $(this).attr('productId');
                    var boxid = $(this).attr('boxId');
                    price = $(this).attr('productprice');
                    $('#button_loader' + id).css('display', 'flex').show();
                    $('#button_loader' + boxid).css('display', 'flex').show();
                    $('#loader_container_overlay').css('display', 'flex').show();
                    $.ajax({
                        url: "{{ url('cart/decrement') }}",
                        type: "POST",
                        data: {
                            id: id,
                            boxid: boxid,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (qty > 0) {
                                $('#spec' + id).val(qty);
                                // let item = response.cart.items.find(item => item.id == id);
                                // if (item) {
                                //     // document.getElementById("quantity" + id).textContent = item.qty;
                                // } else {
                                //     console.error("Item with id " + id + " not found in the cart.");
                                // }
                            } else {
                                //   removeFromView(id,response);
                            }
                            updateView(response, price);

                            setTimeout(() => {
                                $('#loader_container_overlay').hide();
                                $('#button_loader' + id).hide();
                                $('#button_loader' + boxid).hide();
                            }, 1000);
                        }
                    });
                });

                function updateView(response) {
                    productTotal = parseInt(qty * price);
                    $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.cart.qty);
                    var minvalur = {{ getSetting('min_order_value') }};
                    var total = parseFloat(response.cart.amount) +
                        parseFloat({{ getSetting('shipping') }}) +
                        (parseFloat(response.cart.amount) * parseFloat({{ getSetting('tax_value') }}) / 100);

                    if (total < minvalur) {
                        $('.checkout').prop('disabled', true);
                        $('#show_meaaage').show();
                    } else {

                        $('.checkout').prop('disabled', false);
                        $('#show_meaaage').hide();

                    }
                    // if (total > 90) {
                    //         document.querySelector("#rider-stepper").style.minWidth="100%";
                    // }
                    // if (total < 90) {
                    //         document.querySelector("#rider-stepper").style.minWidth="0%";
                    // }
                    $('.cartTotal').html('{{ getSetting('currency') }} ' +
                        (
                            response.cart.amount +
                            {{ getSetting('shipping') }} +
                            (response.cart.amount * {{ getSetting('tax_value') }} / 100)
                        ).toFixed(2)
                    );
                    $('.vat').html('{{ getSetting('currency') }} ' +
                        (
                            (response.cart.amount * {{ getSetting('tax_value') }} / 100)
                        ).toFixed(2)
                    );
                    $('.cartTotal1').html('{{ getSetting('currency') }} ' + response.cart.amount + '.00');
                    $('#productTotal' + id).html(productTotal);

                }

                function updatecart() {
                    $('.checkout1').prop('disabled', true);
                }

                updatecart();

            });
        </script>

        <script>
            $(document).ready(function() {
                $('.add-to-cart').click(function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    var buyStack = this.closest && this.closest('.product-card__buy-stack');
                    var alreadyInCart = buyStack && buyStack.getAttribute('data-line-in-cart') === '1';
                    if (alreadyInCart && typeof window.productCardSyncCartLine === 'function') {
                        window.productCardSyncCartLine(id);
                        return;
                    }
                    let qty = $('#quantityinput').val();
                    if (qty === undefined || qty === null || qty === '') {
                        const specVal = $('#spec' + id).val();
                        qty = specVal !== undefined && specVal !== '' ? specVal : 1;
                    }
                    $.ajax({
                        url: "<?php echo url('/'); ?>/cart/add",
                        method: "POST",
                        data: {
                            id: id,
                            qty: qty,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {
                                if (typeof showToastr === 'function') {
                                    showToastr(response.error_data || 'Unable to add to cart', 'danger');
                                }
                                return;
                            }
                            if (typeof showToastr === 'function' && response.msg) {
                                showToastr(response.msg, response.msg_type || 'success');
                            }
                            $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.qty);
                                if (response.cart && response.cart.items) {
                                    const rawItems = response.cart.items;
                                    const list = Array.isArray(rawItems) ? rawItems : Object.values(rawItems);
                                    const row = list.find(function(x) {
                                        return String(x.id) === String(id);
                                    });
                                    if (row) {
                                        var pcOk = typeof window.productCardSetLineState === 'function' &&
                                            window.productCardSetLineState(id, true, row);
                                        if (!pcOk) {
                                            $('#spec' + id).val(row.qty);
                                            const grams = $('.quantity_btn_box' + id).attr(
                                                'data-qty-grams') === '1';
                                            const disp = grams ? (parseInt(row.qty, 10) * 100) :
                                                parseInt(row.qty, 10);
                                            $('#quantity' + id).val(disp);
                                            var preIn = document.getElementById('product-pre-qty-in-' + id);
                                            if (preIn) {
                                                preIn.value = String(disp);
                                            }
                                        }
                                    }
                                }
                                if (!alreadyInCart) {
                                    const button = document.querySelector('.add-to-cart' + id +
                                            '.product-card__buy-stack') ||
                                        document.querySelector('.add-to-cart' + id) || document
                                        .querySelector(`.quantity_btn_box${id}`);
                                    if (button) {
                                        const rect = button.getBoundingClientRect();
                                        const x = rect.left + rect.width / 2;
                                        const y = rect.top + rect.height / 2;

                                        confetti({
                                            particleCount: 50,
                                            startVelocity: 15,
                                            spread: 360,
                                            gravity: 0,
                                            ticks: 100,
                                            origin: {
                                                x: x / window.innerWidth,
                                                y: y / window.innerHeight,
                                            },
                                            scalar: 0.8,
                                        });
                                    }
                                }
                                var __items = response.cart && response.cart.items ? (Array.isArray(
                                        response.cart.items) ? response.cart.items : Object.values(
                                        response.cart.items)) : [];
                                const cartItem = __items.find(function(x) {
                                    return String(x.id) === String(id);
                                }) || __items[0] || null;
                                if (cartItem) {
                                    dataLayer.push({
                                        event: "add_to_cart",
                                        ecommerce: {
                                            currency: "AED", // Replace with your store's currency
                                            value: response.cart.amount, // Total cart amount
                                            items: [{
                                                item_id: cartItem.id, // Product ID
                                                price: cartItem
                                                    .price, // Price per item (update if needed)
                                                quantity: cartItem
                                                    .qty, // Quantity added
                                                name: cartItem.name,
                                            }, ],
                                        },
                                    });
                                    console.log("DataLayer pushed:", dataLayer);
                                    try {
                                        if (cartItem && typeof snaptr === "function") {
                                            const c = document.cookie.match(
                                                /(?:^|;\s*)uuid_c1=([^;]+)/);
                                            const uuidC1 = c ? decodeURIComponent(c[1]) : null;
                                            const qty = Number(cartItem.qty) || 1;
                                            const unitPrice = Number(cartItem.price) || 0;
                                            const addValue = unitPrice * qty;

                                            const payload = {
                                                price: addValue,
                                                currency: "AED",
                                                item_ids: [cartItem.id],
                                                number_items: qty,
                                                user_email: '{{ session()->has('user') ? session('user')['email'] : session('cart')['email'] ?? '' }}'
                                            };
                                            if (uuidC1) payload.uuid_c1 = uuidC1;

                                            snaptr('track', 'ADD_CART', payload);
                                            console.log("Snap ADD_CART sent:", payload);
                                        } else {
                                            console.warn("snaptr is not defined or cartItem missing.");
                                        }
                                    } catch (e) {
                                        console.error("Error sending snaptr ADD_CART event:", e);
                                    }

                                    // TikTok AddToCart tracking
                                    try {
                                        if (cartItem && typeof ttq !== 'undefined') {
                                            ttq.track('AddToCart', {
                                                contents: [{
                                                    content_id: cartItem.id,
                                                    content_type: 'product',
                                                    content_name: cartItem.name,
                                                    quantity: cartItem.qty,
                                                    price: cartItem.price
                                                }],
                                                value: response.cart.amount,
                                                currency: "AED"
                                            }, {
                                                event_id: Date.now() + '_' + Math.random().toString(36)
                                                    .substr(2, 9)
                                            });
                                            console.log("TikTok AddToCart sent for product:", cartItem.id);
                                        }
                                    } catch (e) {
                                        console.error("Error sending TikTok AddToCart event:", e);
                                    }
                                }
                        },
                        cache: false // Disable caching for the AJAX response
                    });
                });
            });
            $(document).ready(function() {
                $('.add-to-cart-item').click(function(e) {
                    e.preventDefault();
                    let id = $(this).attr('id');
                    var buyStackItem = this.closest && this.closest('.product-card__buy-stack');
                    var alreadyInCartItem = buyStackItem && buyStackItem.getAttribute(
                        'data-line-in-cart') === '1';
                    if (alreadyInCartItem && typeof window.productCardSyncCartLine === 'function') {
                        window.productCardSyncCartLine(id);
                        return;
                    }
                    let qty = $('#quantityinput').val();
                    if (qty === undefined || qty === null || qty === '') {
                        const specVal = $('#spec' + id).val();
                        qty = specVal !== undefined && specVal !== '' ? specVal : 1;
                    }
                    $.ajax({
                        url: "<?php echo url('/'); ?>/cart/add",
                        method: "POST",
                        data: {
                            id: id,
                            qty: qty,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {
                                if (typeof showToastr === 'function') {
                                    showToastr(response.error_data || 'Unable to add to cart', 'danger');
                                }
                                return;
                            }
                            if (typeof showToastr === 'function' && response.msg) {
                                showToastr(response.msg, response.msg_type || 'success');
                            }
                            $('#cartValue, #cartValue1, #cartValue2, #cartValueFab').html(response.qty);
                                if (response.cart && response.cart.items) {
                                    const rawItems = response.cart.items;
                                    const list = Array.isArray(rawItems) ? rawItems : Object.values(rawItems);
                                    const row = list.find(function(x) {
                                        return String(x.id) === String(id);
                                    });
                                    if (row) {
                                        var pcOk2 = typeof window.productCardSetLineState === 'function' &&
                                            window.productCardSetLineState(id, true, row);
                                        if (!pcOk2) {
                                            $('#spec' + id).val(row.qty);
                                            const grams = $('.quantity_btn_box' + id).attr(
                                                'data-qty-grams') === '1';
                                            const disp = grams ? (parseInt(row.qty, 10) * 100) :
                                                parseInt(row.qty, 10);
                                            $('#quantity' + id).val(disp);
                                            var preIn2 = document.getElementById('product-pre-qty-in-' + id);
                                            if (preIn2) {
                                                preIn2.value = String(disp);
                                            }
                                        }
                                    }
                                }
                                if (!alreadyInCartItem) {
                                    const button = document.querySelector('.add-to-cart' + id +
                                            '.product-card__buy-stack') ||
                                        document.querySelector('.add-to-cart' + id) || document
                                        .querySelector(`.quantity_btn_box${id}`);
                                    if (button) {
                                        const rect = button.getBoundingClientRect();
                                        const x = rect.left + rect.width / 2;
                                        const y = rect.top + rect.height / 2;

                                        confetti({
                                            particleCount: 50,
                                            startVelocity: 15,
                                            spread: 360,
                                            gravity: 0,
                                            ticks: 100,
                                            origin: {
                                                x: x / window.innerWidth,
                                                y: y / window.innerHeight,
                                            },
                                            scalar: 0.8,
                                        });
                                    }
                                }
                                var __items2 = response.cart && response.cart.items ? (Array.isArray(
                                        response.cart.items) ? response.cart.items : Object.values(
                                        response.cart.items)) : [];
                                const cartItem = __items2.find(function(x) {
                                    return String(x.id) === String(id);
                                }) || __items2[0] || null;
                                if (cartItem) {
                                    dataLayer.push({
                                        event: "add_to_cart",
                                        ecommerce: {
                                            currency: "AED", // Replace with your store's currency
                                            value: response.cart.amount, // Total cart amount
                                            items: [{
                                                item_id: cartItem.id, // Product ID
                                                price: cartItem
                                                    .price, // Price per item (update if needed)
                                                quantity: cartItem
                                                    .qty, // Quantity added
                                                name: cartItem.name,
                                            }, ],
                                        },
                                    });
                                    console.log("DataLayer pushed:", dataLayer);

                                    try {
                                        if (cartItem && typeof snaptr === "function") {
                                            const c = document.cookie.match(
                                                /(?:^|;\s*)uuid_c1=([^;]+)/);
                                            const uuidC1 = c ? decodeURIComponent(c[1]) : null;
                                            const qty = Number(cartItem.qty) || 1;
                                            const unitPrice = Number(cartItem.price) || 0;
                                            const addValue = unitPrice * qty;

                                            const payload = {
                                                price: addValue,
                                                currency: "AED",
                                                item_ids: [cartItem.id],
                                                number_items: qty,
                                                user_email: '{{ session()->has('user') ? session('user')['email'] : session('cart')['email'] ?? '' }}'
                                            };
                                            if (uuidC1) payload.uuid_c1 = uuidC1;

                                            snaptr('track', 'ADD_CART', payload);
                                            console.log("Snap ADD_CART sent:", payload);
                                        } else {
                                            console.warn("snaptr is not defined or cartItem missing.");
                                        }
                                    } catch (e) {
                                        console.error("Error sending snaptr ADD_CART event:", e);
                                    }

                                    // TikTok AddToCart tracking
                                    try {
                                        if (cartItem && typeof ttq !== 'undefined') {
                                            ttq.track('AddToCart', {
                                                contents: [{
                                                    content_id: cartItem.id,
                                                    content_type: 'product',
                                                    content_name: cartItem.name,
                                                    quantity: cartItem.qty,
                                                    price: cartItem.price
                                                }],
                                                value: response.cart.amount,
                                                currency: "AED"
                                            }, {
                                                event_id: Date.now() + '_' + Math.random().toString(36)
                                                    .substr(2, 9)
                                            });
                                            console.log("TikTok AddToCart sent for product:", cartItem.id);
                                        }
                                    } catch (e) {
                                        console.error("Error sending TikTok AddToCart event:", e);
                                    }
                                }
                        },
                        cache: false // Disable caching for the AJAX response
                    });
                });
            });

            $(document).ready(function() {
                $('.add-to-cart-item1').click(function(e) {
                    e.preventDefault();

                    let id = $(this).attr('id');
                    var buyStackItem1 = this.closest && this.closest('.product-card__buy-stack');
                    var inCartItem1 = buyStackItem1 && buyStackItem1.getAttribute('data-line-in-cart') === '1';
                    if (inCartItem1 && typeof window.productCardSyncCartLine === 'function') {
                        window.productCardSyncCartLine(id).then(function() {
                            window.location.href = "<?php echo url('/'); ?>/cart";
                        });
                        return;
                    }
                    let qty = $('#quantityinput').val();
                    if (qty === undefined || qty === null || qty === '') {
                        const specVal = $('#spec' + id).val();
                        qty = specVal !== undefined && specVal !== '' ? specVal : 1;
                    }

                    $.ajax({
                        url: "<?php echo url('/'); ?>/cart/add",
                        method: "POST",
                        data: {
                            id: id,
                            qty: qty,
                            "_token": "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if (response.error) {
                                if (typeof showToastr === 'function') {
                                    showToastr(response.error_data || 'Unable to add to cart', 'danger');
                                }
                                return;
                            }
                            window.location.href = "<?php echo url('/'); ?>/cart";
                        }
                    });
                });
            });

            function showToastr(msg, msg_type) {
                switch (msg_type) {
                    case "success":
                        toastr.success(msg);
                        break;

                    case "danger":
                        toastr.error(msg)
                        break;

                    case "info":
                        toastr.info(msg)
                        break;

                    case "warning":
                        toastr.warning(msg)
                        break;
                }
            }

            $(document).ready(function() {

                let msg_type = "";
                let msg = "";
                @if (Session::has('msg'))
                    msg_type = "{{ Session::get('msg_type') }}";
                    msg = "{{ Session::get('msg') }}";
                @endif

                if (msg != "") {
                    switch (msg_type) {
                        case "success":
                            toastr.success(msg);
                            break;

                        case "danger":
                            toastr.error(msg)
                            break;

                        case "info":
                            toastr.info(msg)
                            break;

                        case "warning":
                            toastr.warning(msg)
                            break;
                    }
                }





            });

            // AddToCart event (working, included for reference)
            function addToCart(productId, price) {
                var addPayload = {
                    content_ids: [productId],
                    content_type: 'product',
                    value: price,
                    currency: @json(pixelCurrency())
                };

                function sendAddToCart() {
                    if (typeof fbq !== 'function') {
                        return false;
                    }
                    fbq('track', 'AddToCart', addPayload);
                    return true;
                }

                if (sendAddToCart()) {
                    return;
                }
                window.addEventListener('meta-pixel-ready', function() {
                    sendAddToCart();
                }, {
                    once: true
                });
                var addAttempts = 0;
                var addPoll = setInterval(function() {
                    if (sendAddToCart() || ++addAttempts >= 40) {
                        clearInterval(addPoll);
                    }
                }, 100);
            }

            // AddToCart event (working, included for reference)
            function InitiateCheckout() {
                function sendInitiateCheckout() {
                    if (typeof fbq !== 'function') {
                        return false;
                    }
                    fbq('track', 'InitiateCheckout');
                    return true;
                }

                if (sendInitiateCheckout()) {
                    return;
                }
                window.addEventListener('meta-pixel-ready', function() {
                    sendInitiateCheckout();
                }, {
                    once: true
                });
                var icAttempts = 0;
                var icPoll = setInterval(function() {
                    if (sendInitiateCheckout() || ++icAttempts >= 40) {
                        clearInterval(icPoll);
                    }
                }, 100);
            }
        </script>
