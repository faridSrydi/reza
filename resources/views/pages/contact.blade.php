@extends('layouts.app')

@section('title', 'Contact')

@section('content')
    <main class="flex-1 max-w-[1280px] mx-auto w-full px-6 py-10">
        <section class="relative overflow-hidden rounded-[2.5rem] border-2 border-primary/10 bg-white/70 dark:bg-zinc-900/40 backdrop-blur-md p-8 sm:p-12">
            <div class="absolute -top-10 -left-10 size-48 rounded-full bg-primary/10 blur-2xl"></div>
            <div class="absolute -bottom-10 -right-10 size-48 rounded-full bg-candy-pink/80 blur-2xl"></div>

            <div class="relative">
                <div class="inline-flex items-center gap-2 rounded-full border-2 border-primary/15 bg-white/70 dark:bg-white/10 px-4 py-2 text-primary">
                    <span class="material-symbols-outlined">mail</span>
                    <span class="text-sm font-extrabold tracking-tight">Say hi 👋 (keep it cute)</span>
                </div>

                <h1 class="mt-6 text-4xl sm:text-5xl font-black tracking-tight text-[#181113] dark:text-white">
                    Contact <span class="text-primary">MiniMOO</span>
                </h1>

                <p class="mt-4 max-w-2xl text-primary/70 text-lg font-medium">
                    No forms today — just drop by, follow us, or ping our socials. We’re always happy to help.
                </p>
            </div>
        </section>

        <section class="mt-10 grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-7 shadow-xl shadow-primary/5">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">location_on</span>
                </div>
                <h2 class="mt-4 text-xl font-black">Offline Store</h2>
                <p class="mt-2 text-primary/70 font-medium">
                    MiniMOO Candy Corner<br />
                    Jakarta, Indonesia
                </p>
                <p class="mt-1 text-xs font-bold text-primary/50 uppercase tracking-widest">(update address anytime)</p>
            </div>

            <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-7 shadow-xl shadow-primary/5">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">share</span>
                </div>
                <h2 class="mt-4 text-xl font-black">Socials</h2>
                <div class="mt-2 flex flex-col gap-2 text-primary/70 font-medium">
                    <a class="inline-flex items-center gap-2 hover:text-primary font-bold" target="_blank" rel="noopener" href="https://instagram.com/">
                        <span class="material-symbols-outlined text-primary">photo_camera</span>
                        Instagram
                        <span class="text-primary/50 font-semibold">@minimoo.sweets</span>
                    </a>
                    <a class="inline-flex items-center gap-2 hover:text-primary font-bold" target="_blank" rel="noopener" href="https://tiktok.com/">
                        <span class="material-symbols-outlined text-primary">music_note</span>
                        TikTok
                        <span class="text-primary/50 font-semibold">@minimoo.sweets</span>
                    </a>
                    <a class="inline-flex items-center gap-2 hover:text-primary font-bold" target="_blank" rel="noopener" href="https://wa.me/">
                        <span class="material-symbols-outlined text-primary">chat</span>
                        WhatsApp
                        <span class="text-primary/50 font-semibold">(click to chat)</span>
                    </a>
                </div>
            </div>

            <div class="rounded-3xl border-2 border-primary/10 bg-white dark:bg-background-dark p-7 shadow-xl shadow-primary/5">
                <div class="size-12 rounded-2xl bg-primary/10 text-primary flex items-center justify-center">
                    <span class="material-symbols-outlined">schedule</span>
                </div>
                <h2 class="mt-4 text-xl font-black">Store Hours</h2>
                <p class="mt-2 text-primary/70 font-medium">Daily, 09:00 – 21:00</p>
                <p class="mt-1 text-xs font-bold text-primary/50 uppercase tracking-widest">(local time)</p>
            </div>
        </section>

        <section class="mt-12 grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="rounded-[2.5rem] border-2 border-primary/10 bg-white dark:bg-background-dark p-8 sm:p-10 shadow-xl shadow-primary/5">
                <h2 class="text-2xl sm:text-3xl font-black">Find Us on the Map</h2>
                <p class="mt-2 text-primary/70 font-medium">Come say hi in person — the offline store is always the cutest.</p>

                <div class="mt-6 rounded-3xl overflow-hidden border-2 border-primary/10 bg-white">
                    <iframe
                        title="MiniMOO Offline Store Map"
                        class="w-full h-[360px]"
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"
                        src="https://www.google.com/maps?q=-6.175392,106.827153&z=15&output=embed"></iframe>
                </div>

                <div class="mt-6 rounded-3xl border-2 border-primary/10 bg-candy-pink/60 dark:bg-white/5 p-6">
                    <p class="text-xs font-black uppercase tracking-widest text-primary/60">Quick Info</p>
                    <div class="mt-3 space-y-2 text-primary/80 font-semibold">
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-primary">location_on</span>
                            <span>Jakarta, Indonesia (demo pin — replace with your exact store location)</span>
                        </div>
                        <div class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-primary">schedule</span>
                            <span>Daily 09:00–21:00</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="rounded-[2.5rem] border-2 border-primary/10 bg-gradient-to-br from-candy-pink/80 via-white/70 to-white dark:from-zinc-800/40 dark:via-zinc-900/40 dark:to-zinc-900/50 p-8 sm:p-10 shadow-xl shadow-primary/5">
                <h2 class="text-2xl sm:text-3xl font-black">Tiny FAQ</h2>
                <div class="mt-6 space-y-4">
                    <div class="rounded-3xl bg-white/70 dark:bg-white/10 border-2 border-primary/10 p-6">
                        <p class="font-black text-primary">Do you take product requests?</p>
                        <p class="mt-1 text-primary/70 font-medium">Yes! DM us the brand/type you’re looking for.</p>
                    </div>
                    <div class="rounded-3xl bg-white/70 dark:bg-white/10 border-2 border-primary/10 p-6">
                        <p class="font-black text-primary">How fast do you reply?</p>
                        <p class="mt-1 text-primary/70 font-medium">Usually fast. If we’re snacking, maybe a tiny delay.</p>
                    </div>
                    <div class="rounded-3xl bg-white/70 dark:bg-white/10 border-2 border-primary/10 p-6">
                        <p class="font-black text-primary">Collabs & partnerships?</p>
                        <p class="mt-1 text-primary/70 font-medium">Absolutely. Send details via socials and we’ll chat.</p>
                    </div>
                </div>

                <div class="mt-8 rounded-3xl bg-white/70 dark:bg-white/10 border-2 border-primary/10 p-6">
                    <div class="flex items-center gap-3">
                        <span class="material-symbols-outlined text-primary">favorite</span>
                        <p class="font-black text-primary">Cute tip</p>
                    </div>
                    <p class="mt-2 text-primary/70 font-medium">
                        If you say “Hi MiniMOO!”, we’ll smile before replying.
                    </p>
                </div>
            </div>
        </section>
    </main>
@endsection
