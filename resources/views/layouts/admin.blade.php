<!DOCTYPE html>
<html class="light" lang="en">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>MiniMOO - @yield('title', 'Admin')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <style type="text/tailwindcss">
        :root {
            --primary: #f42559;
            --secondary: #ff8fb1;
            --bg-light: #fff5f7;
            --bubble-pink: #ffe4e9;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-light);
        }

        .donut-shape {
            border-radius: 50%;
            position: relative;
            box-shadow: 0 10px 25px -5px rgba(244, 37, 89, 0.2);
        }

        .donut-shape::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 30%;
            height: 30%;
            background-color: var(--bg-light);
            border-radius: 50%;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .sidebar-bubble {
            border-radius: 9999px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-bubble:hover,
        .sidebar-bubble.active {
            background-color: var(--primary);
            color: white;
            transform: translateX(8px);
        }

        .admin-shell.sidebar-collapsed > .admin-sidebar {
            width: 5.5rem;
            padding: 1rem !important;
        }

        .admin-sidebar {
            transition: width 220ms cubic-bezier(0.4, 0, 0.2, 1), padding 220ms cubic-bezier(0.4, 0, 0.2, 1);
        }

        .admin-shell.sidebar-hidden > .admin-sidebar {
            display: none;
            width: 0 !important;
            padding: 0 !important;
            border-width: 0 !important;
            overflow: hidden;
        }

        .admin-shell.sidebar-hidden > .admin-sidebar * {
            pointer-events: none;
        }

        .admin-shell.sidebar-collapsed > .admin-sidebar .admin-sidebar-label {
            display: none;
        }

        .admin-shell.sidebar-collapsed > .admin-sidebar .sidebar-bubble {
            justify-content: center;
            padding-left: 0.75rem;
            padding-right: 0.75rem;
            gap: 0;
        }

        .admin-shell.sidebar-collapsed > .admin-sidebar .sidebar-bubble:hover,
        .admin-shell.sidebar-collapsed > .admin-sidebar .sidebar-bubble.active {
            transform: none;
        }

        .lollipop-border {
            border: 4px dashed var(--primary);
            padding: 4px;
            animation: rotate-border 20s linear infinite;
        }

        @keyframes rotate-border {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        .heart-point {
            clip-path: path('M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z');
        }

        .material-symbols-outlined.crumb-heart {
            font-variation-settings: 'FILL' 1, 'wght' 600, 'GRAD' 0, 'opsz' 20;
        }

        @keyframes toast-in {
            from {
                transform: translateY(10px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .live-search-spinner {
            width: 18px;
            height: 18px;
            border-radius: 9999px;
            border: 2px solid rgba(244, 37, 89, 0.25);
            border-top-color: rgba(244, 37, 89, 0.95);
            animation: spin 700ms linear infinite;
        }
    </style>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f42559",
                        "secondary": "#ff8fb1",
                        "accent": "#ffd1dc"
                    }
                }
            }
        }
    </script>
    @stack('styles')
</head>

<body class="min-h-screen text-[#181113]">
    <div id="adminShell" class="admin-shell min-h-screen flex flex-col md:flex-row">
        <!-- Desktop Sidebar -->
        <aside class="admin-sidebar hidden md:flex w-72 bg-white border-r-4 border-primary/10 flex-col p-6 gap-6 md:sticky md:top-0 md:h-screen md:overflow-y-auto md:self-start">
            @include('layouts.partials.admin_sidebar', ['isMobile' => false])
        </aside>

        <!-- Mobile Topbar -->
        <header class="md:hidden sticky top-0 z-40 bg-white/80 backdrop-blur-md border-b border-primary/10">
            <div class="px-4 py-3 flex items-center justify-between gap-3">
                <button id="adminSidebarButton" type="button"
                    class="h-10 w-10 rounded-xl border-2 border-primary/15 bg-white/70 text-primary flex items-center justify-center"
                    aria-controls="adminSidebarOverlay" aria-expanded="false">
                    <span class="material-symbols-outlined">menu</span>
                </button>
                <a class="flex items-center gap-2" href="{{ route('admin.dashboard') }}">
                    <div class="bg-primary p-2 rounded-2xl rotate-3">
                        <span class="material-symbols-outlined text-white text-xl font-bold">icecream</span>
                    </div>
                    <span class="text-primary font-black tracking-tighter italic">MiniMOO</span>
                </a>
                <div class="h-10 w-10 rounded-xl bg-primary/5 border-2 border-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-[20px]">notifications</span>
                </div>
            </div>
        </header>

        <!-- Mobile Sidebar Overlay -->
        <div id="adminSidebarOverlay" class="md:hidden fixed inset-0 z-50 hidden">
            <div class="absolute inset-0 bg-black/40" data-admin-close></div>
            <aside class="admin-sidebar absolute inset-y-0 left-0 w-[300px] max-w-[85vw] bg-white border-r-4 border-primary/10 p-6 flex flex-col gap-6">
                @include('layouts.partials.admin_sidebar', ['isMobile' => true])
            </aside>
        </div>

        <!-- Page Content -->
        <div class="flex-1 min-w-0 flex flex-col">
            <button id="adminSidebarReopenButton" type="button"
                class="hidden fixed top-4 left-4 z-40 h-10 w-10 rounded-xl border-2 border-primary/15 bg-white/90 backdrop-blur text-primary items-center justify-center shadow"
                aria-label="Open sidebar">
                <span class="material-symbols-outlined">menu_open</span>
            </button>

            @yield('content')

            <!-- Toast Host -->
            <div id="toastHost" class="fixed right-4 top-4 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

            <footer class="bg-white py-6 px-4 sm:px-10 border-t border-primary/10 mt-auto">
                <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                    <div class="flex items-center gap-2 text-primary opacity-50">
                        <span class="material-symbols-outlined">bakery_dining</span>
                        <span class="font-bold">{{ config('app.name', 'MiniMOO') }} Admin Panel © {{ now()->year }}</span>
                    </div>
                    <div class="flex flex-wrap gap-6 text-primary/60 text-sm font-semibold">
                        <a class="hover:text-primary" href="{{ route('home') }}">Back to Site</a>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    <script>
        (function () {
            var btn = document.getElementById('adminSidebarButton');
            var overlay = document.getElementById('adminSidebarOverlay');
            var shell = document.getElementById('adminShell');
            var desktopToggle = document.getElementById('adminDesktopCollapseButton');
            var desktopReopen = document.getElementById('adminSidebarReopenButton');

            var LS_KEY = 'admin_sidebar_collapsed_v1';

            function setDesktopState(nextState) {
                if (!shell) return;
                // nextState: 'expanded' | 'collapsed' | 'hidden'
                shell.classList.toggle('sidebar-hidden', nextState === 'hidden');
                shell.classList.toggle('sidebar-collapsed', nextState === 'collapsed');

                if (desktopReopen) {
                    if (nextState === 'hidden') {
                        desktopReopen.classList.remove('hidden');
                        desktopReopen.classList.add('flex');
                    } else {
                        desktopReopen.classList.add('hidden');
                        desktopReopen.classList.remove('flex');
                    }
                }

                if (desktopToggle) {
                    var icon = desktopToggle.querySelector('.material-symbols-outlined');
                    if (icon) {
                        icon.textContent = nextState === 'hidden' ? 'dock_to_left' : 'dock_to_right';
                    }
                }

                try {
                    var stored = nextState === 'collapsed' ? '1' : (nextState === 'hidden' ? '2' : '0');
                    localStorage.setItem(LS_KEY, stored);
                } catch (e) {}
            }

            function applyDesktopState() {
                if (!shell) return;
                var raw = '0';
                try {
                    raw = localStorage.getItem(LS_KEY) || '0';
                } catch (e) {
                    raw = '0';
                }

                if (raw === '2') return setDesktopState('hidden');
                // Legacy: if previously stored as "collapsed", treat as expanded to avoid odd desktop layout.
                if (raw === '1') return setDesktopState('expanded');
                return setDesktopState('expanded');
            }

            function open() {
                if (!overlay) return;
                overlay.classList.remove('hidden');
                if (btn) btn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function close() {
                if (!overlay) return;
                overlay.classList.add('hidden');
                if (btn) btn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            if (btn && overlay) {
                btn.addEventListener('click', function () {
                    var isHidden = overlay.classList.contains('hidden');
                    if (isHidden) open();
                    else close();
                });
                overlay.addEventListener('click', function (e) {
                    if (e.target && e.target.closest && e.target.closest('[data-admin-close]')) close();
                });
                document.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') close();
                });
            }

            applyDesktopState();

            if (desktopToggle && shell) {
                desktopToggle.addEventListener('click', function () {
                    // Toggle: expanded <-> hidden (user requested full close)
                    var isHidden = shell.classList.contains('sidebar-hidden');
                    if (isHidden) return setDesktopState('expanded');
                    return setDesktopState('hidden');
                });
            }

            if (desktopReopen && shell) {
                desktopReopen.addEventListener('click', function () {
                    setDesktopState('expanded');
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
