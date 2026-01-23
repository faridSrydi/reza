<!DOCTYPE html>

<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Mini Mooo')</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@400,100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "primary": "#f42559",
                        "background-light": "#fdf8f9",
                        "background-dark": "#221014",
                        "candy-pink": "#ffebf0",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "1.5rem",
                        "lg": "2rem",
                        "xl": "3rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 1, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }

        .wishlist-icon {
            font-variation-settings: 'FILL' 0, 'wght' 500, 'GRAD' 0, 'opsz' 20;
        }

        .wishlist-icon.is-on {
            font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 20;
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

        .nav-icon {
            font-size: 20px;
            font-variation-settings: 'FILL' 1, 'wght' 500, 'GRAD' 0, 'opsz' 20;
        }

        /* Breadcrumb heart separator (force filled) */
        .material-symbols-outlined.crumb-heart {
            font-variation-settings: 'FILL' 1, 'wght' 600, 'GRAD' 0, 'opsz' 20;
        }

        @keyframes nav-wiggle {
            0% {
                transform: rotate(0deg) scale(1);
            }

            35% {
                transform: rotate(-8deg) scale(1.03);
            }

            70% {
                transform: rotate(7deg) scale(1.03);
            }

            100% {
                transform: rotate(0deg) scale(1);
            }
        }

        .nav-wiggle:hover {
            animation: nav-wiggle 260ms ease-in-out 1;
        }

        .nav-pop {
            transform-origin: top;
            overflow: hidden;
            max-height: 0;
            opacity: 0;
            transform: translateY(-6px) scale(0.98);
            pointer-events: none;
            margin-top: 0;
            transition: max-height 260ms ease, opacity 220ms ease, transform 220ms ease;
        }

        .nav-pop.is-open {
            max-height: 420px;
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
            margin-top: 1rem;
        }

        /* Mobile live search dropdown needs to overflow outside the animated container */
        .nav-pop--search.is-open {
            overflow: visible;
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

        .user-menu-pop {
            opacity: 0;
            transform: translateY(-6px) scale(0.98);
            pointer-events: none;
            transition: opacity 180ms ease, transform 180ms ease;
        }

        .user-menu-pop.is-open {
            opacity: 1;
            transform: translateY(0) scale(1);
            pointer-events: auto;
        }

        .bubble-shadow {
            box-shadow: 0 10px 25px -5px rgba(244, 37, 89, 0.1), 0 8px 10px -6px rgba(244, 37, 89, 0.1);
        }

        .heart-border {
            border: 4px solid #f42559;
            mask-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath d='M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z'/%3E%3C/svg%3E");
        }
    </style>

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.clientKey') }}"></script>


</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-[#181113] dark:text-white transition-colors duration-300">
    <div class="relative flex h-auto min-h-screen w-full flex-col group/design-root overflow-x-hidden">
        <!-- Sticky Navigation -->
        <header
            class="fixed top-0 left-0 right-0 z-50 w-full bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-pink-100 dark:border-zinc-800">
            <div class="max-w-[1280px] mx-auto px-6 py-4">
                <div class="flex items-center justify-between gap-4">
                    <!-- Mobile: Hamburger (left) + Logo -->
                    <div class="flex items-center gap-3">
                        <button id="mobileMenuButton" type="button"
                            class="lg:hidden nav-wiggle h-10 w-10 flex items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                            aria-controls="mobileMenu" aria-expanded="false">
                            <span id="mobileMenuIcon" class="material-symbols-outlined nav-icon">menu</span>
                        </button>

                        <a class="flex items-center" href="{{ route('home') }}">
                            <img src="{{ asset('assets/images/icon/minimo.svg') }}" alt="Logo" class="h-15 w-auto nav-wiggle"/>
                        </a>


                    </div>

                    <!-- Desktop Search -->
                    <div class="hidden lg:block flex-1 max-w-xl">
                        <form method="GET" action="{{ route('shop.index') }}" class="relative" data-live-search-container>
                            <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-primary" aria-label="Search">
                                <span class="material-symbols-outlined">search</span>
                            </button>
                            <input
                                id="desktopSearchInput"
                                name="q"
                                value="{{ request('q') }}"
                                class="w-full bg-candy-pink dark:bg-zinc-800/50 border-2 border-transparent focus:border-primary/30 focus:ring-0 rounded-full py-3 pl-12 pr-12 text-sm font-medium transition-all placeholder:text-primary/40"
                                placeholder="Find your sweet craving..." type="text" autocomplete="off"
                                data-live-search
                                data-live-search-results="desktopSearchResults" />

                            <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden" data-live-search-spinner>
                                <div class="live-search-spinner"></div>
                            </div>
                            <div id="desktopSearchResults"
                                class="hidden absolute left-0 right-0 mt-3 rounded-3xl border-2 border-primary/10 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md shadow-xl shadow-primary/10 overflow-hidden z-50">
                            </div>
                        </form>
                    </div>

                    <!-- Nav Links & Actions -->
                    <div class="flex items-center gap-6">
                        <nav class="hidden lg:flex items-center gap-8">
                            <a class="text-sm font-bold hover:text-primary transition-colors"
                                href="{{ route('home') }}">Home</a>
                            <a class="text-sm font-bold hover:text-primary transition-colors"
                                href="{{ route('shop.index') }}">Shop</a>
                            <a class="text-sm font-bold hover:text-primary transition-colors"
                                href="{{ route('about') }}">About</a>
                            <a class="text-sm font-bold hover:text-primary transition-colors"
                                href="{{ route('contact') }}">Contact</a>
                        </nav>

                        <div class="flex items-center gap-3">
                            <!-- Mobile: Search icon (right) -->
                            <button id="mobileSearchButton" type="button"
                                class="lg:hidden nav-wiggle h-10 w-10 flex items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                                aria-controls="mobileSearchBar" aria-expanded="false">
                                <span id="mobileSearchIcon" class="material-symbols-outlined nav-icon">search</span>
                            </button>

                            <!-- Desktop: Favorite icon -->
                            @auth
                                @php
                                    $wishlistCount = \Illuminate\Support\Facades\DB::table('wishlists')
                                        ->where('user_id', auth()->id())
                                        ->count();
                                @endphp
                                <a href="{{ route('wishlist.index') }}"
                                    class="relative hidden lg:inline-flex nav-wiggle h-10 w-10 items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                                    aria-label="Wishlist">
                                    <span class="material-symbols-outlined nav-icon">favorite</span>
                                    <span data-wishlist-count-badge data-count="{{ $wishlistCount }}"
                                        class="{{ $wishlistCount > 0 ? '' : 'hidden' }} absolute -top-1 -right-1 bg-primary text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">
                                        {{ $wishlistCount }}
                                    </span>
                                </a>
                            @else
                                <a href="{{ route('login') }}"
                                    class="hidden lg:inline-flex nav-wiggle h-10 w-10 items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                                    aria-label="Login to use wishlist">
                                    <span class="material-symbols-outlined nav-icon">favorite</span>
                                </a>
                            @endauth

                            <!-- Cart icon -->
                            @php
                                $cartCount = collect(session('cart', []))->sum('qty');
                            @endphp
                            <a href="{{ route('cart.index') }}"
                                class="relative nav-wiggle h-10 w-10 flex items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                                aria-label="Cart">
                                <span class="material-symbols-outlined nav-icon">shopping_cart</span>
                                <span data-cart-count-badge data-count="{{ $cartCount }}"
                                    class="{{ $cartCount > 0 ? '' : 'hidden' }} absolute -top-1 -right-1 bg-primary text-white text-[9px] font-bold px-1.5 py-0.5 rounded-full ring-2 ring-white">
                                    {{ $cartCount }}
                                </span>
                            </a>

                            <!-- User icon -->
                            @auth
                                @php
                                    $u = auth()->user();
                                    $dashboardUrl = $u->hasRole('admin') ? route('admin.dashboard') : url('/user/dashboard');
                                    $dashboardLabel = $u->hasRole('admin') ? 'Admin Dashboard' : 'Dashboard';
                                @endphp
                                <div class="relative" data-user-menu>
                                    <button id="userMenuButton" type="button"
                                        class="relative nav-wiggle h-10 w-10 flex items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                                        aria-label="User menu" aria-controls="userMenu" aria-expanded="false">
                                        <span class="material-symbols-outlined nav-icon">person</span>
                                        <span class="absolute -top-1 -right-1 size-2.5 rounded-full bg-primary ring-2 ring-white"></span>
                                    </button>

                                    <div id="userMenu"
                                        class="user-menu-pop absolute right-0 mt-3 w-[280px] rounded-3xl border-2 border-primary/10 bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md shadow-xl shadow-primary/10 overflow-hidden"
                                        role="menu" aria-labelledby="userMenuButton">
                                        <div class="p-4 border-b border-primary/10">
                                            <p class="text-[11px] font-black uppercase tracking-widest text-primary/60">Signed in as</p>
                                            <p class="mt-1 text-primary font-extrabold leading-tight">{{ $u->name }}</p>
                                            <p class="mt-1 text-xs font-semibold text-primary/60">{{ $u->email }}</p>
                                        </div>

                                        <div class="p-2">
                                            <a href="{{ $dashboardUrl }}"
                                                class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-primary/10 text-sm font-extrabold text-primary transition-colors"
                                                role="menuitem">
                                                <span class="material-symbols-outlined text-primary">dashboard</span>
                                                {{ $dashboardLabel }}
                                            </a>
                                            <a href="{{ route('wishlist.index') }}"
                                                class="flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-primary/10 text-sm font-extrabold text-primary transition-colors"
                                                role="menuitem">
                                                <span class="material-symbols-outlined text-primary">favorite</span>
                                                Wishlist
                                            </a>
                                        </div>

                                        <div class="p-2 border-t border-primary/10">
                                            <form method="POST" action="{{ route('logout') }}">
                                                @csrf
                                                <button type="submit"
                                                    class="w-full flex items-center gap-3 px-3 py-3 rounded-2xl hover:bg-primary text-sm font-extrabold text-primary hover:text-white transition-colors"
                                                    role="menuitem">
                                                    <span class="material-symbols-outlined">logout</span>
                                                    Log out
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <a href="{{ route('login') }}"
                                    class="relative nav-wiggle h-10 w-10 flex items-center justify-center bg-gradient-to-br from-candy-pink to-white/80 dark:from-zinc-800 dark:to-zinc-900/60 border-2 border-primary/15 rounded-xl text-primary hover:border-primary/30 hover:shadow-lg hover:shadow-primary/15 transition-all"
                                    aria-label="Login">
                                    <span class="material-symbols-outlined nav-icon">person</span>
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>

                <!-- Mobile Search Bar (toggle) -->
                <div id="mobileSearchBar" class="lg:hidden nav-pop nav-pop--search">
                    <form method="GET" action="{{ route('shop.index') }}" class="relative" data-live-search-container>
                        <button type="submit" class="absolute left-4 top-1/2 -translate-y-1/2 text-primary" aria-label="Search">
                            <span class="material-symbols-outlined">search</span>
                        </button>
                        <input
                            id="mobileSearchInput"
                            name="q"
                            value="{{ request('q') }}"
                            class="w-full bg-candy-pink dark:bg-zinc-800/50 border-2 border-transparent focus:border-primary/30 focus:ring-0 rounded-full py-3 pl-12 pr-12 text-sm font-medium transition-all placeholder:text-primary/40"
                            placeholder="Find your sweet craving..." type="text" autocomplete="off"
                            data-live-search
                            data-live-search-results="mobileSearchResults" />

                        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden" data-live-search-spinner>
                            <div class="live-search-spinner"></div>
                        </div>
                        <div id="mobileSearchResults"
                            class="hidden absolute left-0 right-0 mt-3 rounded-3xl border-2 border-primary/10 bg-white/95 dark:bg-zinc-900/95 backdrop-blur-md shadow-xl shadow-primary/10 overflow-hidden z-50">
                        </div>
                    </form>
                </div>

                <!-- Mobile Menu (toggle) -->
                <nav id="mobileMenu" class="lg:hidden nav-pop">
                    <div class="pt-4 border-t border-pink-100 dark:border-zinc-800">
                        <div
                            class="rounded-2xl border-2 border-primary/10 bg-white/70 dark:bg-zinc-900/40 backdrop-blur-md p-4">
                            <div class="flex flex-col gap-3">
                                <a class="flex items-center gap-3 text-sm font-bold hover:text-primary transition-colors"
                                    href="{{ route('home') }}">
                                    <span class="material-symbols-outlined text-primary">home</span>
                                    Home
                                </a>
                                <a class="flex items-center gap-3 text-sm font-bold hover:text-primary transition-colors"
                                    href="{{ route('shop.index') }}">
                                    <span class="material-symbols-outlined text-primary">storefront</span>
                                    Shop
                                </a>
                                <a class="flex items-center gap-3 text-sm font-bold hover:text-primary transition-colors"
                                    href="{{ route('about') }}">
                                    <span class="material-symbols-outlined text-primary">info</span>
                                    About
                                </a>
                                <a class="flex items-center gap-3 text-sm font-bold hover:text-primary transition-colors"
                                    href="{{ route('contact') }}">
                                    <span class="material-symbols-outlined text-primary">mail</span>
                                    Contact
                                </a>
                            </div>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <div aria-hidden="true" class="h-[88px]"></div>
        @yield('content')

        <!-- Toast Host -->
        <div id="toastHost" class="fixed right-4 top-[96px] z-[9999] flex flex-col gap-3 pointer-events-none"></div>

        <!-- Footer -->
        <footer class="bg-white dark:bg-background-dark border-t border-pink-100 dark:border-zinc-800 py-16">
            @php
                $appName = config('app.name', 'MiniMOO');
                $year = now()->year;
                $companyAddress = config('app.company_address', 'Jakarta Selatan, Indonesia');
                $socialLinks = config('app.social_links', []);
            @endphp

            <div class="max-w-[1280px] mx-auto px-6 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
                <div class="space-y-4">
                    <div class="flex items-center gap-3">
                        <div class="size-10 bg-primary rounded-full flex items-center justify-center text-white">
                            <span class="material-symbols-outlined">icecream</span>
                        </div>
                        <h2 class="text-xl font-extrabold">{{ $appName }}</h2>
                    </div>
                    <p class="text-zinc-500 font-medium text-sm">Sweet snacks, quick checkout, happy cravings.</p>
                </div>

                <div>
                    <h4 class="font-black mb-6 text-lg">Links</h4>
                    <ul class="space-y-4 text-zinc-500 font-medium text-sm">
                        <li><a class="hover:text-primary" href="{{ route('home') }}">Home</a></li>
                        <li><a class="hover:text-primary" href="{{ route('shop.index') }}">Shop</a></li>
                        <li><a class="hover:text-primary" href="{{ route('about') }}">About</a></li>
                        <li><a class="hover:text-primary" href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-black mb-6 text-lg">Account</h4>
                    <ul class="space-y-4 text-zinc-500 font-medium text-sm">
                        <li><a class="hover:text-primary" href="{{ route('cart.index') }}">Cart</a></li>
                        @auth
                            <li><a class="hover:text-primary" href="{{ route('wishlist.index') }}">Wishlist</a></li>
                            <li><a class="hover:text-primary" href="{{ url('/user/dashboard') }}">Dashboard</a></li>
                        @else
                            <li><a class="hover:text-primary" href="{{ route('login') }}">Login</a></li>
                            <li><a class="hover:text-primary" href="{{ route('register') }}">Register</a></li>
                        @endauth
                    </ul>
                </div>

                <div>
                    <h4 class="font-black mb-6 text-lg">Alamat & Sosmed</h4>
                    <div class="space-y-4 text-zinc-500 font-medium text-sm">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-primary text-sm mt-0.5">location_on</span>
                            <span>{{ $companyAddress }}</span>
                        </div>

                        <div class="flex items-center gap-3">
                            @php
                                $ig = $socialLinks['instagram'] ?? null;
                                $tt = $socialLinks['tiktok'] ?? null;
                                $wa = $socialLinks['whatsapp'] ?? null;
                            @endphp

                            @if (!empty($ig))
                                <a class="size-10 bg-candy-pink dark:bg-zinc-800 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"
                                    href="{{ $ig }}" target="_blank" rel="noopener" aria-label="Instagram">
                                    <span class="material-symbols-outlined">photo_camera</span>
                                </a>
                            @else
                                <span class="size-10 bg-candy-pink/60 dark:bg-zinc-800/60 rounded-full flex items-center justify-center text-primary/50"
                                    aria-label="Instagram">
                                    <span class="material-symbols-outlined">photo_camera</span>
                                </span>
                            @endif

                            @if (!empty($tt))
                                <a class="size-10 bg-candy-pink dark:bg-zinc-800 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"
                                    href="{{ $tt }}" target="_blank" rel="noopener" aria-label="TikTok">
                                    <span class="material-symbols-outlined">music_note</span>
                                </a>
                            @else
                                <span class="size-10 bg-candy-pink/60 dark:bg-zinc-800/60 rounded-full flex items-center justify-center text-primary/50"
                                    aria-label="TikTok">
                                    <span class="material-symbols-outlined">music_note</span>
                                </span>
                            @endif

                            @if (!empty($wa))
                                <a class="size-10 bg-candy-pink dark:bg-zinc-800 rounded-full flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all"
                                    href="{{ $wa }}" target="_blank" rel="noopener" aria-label="WhatsApp">
                                    <span class="material-symbols-outlined">chat</span>
                                </a>
                            @else
                                <span class="size-10 bg-candy-pink/60 dark:bg-zinc-800/60 rounded-full flex items-center justify-center text-primary/50"
                                    aria-label="WhatsApp">
                                    <span class="material-symbols-outlined">chat</span>
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div
                class="max-w-[1280px] mx-auto px-6 mt-16 pt-8 border-t border-pink-50 dark:border-zinc-800 flex flex-col sm:flex-row justify-between items-center gap-4 text-zinc-400 text-xs font-bold uppercase tracking-widest">
                <p>© {{ $year }} {{ $appName }}. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script>
        (function() {
            var mobileMenuButton = document.getElementById('mobileMenuButton');
            var mobileMenu = document.getElementById('mobileMenu');
            var mobileMenuIcon = document.getElementById('mobileMenuIcon');
            var mobileSearchButton = document.getElementById('mobileSearchButton');
            var mobileSearchBar = document.getElementById('mobileSearchBar');
            var mobileSearchIcon = document.getElementById('mobileSearchIcon');

            var userMenuButton = document.getElementById('userMenuButton');
            var userMenu = document.getElementById('userMenu');

            function close(targetEl, buttonEl, iconEl, closedIcon) {
                if (!targetEl) return;
                targetEl.classList.remove('is-open');
                if (buttonEl) buttonEl.setAttribute('aria-expanded', 'false');
                if (iconEl && closedIcon) iconEl.textContent = closedIcon;
            }

            function open(targetEl, buttonEl, iconEl, openIcon) {
                if (!targetEl) return;
                targetEl.classList.add('is-open');
                if (buttonEl) buttonEl.setAttribute('aria-expanded', 'true');
                if (iconEl && openIcon) iconEl.textContent = openIcon;
            }

            function toggle(targetEl, buttonEl, iconEl, closedIcon, openIcon) {
                if (!targetEl) return;
                var willOpen = !targetEl.classList.contains('is-open');
                if (willOpen) open(targetEl, buttonEl, iconEl, openIcon);
                else close(targetEl, buttonEl, iconEl, closedIcon);
            }

            if (mobileMenuButton && mobileMenu) {
                mobileMenuButton.addEventListener('click', function() {
                    // close search when opening menu
                    close(mobileSearchBar, mobileSearchButton, mobileSearchIcon, 'search');
                    toggle(mobileMenu, mobileMenuButton, mobileMenuIcon, 'menu', 'close');
                });
            }

            if (mobileSearchButton && mobileSearchBar) {
                mobileSearchButton.addEventListener('click', function() {
                    // close menu when opening search
                    close(mobileMenu, mobileMenuButton, mobileMenuIcon, 'menu');
                    toggle(mobileSearchBar, mobileSearchButton, mobileSearchIcon, 'search', 'close');
                });
            }

            function closeUserMenu() {
                if (!userMenuButton || !userMenu) return;
                userMenu.classList.remove('is-open');
                userMenuButton.setAttribute('aria-expanded', 'false');
            }

            function toggleUserMenu() {
                if (!userMenuButton || !userMenu) return;
                var willOpen = !userMenu.classList.contains('is-open');
                if (willOpen) {
                    userMenu.classList.add('is-open');
                    userMenuButton.setAttribute('aria-expanded', 'true');
                } else {
                    closeUserMenu();
                }
            }

            if (userMenuButton && userMenu) {
                // start closed
                closeUserMenu();

                userMenuButton.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    toggleUserMenu();
                });

                document.addEventListener('click', function(e) {
                    if (!userMenu.classList.contains('is-open')) return;
                    var container = e.target && e.target.closest ? e.target.closest('[data-user-menu]') : null;
                    if (!container) closeUserMenu();
                });

                document.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') closeUserMenu();
                });
            }
        })();
    </script>

    <script>
        (function() {
            function showToast(message, type) {
                var host = document.getElementById('toastHost');
                if (!host) return;

                var toast = document.createElement('div');
                var color = type === 'success' ? 'border-primary/20' : type === 'error' ? 'border-red-300' :
                    'border-primary/10';
                var icon = type === 'success' ? 'favorite' : type === 'error' ? 'error' : 'info';

                toast.className =
                    'pointer-events-none w-[320px] max-w-[90vw] bg-white/90 dark:bg-zinc-900/90 backdrop-blur-md border-2 ' +
                    color + ' rounded-2xl shadow-lg shadow-primary/10 px-4 py-3 flex items-start gap-3';
                toast.style.animation = 'toast-in 180ms ease-out';

                toast.innerHTML =
                    '<span class="material-symbols-outlined text-primary">' + icon + '</span>' +
                    '<div class="flex-1">' +
                    '<div class="text-sm font-extrabold text-primary">' + message + '</div>' +
                    '</div>';

                host.appendChild(toast);

                setTimeout(function() {
                    toast.style.opacity = '0';
                    toast.style.transform = 'translateY(10px)';
                    toast.style.transition = 'opacity 180ms ease, transform 180ms ease';
                }, 2300);
                setTimeout(function() {
                    toast.remove();
                }, 2600);
            }

            // allow other pages to trigger toast if needed
            window.__showToast = showToast;

            function updateWishlistCount(delta) {
                if (!delta) return;

                var badges = document.querySelectorAll('[data-wishlist-count-badge]');
                if (!badges || badges.length === 0) return;

                var current = 0;
                var first = badges[0];
                var raw = first.getAttribute('data-count') || first.textContent || '0';
                current = parseInt(raw, 10);
                if (isNaN(current)) current = 0;

                var next = current + delta;
                if (next < 0) next = 0;

                badges.forEach(function(b) {
                    b.setAttribute('data-count', String(next));
                    b.textContent = String(next);
                    if (next > 0) {
                        b.classList.remove('hidden');
                    } else {
                        b.classList.add('hidden');
                    }
                });
            }

            function getCsrfToken() {
                var meta = document.querySelector('meta[name="csrf-token"]');
                return meta ? meta.getAttribute('content') : '';
            }

            document.addEventListener('click', async function(e) {
                var btn = e.target && e.target.closest ? e.target.closest('[data-wishlist-toggle]') : null;
                if (!btn) return;

                e.preventDefault();
                e.stopPropagation();

                var url = btn.getAttribute('data-wishlist-url');
                if (!url) return;

                var wasActive = btn.getAttribute('data-wishlist-active') === '1';

                try {
                    var res = await fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    });

                    if (res.status === 401) {
                        window.location.href = '{{ route('login') }}';
                        return;
                    }

                    if (!res.ok) {
                        showToast('Gagal update wishlist.', 'error');
                        return;
                    }

                    var data = await res.json();
                    var inWishlist = !!(data && data.in_wishlist);
                    btn.setAttribute('data-wishlist-active', inWishlist ? '1' : '0');

                    if (inWishlist && !wasActive) {
                        updateWishlistCount(1);
                        showToast('Ditambahkan ke wishlist', 'success');
                    }
                    if (!inWishlist && wasActive) {
                        updateWishlistCount(-1);
                        showToast('Dihapus dari wishlist', 'success');
                    }

                    var icon = btn.querySelector('.wishlist-icon');
                    if (icon) {
                        icon.classList.toggle('is-on', inWishlist);
                        icon.classList.toggle('text-primary', true);
                        icon.classList.toggle('text-primary/40', !inWishlist);
                    }

                    // Keep visible if active
                    if (inWishlist) {
                        btn.classList.add('opacity-100');
                        btn.classList.remove('opacity-0');
                    } else {
                        // If we're on the wishlist page, removing means hide the card.
                        if (window.location && window.location.pathname && window.location.pathname.indexOf(
                                '/wishlist') === 0) {
                            var card = btn.closest('.product-card');
                            if (card) {
                                card.remove();
                            }
                        }
                    }
                } catch (err) {
                    showToast('Gagal update wishlist.', 'error');
                    // no-op
                }
            });

            // Session toast (from redirects like Contact submit)
            var sessionToast = @json(session('toast'));
            if (sessionToast && sessionToast.message) {
                showToast(sessionToast.message, sessionToast.type || 'success');
            }
        })();
    </script>

    <script>
        (function() {
            var suggestUrl = @json(route('search.suggest'));
            var shopUrl = @json(route('shop.index'));

            function escapeHtml(str) {
                return String(str)
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#039;');
            }

            function buildSearchLink(q) {
                return shopUrl + '?q=' + encodeURIComponent(q || '');
            }

            function hide(el) {
                if (!el) return;
                el.classList.add('hidden');
                el.innerHTML = '';
            }

            function show(el) {
                if (!el) return;
                el.classList.remove('hidden');
            }

            function renderResults(host, q, payload) {
                if (!host) return;

                var products = (payload && payload.products) ? payload.products : [];
                var categories = (payload && payload.categories) ? payload.categories : [];

                function thumbHtml(imageUrl, fallbackIcon) {
                    if (imageUrl) {
                        return '<img class="h-11 w-11 rounded-2xl object-cover bg-candy-pink border-2 border-primary/10" src="' +
                            escapeHtml(imageUrl) + '" alt="" loading="lazy" />';
                    }
                    return '<div class="h-11 w-11 rounded-2xl bg-candy-pink border-2 border-primary/10 flex items-center justify-center">' +
                        '<span class="material-symbols-outlined text-primary">' + escapeHtml(fallbackIcon || 'image') + '</span>' +
                        '</div>';
                }

                var html = '';

                html += '<div class="px-4 py-3 border-b border-primary/10">' +
                    '<a class="flex items-center gap-3 text-sm font-extrabold text-primary hover:bg-primary/10 rounded-2xl px-3 py-2 transition-colors" href="' +
                    escapeHtml(buildSearchLink(q)) + '">' +
                    '<span class="material-symbols-outlined text-primary">search</span>' +
                    '<span>Search for <span class="text-primary">&quot;' + escapeHtml(q) + '&quot;</span></span>' +
                    '</a>' +
                    '</div>';

                if (categories.length > 0) {
                    html += '<div class="px-4 pt-3 pb-2 text-[11px] font-black uppercase tracking-widest text-primary/60">Categories</div>';
                    html += '<div class="px-2 pb-2">';
                    categories.forEach(function(c) {
                        html += '<a class="flex items-center gap-3 px-3 py-2 rounded-2xl hover:bg-primary/10 text-sm font-extrabold text-primary transition-colors" href="' +
                            escapeHtml(c.url) + '">' +
                            thumbHtml(c.image_url, 'category') +
                            '<span class="truncate">' + escapeHtml(c.name) + '</span>' +
                            '</a>';
                    });
                    html += '</div>';
                }

                if (products.length > 0) {
                    html += '<div class="px-4 pt-3 pb-2 text-[11px] font-black uppercase tracking-widest text-primary/60">Products</div>';
                    html += '<div class="px-2 pb-3">';
                    products.forEach(function(p) {
                        var sub = p.category_name ? '<div class="text-[11px] font-bold text-primary/50">' + escapeHtml(p.category_name) + '</div>' : '';
                        html += '<a class="flex items-start gap-3 px-3 py-2 rounded-2xl hover:bg-primary/10 text-sm font-extrabold text-primary transition-colors" href="' +
                            escapeHtml(p.url) + '">' +
                            thumbHtml(p.image_url, 'shopping_bag') +
                            '<div class="min-w-0">' +
                            '<div class="truncate">' + escapeHtml(p.name) + '</div>' +
                            sub +
                            '</div>' +
                            '</a>';
                    });
                    html += '</div>';
                }

                if (categories.length === 0 && products.length === 0) {
                    html += '<div class="px-4 py-4 text-sm font-bold text-primary/60">No results. Press Enter to search.</div>';
                }

                host.innerHTML = html;
                show(host);
            }

            function setupLiveSearch(input) {
                if (!input) return;

                var resultsId = input.getAttribute('data-live-search-results');
                var resultsHost = resultsId ? document.getElementById(resultsId) : null;
                var container = input.closest('[data-live-search-container]');
                var spinnerHost = container ? container.querySelector('[data-live-search-spinner]') : null;

                var debounceTimer = null;
                var abortController = null;

                function setLoading(isLoading) {
                    if (!spinnerHost) return;
                    if (isLoading) spinnerHost.classList.remove('hidden');
                    else spinnerHost.classList.add('hidden');
                }

                function closeResults() {
                    hide(resultsHost);
                    setLoading(false);
                }

                function request(q) {
                    if (!resultsHost) return;
                    if (!q || q.length < 2) {
                        closeResults();
                        return;
                    }

                    setLoading(true);

                    if (abortController) {
                        abortController.abort();
                    }
                    abortController = new AbortController();

                    fetch(suggestUrl + '?q=' + encodeURIComponent(q), {
                        headers: {
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        signal: abortController.signal
                    })
                        .then(function(res) {
                            if (!res.ok) throw new Error('bad response');
                            return res.json();
                        })
                        .then(function(data) {
                            // If user already changed input, don't flash stale results
                            if (String(input.value || '') !== String(q)) return;
                            renderResults(resultsHost, q, data);
                            setLoading(false);
                        })
                        .catch(function(err) {
                            if (err && err.name === 'AbortError') return;
                            closeResults();
                        });
                }

                input.addEventListener('input', function() {
                    var q = String(input.value || '').trim();

                    if (debounceTimer) clearTimeout(debounceTimer);
                    debounceTimer = setTimeout(function() {
                        request(q);
                    }, 220);
                });

                input.addEventListener('focus', function() {
                    var q = String(input.value || '').trim();
                    if (q.length >= 2) request(q);
                });

                input.addEventListener('keydown', function(e) {
                    if (e.key === 'Escape') {
                        closeResults();
                        input.blur();
                    }
                });

                document.addEventListener('click', function(e) {
                    if (!resultsHost || resultsHost.classList.contains('hidden')) return;
                    if (container && (e.target === container || (e.target && e.target.closest && e.target.closest('[data-live-search-container]') === container))) {
                        return;
                    }
                    closeResults();
                });
            }

            // Attach to all inputs that opt-in
            var inputs = document.querySelectorAll('[data-live-search]');
            inputs.forEach(function(i) {
                setupLiveSearch(i);
            });
        })();
    </script>
</body>

</html>
