@extends('layouts.app')

@section('title', 'About')

@section('content')
    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-10">
        <section class="relative overflow-hidden rounded-[2.5rem] border-2 border-primary/10 bg-white/70 dark:bg-zinc-900/40 backdrop-blur-md p-8 sm:p-12">
            <div class="absolute -top-10 -right-10 size-48 rounded-full bg-primary/10 blur-2xl"></div>
            <div class="absolute -bottom-10 -left-10 size-48 rounded-full bg-candy-pink/80 blur-2xl"></div>

            <div class="relative">
                <div class="inline-flex items-center gap-2 rounded-full border-2 border-primary/15 bg-white/70 dark:bg-white/10 px-4 py-2 text-primary">
                    <span class="material-symbols-outlined">icecream</span>
                    <span class="text-sm font-extrabold tracking-tight">MiniMOO Story</span>
                </div>

                <h1 class="mt-6 text-4xl sm:text-5xl font-black tracking-tight text-[#181113] dark:text-white">
                    A cute snack shop,
                    <span class="text-primary">whimsy-first</span>
                    and made with heart.
                </h1>

                <p class="mt-4 max-w-2xl text-primary/70 text-lg font-medium">
                    MiniMOO is for people who believe one tiny treat can turn a whole day around. We curate genuinely tasty snacks, adorable packaging, and a shopping experience that makes you smile.
                </p>

                <div class="mt-8 flex flex-col sm:flex-row gap-3">
                    <a href="{{ route('shop.index') }}"
                        class="inline-flex items-center justify-center gap-2 bg-primary text-white font-black px-7 py-4 rounded-full shadow-[0_10px_25px_-8px_rgba(244,37,89,0.55)] hover:opacity-95 active:scale-95 transition-all">
                        <span class="material-symbols-outlined">storefront</span>
                        Browse the Shop
                    </a>
                    <a href="{{ route('contact') }}"
                        class="inline-flex items-center justify-center gap-2 bg-white/70 dark:bg-white/10 border-2 border-primary/15 text-primary font-black px-7 py-4 rounded-full hover:border-primary/30 active:scale-95 transition-all">
                        <span class="material-symbols-outlined">mail</span>
                        Contact Us
                    </a>
                </div>
            </div>
        </section>

        <section class="mt-12 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-7 shadow-xl shadow-primary/5">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">favorite</span>
                </div>
                <h2 class="mt-4 text-xl font-black">Sweetness, but serious</h2>
                <p class="mt-2 text-primary/70 font-medium">
                    We pick snacks that taste amazing — not just the cute ones.
                </p>
            </div>

            <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-7 shadow-xl shadow-primary/5">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">local_shipping</span>
                </div>
                <h2 class="mt-4 text-xl font-black">Packed with care</h2>
                <p class="mt-2 text-primary/70 font-medium">
                    So your treats arrive happy: neat, protected, and ready to snack.
                </p>
            </div>

            <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-7 shadow-xl shadow-primary/5">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">stars</span>
                </div>
                <h2 class="mt-4 text-xl font-black">Delightfully cute vibes</h2>
                <p class="mt-2 text-primary/70 font-medium">
                    From the visuals to the checkout flow — everything is playful and adorable.
                </p>
            </div>
        </section>

        <section class="mt-12 rounded-[2.5rem] border-2 border-primary/10 bg-white/70 dark:bg-zinc-900/40 backdrop-blur-md p-8 sm:p-12 overflow-hidden relative">
            <div class="absolute -right-12 -top-12 size-52 rounded-full bg-primary/10 blur-2xl"></div>
            <div class="relative grid grid-cols-1 lg:grid-cols-2 gap-10">
                <div>
                    <h2 class="text-3xl font-black">Why the name MiniMOO?</h2>
                    <p class="mt-3 text-primary/70 font-medium">
                        Because we wanted a brand that feels “small but mood-boosting.” Like a tiny <span class="font-extrabold text-primary">moo</span> that instantly makes you grin.
                    </p>

                    <div class="mt-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-6">
                            <p class="text-xs font-black uppercase tracking-widest text-primary/60">Fun fact</p>
                            <p class="mt-2 font-extrabold text-primary">A “tiny treat” is a fast mood booster.</p>
                        </div>
                        <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-6">
                            <p class="text-xs font-black uppercase tracking-widest text-primary/60">Fun fact</p>
                            <p class="mt-2 font-extrabold text-primary">Cute packaging makes snacks feel extra special.</p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2.5rem] border-2 border-primary/10 bg-gradient-to-br from-candy-pink/80 via-white/70 to-white dark:from-zinc-800/40 dark:via-zinc-900/40 dark:to-zinc-900/50 p-8">
                    <h3 class="text-2xl font-black">MiniMOO Promise</h3>
                    <ul class="mt-5 space-y-4">
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            <span class="font-semibold text-primary/80">Clear info, honest photos, fair prices.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            <span class="font-semibold text-primary/80">Easy checkout, easy wishlist, happy shopping.</span>
                        </li>
                        <li class="flex gap-3">
                            <span class="material-symbols-outlined text-primary">check_circle</span>
                            <span class="font-semibold text-primary/80">Friendly support — like chatting with a friend.</span>
                        </li>
                    </ul>

                    <div class="mt-7 rounded-3xl bg-white/70 dark:bg-white/10 border-2 border-primary/10 p-6">
                        <p class="text-sm font-extrabold text-primary">Want to collaborate or consign your products?</p>
                        <p class="mt-1 text-primary/70 font-medium">Reach out via our Contact page — we’re friendly, promise.</p>
                        <a href="{{ route('contact') }}" class="mt-4 inline-flex items-center gap-2 text-primary font-black hover:underline">
                            <span class="material-symbols-outlined">arrow_right_alt</span>
                            Go to Contact
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
