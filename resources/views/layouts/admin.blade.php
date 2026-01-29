<!DOCTYPE html>
<html class="light overflow-x-hidden touch-pan-y" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Luxe Admin - @yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;family=Playfair+Display:ital,wght@0,400;0,700;1,400&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .serif-text {
            font-family: 'Playfair Display', serif;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .chart-bar {
            @apply bg-primary/20 hover:bg-primary transition-colors duration-300;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#ee2b8c",
                        "background-light": "#f3f4f6",
                        "sidebar-dark": "#1b0d14",
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>

<body class="bg-background-light text-[#1b0d14] min-h-screen flex overflow-x-hidden touch-pan-y">
    <div id="adminShell" class="admin-shell min-h-screen flex flex-col lg:flex-row flex-1 w-full overflow-x-hidden">
        <!-- Desktop Sidebar -->
        <aside class="admin-sidebar hidden lg:flex w-64 bg-sidebar-dark text-white flex-col fixed inset-y-0 left-0 z-50 h-screen overflow-y-auto no-scrollbar">
            @include('layouts.partials.admin_sidebar', ['isMobile' => false])
        </aside>

        <!-- Mobile Topbar -->
        <header class="lg:hidden sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-gray-200 w-full">
            <div class="px-4 py-3 flex items-center justify-between gap-3">
                <button id="adminSidebarButton" type="button"
                    class="h-10 w-10 rounded-lg border border-gray-200 bg-white/70 text-gray-500 flex items-center justify-center"
                    aria-controls="adminSidebarOverlay" aria-expanded="false">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a class="flex items-center gap-2" href="{{ route('admin.dashboard') }}">
                    <div class="text-primary">
                        <span class="material-symbols-outlined text-3xl">auto_fix_high</span>
                    </div>
                    <span class="text-[#1b0d14] text-xl font-bold tracking-tighter serif-text">LUXE</span>
                </a>
                <div class="h-10 w-10 rounded-xl bg-primary/5 border-2 border-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                </div>
            </div>
        </header>

        <!-- Mobile Sidebar Overlay -->
        <div id="adminSidebarOverlay" class="lg:hidden fixed inset-0 z-50 hidden h-[100dvh] overscroll-contain" aria-hidden="true">
            <div id="adminSidebarBackdrop" class="absolute inset-0 bg-black/40 opacity-0 transition-opacity duration-200" data-admin-close></div>
            <aside id="adminSidebarPanel" class="admin-sidebar absolute inset-y-0 left-0 w-[300px] max-w-[85vw] bg-sidebar-dark text-white flex flex-col h-full overflow-y-auto no-scrollbar -translate-x-full transform transition-transform duration-200">
                @include('layouts.partials.admin_sidebar', ['isMobile' => true])
            </aside>
        </div>

        <!-- Page Content -->
        <div class="flex-1 min-w-0 flex flex-col w-full lg:pl-64">

            @yield('content')

            <!-- Toast Host -->
            <div id="toastHost" class="fixed right-4 top-4 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

            <footer class="px-4 sm:px-6 lg:px-8 py-6 text-xs text-gray-500 mt-auto">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <span>© {{ now()->year }} {{ config('app.name', 'LUXE') }}</span>
                    <a class="hover:text-primary" href="{{ route('home') }}">Back to Site</a>
                </div>
            </footer>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('adminSidebarButton');
            var overlay = document.getElementById('adminSidebarOverlay');
            var backdrop = document.getElementById('adminSidebarBackdrop');
            var panel = document.getElementById('adminSidebarPanel');
            var closeTimer = null;

            // Safety: ensure scroll isn't stuck after hot reload / partial navigation
            document.body.style.overflowY = '';
            document.documentElement.style.overflowY = '';

            function open() {
                if (!overlay) return;
                overlay.classList.remove('hidden');
                if (btn) btn.setAttribute('aria-expanded', 'true');
                overlay.setAttribute('aria-hidden', 'false');
                document.body.style.overflowY = 'hidden';
                document.documentElement.style.overflowY = 'hidden';

                if (closeTimer) {
                    clearTimeout(closeTimer);
                    closeTimer = null;
                }

                requestAnimationFrame(function () {
                    if (backdrop) backdrop.classList.add('opacity-100');
                    if (panel) {
                        panel.classList.remove('-translate-x-full');
                        panel.classList.add('translate-x-0');
                    }
                });
            }

            function close() {
                if (!overlay) return;
                if (btn) btn.setAttribute('aria-expanded', 'false');
                overlay.setAttribute('aria-hidden', 'true');
                document.body.style.overflowY = '';
                document.documentElement.style.overflowY = '';

                if (backdrop) backdrop.classList.remove('opacity-100');
                if (panel) {
                    panel.classList.add('-translate-x-full');
                    panel.classList.remove('translate-x-0');
                }

                if (closeTimer) clearTimeout(closeTimer);
                closeTimer = setTimeout(function () {
                    overlay.classList.add('hidden');
                }, 220);
            }

            function wireOverlayCloseTargets() {
                if (!overlay) return;

                var closeTargets = overlay.querySelectorAll('[data-admin-close]');
                closeTargets.forEach(function (el) {
                    el.addEventListener('click', function (e) {
                        e.preventDefault();
                        close();
                    });
                });

                var links = overlay.querySelectorAll('a[href]');
                links.forEach(function (a) {
                    a.addEventListener('click', function () {
                        close();
                    });
                });
            }

            if (btn && overlay) {
                wireOverlayCloseTargets();
                btn.addEventListener('click', function () {
                    var isHidden = overlay.classList.contains('hidden');
                    if (isHidden) open();
                    else close();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') close();
                });
            }
        })();
    </script>

    <script>
        (function () {
            function showToast(message, type) {
                var host = document.getElementById('toastHost');
                if (!host) return;

                var toast = document.createElement('div');
                var color = type === 'success' ? 'border-primary/20' : type === 'error' ? 'border-red-300' : 'border-primary/10';
                var icon = type === 'success' ? 'check_circle' : type === 'error' ? 'error' : 'info';

                toast.className = 'pointer-events-none w-[340px] max-w-[90vw] bg-white/95 backdrop-blur-md border-2 ' + color + ' rounded-3xl shadow-xl shadow-primary/10 px-4 py-3 flex items-start gap-3';
                toast.style.animation = 'toast-in 180ms ease-out';

                toast.innerHTML =
                    '<span class="material-symbols-outlined text-primary">' + icon + '</span>' +
                    '<div class="flex-1">' +
                        '<div class="text-sm font-extrabold text-[#181113]">' + message + '</div>' +
                    '</div>';

                host.appendChild(toast);

                setTimeout(function () {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(10px)';
                    toast.style.transition = 'opacity 180ms ease, transform 180ms ease';
                }, 2300);
                setTimeout(function () {
                    toast.remove();
                }, 2600);
            }

            var sessionToast = @json(session('toast'));
            if (sessionToast && sessionToast.message) {
                showToast(sessionToast.message, sessionToast.type || 'success');
            }
        })();
    </script>

    <script>
        (function () {
            var suggestUrl = @json(route('admin.search.suggest'));

            function escapeHtml(str) {
                return String(str || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function moneyIDR(amount) {
                try {
                    return new Intl.NumberFormat('id-ID').format(Number(amount || 0));
                } catch (e) {
                    return String(amount || 0);
                }
            }

            function setLoading(container, isLoading) {
                if (!container) return;
                var spinnerHost = container.querySelector('[data-admin-live-search-spinner]');
                if (!spinnerHost) return;
                if (isLoading) spinnerHost.classList.remove('hidden');
                else spinnerHost.classList.add('hidden');
            }

            function ensureDropdown(container) {
                if (!container) return null;
                if (container.classList && !container.classList.contains('relative')) {
                    container.classList.add('relative');
                }

                var dd = container.querySelector('[data-admin-live-search-dropdown]');
                if (dd) return dd;

                dd = document.createElement('div');
                dd.setAttribute('data-admin-live-search-dropdown', '');
                dd.className = 'hidden absolute left-0 right-0 top-full mt-3 bg-white/95 backdrop-blur-md border-2 border-primary/10 rounded-3xl shadow-2xl shadow-primary/10 overflow-hidden z-[9998]';
                container.appendChild(dd);
                return dd;
            }

            function hideDropdown(dropdown) {
                if (!dropdown) return;
                dropdown.classList.add('hidden');
                dropdown.innerHTML = '';
            }

            function renderPanel(dropdown, q, payload) {
                if (!dropdown) return;
                var products = (payload && payload.products) ? payload.products : [];
                var orders = (payload && payload.orders) ? payload.orders : [];
                var users = (payload && payload.users) ? payload.users : [];

                var hasAny = products.length || orders.length || users.length;

                var html = '';
                html += '<div class="p-5 border-b border-primary/10">';
                html +=   '<div class="flex items-center justify-between gap-3">';
                html +=     '<div class="min-w-0">';
                html +=       '<div class="text-sm font-black text-[#181113]">Search: <span class="text-primary">' + escapeHtml(q) + '</span></div>';
                html +=       '<div class="text-xs font-bold text-primary/60 uppercase tracking-widest">Products • Orders • Users</div>';
                html +=     '</div>';
                html +=     '<div class="flex items-center gap-2 shrink-0">';
                html +=       '<a class="px-3 py-1.5 rounded-full bg-primary text-white text-xs font-black" href="' + escapeHtml(@json(route('admin.search')) ) + '?q=' + encodeURIComponent(q) + '">View all</a>';
                html +=       '<button type="button" data-admin-live-close class="h-9 w-9 rounded-full bg-primary/5 hover:bg-primary/10 text-primary flex items-center justify-center" aria-label="Close">';
                html +=         '<span class="material-symbols-outlined" style="font-variation-settings: \'FILL\' 1">close</span>';
                html +=       '</button>';
                html +=     '</div>';
                html +=   '</div>';
                html += '</div>';

                if (!hasAny) {
                    html += '<div class="p-8 text-center">';
                    html +=   '<div class="text-primary font-black">No results</div>';
                    html +=   '<div class="text-primary/60 text-sm font-semibold mt-1">Try another keyword</div>';
                    html += '</div>';
                    dropdown.innerHTML = html;
                    return;
                }

                html += '<div class="max-h-[56vh] overflow-auto">';

                function section(title, itemsHtml) {
                    return (
                        '<div class="border-b border-primary/10">' +
                            '<div class="px-5 py-3 bg-white/60">' +
                                '<div class="text-xs font-black text-primary/70 uppercase tracking-widest">' + escapeHtml(title) + '</div>' +
                            '</div>' +
                            itemsHtml +
                        '</div>'
                    );
                }

                var prodHtml = '';
                if (products.length) {
                    prodHtml += '<div class="divide-y divide-primary/10">';
                    products.forEach(function (p) {
                        var img = p.image ? '<img src="' + escapeHtml(p.image) + '" class="w-full h-full object-cover" />' : '';
                        prodHtml += (
                            '<a href="' + escapeHtml(p.url) + '" class="block px-5 py-4 hover:bg-primary/5 transition-colors">' +
                                '<div class="flex items-center gap-3">' +
                                    '<div class="w-11 h-11 rounded-2xl bg-primary/10 overflow-hidden shrink-0">' + img + '</div>' +
                                    '<div class="min-w-0">' +
                                        '<div class="font-black text-[#181113] truncate">' + escapeHtml(p.name) + '</div>' +
                                        '<div class="text-xs font-bold text-primary/60 truncate">' + escapeHtml(p.category || '—') + '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</a>'
                        );
                    });
                    prodHtml += '</div>';
                } else {
                    prodHtml = '<div class="px-5 py-4 text-primary/60 font-bold">No products.</div>';
                }

                var orderHtml = '';
                if (orders.length) {
                    orderHtml += '<div class="divide-y divide-primary/10">';
                    orders.forEach(function (o) {
                        orderHtml += (
                            '<a href="' + escapeHtml(o.url) + '" class="block px-5 py-4 hover:bg-primary/5 transition-colors">' +
                                '<div class="flex items-center justify-between gap-3">' +
                                    '<div class="min-w-0">' +
                                        '<div class="font-black text-[#181113] truncate">' + escapeHtml(o.order_number) + '</div>' +
                                        '<div class="text-xs font-bold text-primary/60 truncate">' + escapeHtml(o.customer || '—') + '</div>' +
                                    '</div>' +
                                    '<div class="text-right shrink-0">' +
                                        '<div class="font-black text-primary">Rp ' + escapeHtml(moneyIDR(o.total_amount)) + '</div>' +
                                        '<div class="text-[10px] font-black uppercase tracking-widest text-primary/60">' + escapeHtml(o.status || '') + '</div>' +
                                    '</div>' +
                                '</div>' +
                            '</a>'
                        );
                    });
                    orderHtml += '</div>';
                } else {
                    orderHtml = '<div class="px-5 py-4 text-primary/60 font-bold">No orders.</div>';
                }

                var userHtml = '';
                if (users.length) {
                    userHtml += '<div class="divide-y divide-primary/10">';
                    users.forEach(function (u) {
                        userHtml += (
                            '<div class="px-5 py-4">' +
                                '<div class="font-black text-[#181113] truncate">' + escapeHtml(u.name) + '</div>' +
                                '<div class="text-xs font-bold text-primary/60 truncate">' + escapeHtml(u.email || '—') + '</div>' +
                            '</div>'
                        );
                    });
                    userHtml += '</div>';
                } else {
                    userHtml = '<div class="px-5 py-4 text-primary/60 font-bold">No users.</div>';
                }

                html += section('Products', prodHtml);
                html += section('Orders', orderHtml);
                html += section('Users', userHtml);
                html += '</div>';

                dropdown.innerHTML = html;
            }

            var activeInput = null;
            var activeContainer = null;
            var activeDropdown = null;
            var debounceTimer = null;
            var aborter = null;
            var lastQ = '';

            function fetchSuggest(q) {
                if (aborter) aborter.abort();
                aborter = new AbortController();

                setLoading(activeContainer, true);
                return fetch(suggestUrl + '?q=' + encodeURIComponent(q), {
                    headers: { 'Accept': 'application/json' },
                    signal: aborter.signal
                })
                    .then(function (res) {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.json();
                    })
                    .finally(function () {
                        setLoading(activeContainer, false);
                    });
            }

            function onInputChanged(input) {
                if (!input) return;
                var q = String(input.value || '').trim();
                lastQ = q;

                if (q.length === 0) {
                    hideDropdown(activeDropdown);
                    return;
                }

                activeDropdown = ensureDropdown(activeContainer);
                if (activeDropdown) {
                    activeDropdown.classList.remove('hidden');
                    activeDropdown.innerHTML = '<div class="p-6 text-primary/60 font-bold">Searching…</div>';
                }

                if (debounceTimer) clearTimeout(debounceTimer);
                debounceTimer = setTimeout(function () {
                    fetchSuggest(q)
                        .then(function (payload) {
                            // If user already typed something else, ignore.
                            if (String(input.value || '').trim() !== q) return;
                            renderPanel(activeDropdown, q, payload);
                        })
                        .catch(function (err) {
                            if (err && err.name === 'AbortError') return;
                            if (activeDropdown) activeDropdown.innerHTML = '<div class="p-6 text-red-600 font-bold">Failed to search.</div>';
                        });
                }, 180);
            }

            function bindInput(input) {
                if (!input || input.__adminLiveBound) return;
                input.__adminLiveBound = true;

                var container = input.closest('[data-admin-live-search-container]') || input.parentElement;

                input.addEventListener('focus', function () {
                    activeInput = input;
                    activeContainer = container;
                    activeDropdown = ensureDropdown(activeContainer);
                    onInputChanged(input);
                });

                input.addEventListener('input', function () {
                    activeInput = input;
                    activeContainer = container;
                    activeDropdown = ensureDropdown(activeContainer);
                    onInputChanged(input);
                });

                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') {
                        hideDropdown(activeDropdown);
                        return;
                    }
                });
            }

            function bindAll() {
                var inputs = document.querySelectorAll('[data-admin-live-search]');
                for (var i = 0; i < inputs.length; i++) bindInput(inputs[i]);
            }

            document.addEventListener('click', function (e) {
                var closeBtn = e.target && e.target.closest ? e.target.closest('[data-admin-live-close]') : null;
                if (closeBtn) {
                    e.preventDefault();
                    hideDropdown(activeDropdown);
                }
            });

            document.addEventListener('click', function (e) {
                if (!activeInput) return;
                if (activeDropdown && activeDropdown.contains(e.target)) return;
                if (activeInput.contains(e.target)) return;
                var container = activeInput.closest('[data-admin-live-search-container]');
                if (container && container.contains(e.target)) return;
                hideDropdown(activeDropdown);
            });
            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') hideDropdown(activeDropdown);
            });

            bindAll();
        })();
    </script>

</body>

</html>
