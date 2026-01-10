<header class="bg-white shadow-sm sticky top-0 z-50">
    <div class="max-w-7xl mx-auto px-4">
        <div class="flex items-center justify-between h-16">


            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <span class="text-xl font-bold text-indigo-600">
                    E-Commerce
                </span>
            </a>


            {{-- Navigation (Desktop) --}}
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('home') }}"
                   class="text-gray-700 hover:text-indigo-600 font-medium transition">
                    Home
                </a>
            </nav>


            {{-- Right Section --}}
            <div class="flex items-center gap-4">


                {{-- Cart --}}
                <a href="{{ route('cart.index') }}"
                   class="relative text-gray-700 hover:text-indigo-600 transition">


                    {{-- Icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.293 2.293A1 1 0 007.618 17H17m0 0a2 2 0 100 4 2 2 0 000-4zm-10 2a2 2 0 100 4 2 2 0 000-4z" />
                    </svg>


                    {{-- Badge --}}
                    @php
                        $cartCount = session('cart')
                            ? collect(session('cart'))->sum('qty')
                            : 0;
                    @endphp


                    @if ($cartCount > 0)
                        <span
                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-semibold w-5 h-5 rounded-full flex items-center justify-center">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a>


                {{-- Mobile Menu Button --}}
                <button class="md:hidden text-gray-700 focus:outline-none"
                        onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>


        {{-- Mobile Menu --}}
        <div id="mobileMenu" class="hidden md:hidden pb-4">
            <a href="{{ route('home') }}"
               class="block py-2 text-gray-700 hover:text-indigo-600">
                Home
            </a>
        </div>
    </div>
</header>


