<!DOCTYPE html>

<html class="light" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>@yield('title', 'Reza Cosmetics | High-End Makeup &amp; Skincare')</title>


    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <!-- Google Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&amp;family=Playfair+Display:ital,wght@0,400;0,700;1,400&amp;display=swap"
        rel="stylesheet" />
    <!-- Material Symbols -->
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
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
                        "primary": "#ee2b8c",
                        "background-light": "#f8f6f7",
                        "background-dark": "#221019",
                    },
                    fontFamily: {
                        "display": ["Plus Jakarta Sans", "sans-serif"],
                        "serif": ["Playfair Display", "serif"]
                    },
                    borderRadius: {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                },
            },
        }
    </script>
    <style>
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .serif-text {
            font-family: "Playfair Display", serif;
        }
    </style>
    @stack('styles')
</head>

<body class="bg-background-light dark:bg-background-dark text-[#1b0d14] dark:text-white transition-colors duration-300">
    <!-- Top Navigation Bar (Sticky) -->
    <header
        class="sticky top-0 z-50 w-full border-b border-solid border-[#f3e7ed] dark:border-[#3d2030] bg-white/80 dark:bg-background-dark/80 backdrop-blur-md">
        <div class="max-w-[1440px] mx-auto flex items-center justify-between px-6 lg:px-20 py-4">
            <div class="flex items-center gap-12">
                <div class="flex items-center gap-2">
                    <div class="text-primary">
                        <span class="material-symbols-outlined text-3xl">auto_fix_high</span>
                    </div>
                    <a href="{{ route('home') }}" class="text-[#1b0d14] dark:text-white text-xl font-bold tracking-tighter serif-text">BUNGA</a>
                </div>
                <nav class="hidden lg:flex items-center gap-8">
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('home') }}">Home</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('shop.index') }}">Shop</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route(name: 'shop.index') }}">Collections</a>
                    <a class="text-sm font-medium hover:text-primary transition-colors" href="{{ route('about') }}">About</a>
                </nav>
            </div>
            <div class="flex flex-1 justify-end gap-6 items-center">
                <label class="hidden md:flex flex-col min-w-40 h-10 max-w-64">
                    <div class="flex w-full flex-1 items-stretch rounded-full h-full bg-[#f3e7ed] dark:bg-[#3d2030]">
                        <div class="text-[#9a4c73] flex items-center justify-center pl-4">
                            <span class="material-symbols-outlined text-xl">search</span>
                        </div>
                        <input
                            class="form-input flex w-full min-w-0 flex-1 border-none bg-transparent focus:outline-0 focus:ring-0 h-full placeholder:text-[#9a4c73] px-3 text-sm font-normal"
                            placeholder="Search products..." />
                    </div>
                </label>
                <!-- Desktop icons: Wishlist, Cart, User -->
                <div class="hidden lg:flex items-center gap-4">
                    <a href="{{ route('cart.index') }}"
                        class="relative flex items-center justify-center size-10 rounded-full hover:bg-[#f3e7ed] dark:hover:bg-[#3d2030] transition-colors"
                        aria-label="Cart">
                        <span class="material-symbols-outlined text-2xl">shopping_bag</span>
                    </a>

                    @auth
                        <a href="#"
                            class="flex items-center justify-center size-10 rounded-full hover:bg-[#f3e7ed] dark:hover:bg-[#3d2030] transition-colors"
                            aria-label="Wishlist">
                            <span class="material-symbols-outlined text-2xl">favorite</span>
                        </a>

                        @php
                            $dashboardUrl = auth()->user()->hasRole('admin') ? route('admin.dashboard') : url('/user/dashboard');
                        @endphp
                        <div class="relative">
                            <button
                                id="userMenuButton"
                                type="button"
                                class="flex items-center justify-center size-10 rounded-full hover:bg-[#f3e7ed] dark:hover:bg-[#3d2030] transition-colors"
                                aria-label="User menu"
                                aria-controls="userMenu"
                                aria-expanded="false">
                                <span class="material-symbols-outlined text-2xl">person</span>
                            </button>

                            <div
                                id="userMenu"
                                class="hidden absolute right-0 mt-2 w-72 overflow-hidden rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] bg-white dark:bg-background-dark shadow-xl">
                                <div class="px-4 py-3 border-b border-[#f3e7ed] dark:border-[#3d2030]">
                                    <div class="text-sm font-bold">{{ auth()->user()->name }}</div>
                                    <div class="text-xs text-gray-500 break-all">{{ auth()->user()->email }}</div>
                                </div>
                                <div class="p-2">
                                    <a
                                        href="{{ $dashboardUrl }}"
                                        class="flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-primary/10 transition-colors text-sm font-bold">
                                        <span class="material-symbols-outlined text-[20px]">dashboard</span>
                                        Go to Dashboard
                                    </a>
                                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                                        @csrf
                                        <button
                                            type="submit"
                                            class="w-full flex items-center gap-2 px-3 py-2 rounded-xl hover:bg-red-50 dark:hover:bg-red-500/10 transition-colors text-sm font-bold text-red-600">
                                            <span class="material-symbols-outlined text-[20px]">logout</span>
                                            Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}"
                            class="flex items-center justify-center size-10 rounded-full hover:bg-[#f3e7ed] dark:hover:bg-[#3d2030] transition-colors"
                            aria-label="Login">
                            <span class="material-symbols-outlined text-2xl">person</span>
                        </a>
                    @endauth
                </div>

                <!-- Mobile icons: Cart + Hamburger (or Login + Hamburger) -->
                <div class="flex lg:hidden items-center gap-2">
                    <button
                        id="mobileMenuButton"
                        type="button"
                        class="flex items-center justify-center size-10 rounded-full hover:bg-[#f3e7ed] dark:hover:bg-[#3d2030] transition-colors"
                        aria-label="Open menu"
                        aria-controls="mobileMenu"
                        aria-expanded="false">
                        <span class="material-symbols-outlined text-2xl">menu</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="lg:hidden hidden">
            <div id="mobileMenuBackdrop" class="fixed inset-0 z-40 bg-black/40 backdrop-blur-sm"></div>

            <div class="fixed top-0 left-0 right-0 z-50 bg-white dark:bg-background-dark border-b border-[#f3e7ed] dark:border-[#3d2030] shadow-xl">
                <div class="max-w-[1440px] mx-auto px-6 py-4 flex items-center justify-between">
                    <a href="{{ route('home') }}" class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-2xl text-primary">auto_fix_high</span>
                        <span class="text-[#1b0d14] dark:text-white text-lg font-bold tracking-tighter serif-text">BUNGA</span>
                    </a>
                    <button
                        id="mobileMenuClose"
                        type="button"
                        class="flex items-center justify-center size-10 rounded-full hover:bg-[#f3e7ed] dark:hover:bg-[#3d2030] transition-colors"
                        aria-label="Close menu">
                        <span class="material-symbols-outlined text-2xl">close</span>
                    </button>
                </div>

                <div class="max-w-[1440px] mx-auto px-6 pb-6">
                    <form method="GET" action="{{ route('shop.index') }}" class="mb-5">
                        <div class="flex items-center gap-3 bg-[#f3e7ed] dark:bg-[#3d2030] rounded-full h-12 px-4">
                            <span class="material-symbols-outlined text-[#9a4c73]">search</span>
                            <input
                                name="q"
                                value="{{ request('q') }}"
                                class="w-full bg-transparent border-none focus:ring-0 focus:outline-0 text-sm"
                                placeholder="Search products..." />
                        </div>
                    </form>

                    <nav class="grid gap-2">
                        <a href="{{ route('home') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Home</a>
                        <a href="{{ route('shop.index') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Shop</a>
                        <a href="{{ route('about') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">About</a>
                        <a href="{{ route('contact') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Contact</a>

                        @auth
                            <a href="{{ route('wishlist.index') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Wishlist</a>
                            <a href="{{ route('cart.index') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Cart</a>
                            @php
                                $dashboardUrlMobile = auth()->user()->hasRole('admin') ? route('admin.dashboard') : url('/user/dashboard');
                            @endphp
                            <a href="{{ $dashboardUrlMobile }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">My Account</a>
                            <form method="POST" action="{{ route('logout') }}" class="mt-2">
                                @csrf
                                <button type="submit" class="w-full text-left px-4 py-3 rounded-2xl font-bold text-red-600 hover:bg-red-50 dark:hover:bg-red-500/10">Logout</button>
                            </form>
                        @else
                            <a href="{{ route('cart.index') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Cart</a>
                            <a href="{{ route('login') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Login</a>
                            <a href="{{ route('register') }}" class="px-4 py-3 rounded-2xl font-bold hover:bg-primary/10">Register</a>
                        @endauth
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main class="max-w-[1440px] mx-auto overflow-hidden">
@yield('content')
    </main>
    <!-- Footer -->
    <footer
        class="bg-white dark:bg-background-dark py-16 px-6 lg:px-20 border-t border-[#f3e7ed] dark:border-[#3d2030]">
        <div class="max-w-[1440px] mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12">
            <div class="flex flex-col gap-6">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-primary text-3xl">auto_fix_high</span>
                    <h2 class="text-xl font-bold tracking-tighter serif-text">Bunga Cosmetics</h2>
                </div>
                <p class="text-sm text-gray-500 leading-relaxed">
                    Redefining luxury beauty through innovative formulas and sustainable practices. Empowerment through
                    aesthetic perfection.
                </p>
                <div class="flex gap-4">
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                        <svg class="size-6" fill="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z">
                            </path>
                        </svg>
                    </a>
                    <a class="text-gray-400 hover:text-primary transition-colors" href="#">
                        <svg class="size-6" fill="currentColor" viewbox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.947.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.947-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.947 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.948-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z">
                            </path>
                        </svg>
                    </a>
                </div>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-xs">Products</h4>
                <ul class="flex flex-col gap-4 text-sm text-gray-500">
                    <li><a class="hover:text-primary transition-colors" href="#">Best Sellers</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Lipstick</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Foundation</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Eyeshadow</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Skincare</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-xs">Company</h4>
                <ul class="flex flex-col gap-4 text-sm text-gray-500">
                    <li><a class="hover:text-primary transition-colors" href="#">About Us</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Careers</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Sustainability</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Press</a></li>
                </ul>
            </div>
            <div>
                <h4 class="font-bold mb-6 uppercase tracking-widest text-xs">Support</h4>
                <ul class="flex flex-col gap-4 text-sm text-gray-500">
                    <li><a class="hover:text-primary transition-colors" href="#">Contact Us</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Shipping &amp; Returns</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">FAQ</a></li>
                    <li><a class="hover:text-primary transition-colors" href="#">Privacy Policy</a></li>
                </ul>
            </div>
        </div>
        <div
            class="max-w-[1440px] mx-auto mt-16 pt-8 border-t border-[#f3e7ed] dark:border-[#3d2030] flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-xs text-gray-400">© 2026 Bunga Cosmetics. All rights reserved.</p>
            <div class="flex gap-4 grayscale opacity-50">
                <div class="h-6 w-10 bg-gray-200 rounded"></div>
                <div class="h-6 w-10 bg-gray-200 rounded"></div>
                <div class="h-6 w-10 bg-gray-200 rounded"></div>
            </div>
        </div>
    </footer>

    <script>
        (function () {
            var btn = document.getElementById('mobileMenuButton');
            var menu = document.getElementById('mobileMenu');
            var closeBtn = document.getElementById('mobileMenuClose');
            var backdrop = document.getElementById('mobileMenuBackdrop');

            if (!btn || !menu) return;

            function openMenu() {
                menu.classList.remove('hidden');
                btn.setAttribute('aria-expanded', 'true');
                document.body.style.overflow = 'hidden';
            }

            function closeMenu() {
                menu.classList.add('hidden');
                btn.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            btn.addEventListener('click', function () {
                if (menu.classList.contains('hidden')) openMenu();
                else closeMenu();
            });

            if (closeBtn) closeBtn.addEventListener('click', closeMenu);
            if (backdrop) backdrop.addEventListener('click', closeMenu);

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') closeMenu();
            });
        })();
    </script>

    <script>
        (function () {
            var button = document.getElementById('userMenuButton');
            var menu = document.getElementById('userMenu');

            if (!button || !menu) return;

            function isOpen() {
                return !menu.classList.contains('hidden');
            }

            function open() {
                menu.classList.remove('hidden');
                button.setAttribute('aria-expanded', 'true');
            }

            function close() {
                menu.classList.add('hidden');
                button.setAttribute('aria-expanded', 'false');
            }

            button.addEventListener('click', function (e) {
                e.stopPropagation();
                if (isOpen()) close();
                else open();
            });

            menu.addEventListener('click', function (e) {
                e.stopPropagation();
            });

            document.addEventListener('click', function () {
                close();
            });

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') close();
            });
        })();
    </script>
</body>

</html>
