@php
    $isMobile = $isMobile ?? false;
    $user = auth()->user();
    $userName = $user?->name ?? 'Admin';
    $userEmail = $user?->email;
    $userRole = method_exists($user, 'getRoleNames') ? ($user->getRoleNames()->first() ?? 'Admin') : 'Admin';
    $initials = collect(explode(' ', trim($userName)))
        ->filter()
        ->map(fn($p) => mb_substr($p, 0, 1))
        ->take(2)
        ->join('');

    $isDashboard = request()->routeIs('admin.dashboard');
    $isProducts = request()->routeIs('admin.products.*');
    $isCategories = request()->routeIs('admin.categories.*');
    $isOrders = request()->routeIs('admin.orders.*');
    $isAddresses = request()->routeIs('admin.addresses.*');
    $isSearch = request()->routeIs('admin.search') || request()->routeIs('admin.search.*');

    $activeClass = 'flex items-center gap-3 px-4 py-3 rounded-lg bg-primary text-white transition-colors';
    $inactiveClass = 'flex items-center gap-3 px-4 py-3 rounded-lg hover:bg-white/10 text-white/70 hover:text-white transition-colors';
@endphp

<div class="p-6 flex items-center gap-2">
    <span class="material-symbols-outlined text-primary text-3xl">auto_fix_high</span>
    <a href="{{ route('admin.dashboard') }}" class="text-xl font-bold tracking-tighter serif-text">
        LUXE <span class="text-[10px] tracking-widest font-sans font-normal opacity-60 uppercase ml-1">Admin</span>
    </a>
    @if ($isMobile)
        <button type="button" class="ml-auto text-white/60 hover:text-white" data-admin-close aria-label="Close menu">
            <span class="material-symbols-outlined">close</span>
        </button>
    @endif
</div>

<nav class="flex-1 px-4 space-y-2">
    <a class="{{ $isDashboard ? $activeClass : $inactiveClass }}" href="{{ route('admin.dashboard') }}">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="text-sm font-medium">Dashboard</span>
    </a>
    <a class="{{ $isProducts ? $activeClass : $inactiveClass }}" href="{{ route('admin.products.index') }}">
        <span class="material-symbols-outlined">inventory_2</span>
        <span class="text-sm font-medium">Products</span>
    </a>
    <a class="{{ $isCategories ? $activeClass : $inactiveClass }}" href="{{ route('admin.categories.index') }}">
        <span class="material-symbols-outlined">category</span>
        <span class="text-sm font-medium">Categories</span>
    </a>

    <div class="pt-8 pb-4 px-4 text-[10px] uppercase tracking-widest text-white/30 font-bold">Reports</div>

    <a class="flex items-center gap-3 px-4 py-3 rounded-lg text-white/30 cursor-not-allowed" href="#" tabindex="-1" aria-disabled="true">
        <span class="material-symbols-outlined">settings</span>
        <span class="text-sm font-medium">Settings</span>
    </a>
</nav>

<div class="p-4 mt-auto border-t border-white/10">
    <div class="flex items-center gap-3 px-4">
        <div class="size-10 rounded-full border border-white/20 bg-white/10 flex items-center justify-center font-extrabold">
            {{ $initials !== '' ? $initials : 'A' }}
        </div>
        <div class="overflow-hidden">
            <p class="text-xs font-bold truncate text-white">{{ $userName }}</p>
            <p class="text-[10px] text-white/50 truncate">{{ $userRole }}</p>
        </div>

        <form class="ml-auto" method="POST" action="{{ \Route::has('logout') ? route('logout') : url('/logout') }}">
            @csrf
            <button type="submit" class="text-white/50 hover:text-white" aria-label="Logout">
                <span class="material-symbols-outlined text-sm">logout</span>
            </button>
        </form>
    </div>
</div>
