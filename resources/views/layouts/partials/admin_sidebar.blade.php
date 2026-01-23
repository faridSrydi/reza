@php
    $isMobile = $isMobile ?? false;
    $user = auth()->user();
    $userName = $user?->name ?? 'Admin';
    $userEmail = $user?->email;
    $initials = collect(explode(' ', trim($userName)))
        ->filter()
        ->map(fn($p) => mb_substr($p, 0, 1))
        ->take(2)
        ->join('');

    $productsOpen = request()->routeIs('admin.products.*');
    $categoriesOpen = request()->routeIs('admin.categories.*');
    $ordersOpen = request()->routeIs('admin.orders.*');
@endphp

<div class="flex items-center justify-between gap-3">
    <a class="flex items-center gap-3 min-w-0" href="{{ route('admin.dashboard') }}">
        <img src="{{ asset('assets/images/icon/minimo.svg') }}" alt="Logo" class="h-15 w-auto shrink-0 nav-wiggle">
    </a>

    @if ($isMobile)
        <button type="button"
            class="h-10 w-10 shrink-0 rounded-xl border-2 border-primary/15 bg-white text-primary flex items-center justify-center"
            data-admin-close aria-label="Close menu">
            <span class="material-symbols-outlined">close</span>
        </button>
    @else
        <button id="adminDesktopCollapseButton" type="button"
            class="h-10 w-10 rounded-xl border-2 border-primary/15 bg-primary/5 text-primary flex items-center justify-center hover:bg-primary/10"
            aria-label="Toggle sidebar">
            <span class="material-symbols-outlined">dock_to_left</span>
        </button>
    @endif
</div>

<form method="GET" action="{{ route('admin.search') }}" class="admin-sidebar-label">
    <div class="relative" data-admin-live-search-container>
        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">search</span>
        <input
            name="q"
            value="{{ request('q') }}"
            placeholder="Search..."
            type="text"
            autocomplete="off"
            data-admin-live-search
            class="w-full rounded-2xl border-2 border-primary/10 bg-primary/5 focus:border-primary/20 focus:ring-0 py-3 pl-12 pr-4 text-sm font-bold text-primary placeholder:text-primary/40" />

        <div class="absolute right-4 top-1/2 -translate-y-1/2 hidden" data-admin-live-search-spinner>
            <div class="live-search-spinner"></div>
        </div>
    </div>
</form>

<nav class="flex flex-col gap-2">
    <a class="sidebar-bubble flex items-center gap-4 px-5 py-3 font-bold bg-primary/5 {{ request()->routeIs('admin.dashboard') ? 'active text-white' : 'text-primary/70 hover:text-primary' }}"
        href="{{ route('admin.dashboard') }}">
        <span class="material-symbols-outlined">dashboard</span>
        <span class="admin-sidebar-label">Dashboard</span>
    </a>

    <details class="group" {{ $productsOpen ? 'open' : '' }}>
        <summary
            class="sidebar-bubble list-none flex items-center justify-between gap-4 px-5 py-3 font-bold bg-primary/5 cursor-pointer {{ $productsOpen ? 'active text-white' : 'text-primary/70 hover:text-primary' }}">
            <span class="flex items-center gap-4">
                <span class="material-symbols-outlined">inventory_2</span>
                <span class="admin-sidebar-label">Products</span>
            </span>
            <span
                class="admin-sidebar-label material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
        </summary>
        <div class="mt-2 pl-4 admin-sidebar-label">
            <a class="block px-4 py-2 rounded-2xl font-bold text-sm text-primary/70 hover:text-primary hover:bg-primary/5"
                href="{{ route('admin.products.index') }}">
                All Products
            </a>
            <a class="block px-4 py-2 rounded-2xl font-bold text-sm text-primary/70 hover:text-primary hover:bg-primary/5"
                href="{{ route('admin.products.create') }}">
                Create Product
            </a>
        </div>
    </details>

    <details class="group" {{ $categoriesOpen ? 'open' : '' }}>
        <summary
            class="sidebar-bubble list-none flex items-center justify-between gap-4 px-5 py-3 font-bold bg-primary/5 cursor-pointer {{ $categoriesOpen ? 'active text-white' : 'text-primary/70 hover:text-primary' }}">
            <span class="flex items-center gap-4">
                <span class="material-symbols-outlined">category</span>
                <span class="admin-sidebar-label">Categories</span>
            </span>
            <span
                class="admin-sidebar-label material-symbols-outlined transition-transform group-open:rotate-180">expand_more</span>
        </summary>
        <div class="mt-2 pl-4 admin-sidebar-label">
            <a class="block px-4 py-2 rounded-2xl font-bold text-sm text-primary/70 hover:text-primary hover:bg-primary/5"
                href="{{ route('admin.categories.index') }}">
                All Categories
            </a>
            <a class="block px-4 py-2 rounded-2xl font-bold text-sm text-primary/70 hover:text-primary hover:bg-primary/5"
                href="{{ route('admin.categories.create') }}">
                Create Category
            </a>
        </div>
    </details>

    <a class="sidebar-bubble flex items-center gap-4 px-5 py-3 font-bold bg-primary/5 {{ request()->routeIs('admin.addresses.*') ? 'active text-white' : 'text-primary/70 hover:text-primary' }}"
        href="{{ route('admin.addresses.index') }}">
        <span class="material-symbols-outlined">location_on</span>
        <span class="admin-sidebar-label">Addresses</span>
    </a>

    <a class="sidebar-bubble flex items-center gap-4 px-5 py-3 font-bold bg-primary/5 {{ $ordersOpen ? 'active text-white' : 'text-primary/70 hover:text-primary' }}"
        href="{{ route('admin.orders.index') }}">
        <span class="material-symbols-outlined">receipt_long</span>
        <span class="admin-sidebar-label">Orders</span>
    </a>
</nav>

<div class="mt-auto">
    <details class="group rounded-[2rem] border-2 border-dashed border-primary/20 bg-primary/5 p-4">
        <summary class="list-none flex items-center gap-3 cursor-pointer">
            <div
                class="h-11 w-11 rounded-2xl bg-white border-2 border-primary/15 flex items-center justify-center text-primary font-black">
                {{ $initials !== '' ? $initials : 'A' }}
            </div>
            <div class="min-w-0 admin-sidebar-label">
                <div class="font-black text-primary truncate">{{ $userName }}</div>
                @if ($userEmail)
                    <div class="text-[11px] font-bold text-primary/50 truncate">{{ $userEmail }}</div>
                @endif
            </div>
            <span
                class="admin-sidebar-label ml-auto material-symbols-outlined text-primary/60 transition-transform group-open:rotate-180">expand_more</span>
        </summary>

        <div class="mt-3 admin-sidebar-label">
            <form method="POST" action="{{ \Route::has('logout') ? route('logout') : url('/logout') }}">
                @csrf
                <button type="submit"
                    class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-primary text-white font-extrabold hover:opacity-95 active:scale-[0.99] transition-all">
                    <span class="material-symbols-outlined text-[20px]">logout</span>
                    Logout
                </button>
            </form>
        </div>
    </details>
</div>
