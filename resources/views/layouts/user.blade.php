@extends('layouts.app')

@section('content')
    @php
        $u = auth()->user();
        $wishlistCount = $u
            ? \Illuminate\Support\Facades\DB::table('wishlists')->where('user_id', $u->id)->count()
            : 0;
        $addressCount = $u
            ? \App\Models\Address::query()->where('user_id', $u->id)->count()
            : 0;
        $orderCount = $u
            ? \App\Models\Order::query()->where('user_id', $u->id)->count()
            : 0;
    @endphp

    <section class="min-h-[calc(100vh-88px)] py-10 px-6 lg:px-20">
        <div class="flex flex-col md:flex-row gap-12">
            <aside class="w-full md:w-64 flex-shrink-0">
                <h2 class="text-2xl font-bold serif-text mb-8">Account</h2>

                <nav class="flex flex-col gap-1">
                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->is('user/dashboard') ? 'font-bold bg-white dark:bg-[#3d2030] text-primary' : 'font-medium hover:bg-white dark:hover:bg-[#3d2030] transition-colors' }}"
                        href="{{ url('/user/dashboard') }}">
                        <span class="material-symbols-outlined text-xl">dashboard</span>
                        Dashboard Overview
                    </a>


                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm {{ request()->is('addresses') || request()->is('addresses/*') ? 'font-bold bg-white dark:bg-[#3d2030] text-primary' : 'font-medium hover:bg-white dark:hover:bg-[#3d2030] transition-colors' }}"
                        href="{{ route('addresses.index') }}">
                        <span class="material-symbols-outlined text-xl">location_on</span>
                        Saved Addresses
                    </a>


                    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium hover:bg-white dark:hover:bg-[#3d2030] transition-colors"
                        href="{{ route('shop.index') }}">
                        <span class="material-symbols-outlined text-xl">storefront</span>
                        Continue Shopping
                    </a>

                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf
                        <button type="submit"
                            class="w-full flex items-center gap-3 px-4 py-3 rounded-lg text-sm font-medium hover:bg-white dark:hover:bg-[#3d2030] transition-colors text-red-500">
                            <span class="material-symbols-outlined text-xl">logout</span>
                            Sign Out
                        </button>
                    </form>
                </nav>
            </aside>

                <div>
                    @yield('user_content')
                </div>
        </div>
    </section>
@endsection
