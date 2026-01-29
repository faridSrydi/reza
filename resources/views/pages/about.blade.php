@extends('layouts.app')

@section('title', 'About')

@section('content')

    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        body {
            @apply font-display bg-background-light dark:bg-background-dark text-[#1b0d14] dark:text-white transition-colors duration-300;
        }

        .serif-text {
            @apply font-serif;
        }

        .reveal-on-scroll {
            opacity: 0;
            transform: translateY(20px);
            transition: all 0.8s ease-out;
        }

        .reveal-on-scroll.active {
            opacity: 1;
            transform: translateY(0);
        }
    </style>

        <section class="px-6 lg:px-20 py-24 text-center">
            <div class="max-w-3xl mx-auto">
                <span class="text-primary font-bold uppercase tracking-[0.3em] text-xs mb-6 block">Our Legacy</span>
                <h1 class="text-5xl lg:text-7xl font-bold leading-tight serif-text mb-8">
                    Beauty that <br /><span class="italic font-normal text-primary">Transports</span> You.
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-xl font-light leading-relaxed">
                    Founded in 2018, Bunga Cosmetics was created to bridge the gap between runway-ready glamour and ethical,
                    skin-first science. We believe true luxury is found in the intersection of performance and
                    conscience.
                </p>
            </div>
        </section>
        <section class="px-6 lg:px-20 py-12">
            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <div class="relative group">
                    <div class="aspect-[4/5] rounded-2xl overflow-hidden shadow-2xl">
                        <div class="w-full h-full bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                            data-alt="Founders of Bunga Cosmetics in an elegant studio setting"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDFeTl7PnG9U0aHcyHFA3ogsywCj940rvmBlVRIyq9my06vaxkI_CkIoErnt0GWFebrwjKGINyCUWsPOOsdke3L5PtjvCpBFMD-aGQL2Dmupx_Bx8cIL82O6SRVFBj2PJroYNZ1u3X0scLk2BqydpkyVzx_U2hDmXk5BPrJQAf_5CESRe69VB-mKY6XCKrICACEPL34stqbS5AxGJFCpVimFlTWfNQhAO0u4-mj6yqwuB0g939FgoTfpTZyDCbym7yHwLJTycxrFBM");'>
                        </div>
                    </div>
                    <div
                        class="absolute -bottom-6 -right-6 bg-white dark:bg-background-dark p-8 rounded-xl shadow-xl max-w-xs border border-[#f3e7ed] dark:border-[#3d2030]">
                        <p class="serif-text italic text-lg leading-relaxed mb-4">"We wanted to create products that
                            make you feel as good as you look."</p>
                        <span class="text-sm font-bold tracking-widest uppercase">— The Founders</span>
                    </div>
                </div>
                <div class="flex flex-col gap-8 lg:pl-12">
                    <h2 class="text-4xl font-bold serif-text">A Visionary Beginning</h2>
                    <p class="text-gray-600 dark:text-gray-300 leading-loose">
                        What started in a small boutique laboratory in Paris has evolved into a global movement. Our
                        founders, Elena and Julian, combined their backgrounds in chemistry and couture fashion to
                        redefine the cosmetics industry.
                    </p>
                    <p class="text-gray-600 dark:text-gray-300 leading-loose">
                        They spent three years perfecting our signature 'Glow Matrix'—a unique blend of diamond dust and
                        botanical stem cells that gives Bunga Cosmetics products their unparalleled finish. Today, we remain
                        family-owned and fiercely independent.
                    </p>
                    <div class="h-px w-24 bg-primary"></div>
                </div>
            </div>
        </section>
        <section class="px-6 lg:px-20 py-24 bg-white dark:bg-[#1b0d14]/30">
            <div class="text-center mb-16">
                <h2 class="text-4xl font-bold serif-text">Uncompromising Standards</h2>
                <p class="text-gray-500 mt-4">The pillars that define every formula we create.</p>
            </div>
            <div class="grid md:grid-cols-3 gap-12">
                <div
                    class="flex flex-col items-center text-center gap-6 p-8 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] hover:bg-[#f8f6f7] dark:hover:bg-[#2d1622] transition-colors">
                    <div class="size-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-4xl">eco</span>
                    </div>
                    <h3 class="text-xl font-bold serif-text">100% Vegan &amp; Cruelty Free</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        We never test on animals and never use animal-derived ingredients. Our commitment to our furry
                        friends is absolute and certified.
                    </p>
                </div>
                <div
                    class="flex flex-col items-center text-center gap-6 p-8 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] hover:bg-[#f8f6f7] dark:hover:bg-[#2d1622] transition-colors">
                    <div class="size-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-4xl">recycling</span>
                    </div>
                    <h3 class="text-xl font-bold serif-text">Sustainable Luxury</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        From FSC-certified paper to refillable glass jars, we are constantly innovating to reduce our
                        environmental footprint without sacrificing elegance.
                    </p>
                </div>
                <div
                    class="flex flex-col items-center text-center gap-6 p-8 rounded-2xl border border-[#f3e7ed] dark:border-[#3d2030] hover:bg-[#f8f6f7] dark:hover:bg-[#2d1622] transition-colors">
                    <div class="size-16 rounded-full bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined text-4xl">science</span>
                    </div>
                    <h3 class="text-xl font-bold serif-text">Clean Formulation</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                        Formulated without parabens, sulfates, or phthalates. We ban over 2,500 ingredients to ensure
                        your skin receives only the best.
                    </p>
                </div>
            </div>
        </section>
        <section class="px-6 lg:px-20 py-24">
            <div class="grid lg:grid-cols-5 gap-4 h-[600px]">
                <div class="lg:col-span-2 relative overflow-hidden rounded-2xl">
                    <div class="w-full h-full bg-cover bg-center hover:scale-110 transition-transform duration-1000"
                        data-alt="High-quality close up of lipstick production"
                        style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDzqIBNjdCLO73pvNfsHa0Tp84rABwdtC2wFOyiogSHbHC2EwLMcg8YSC47xMa9k5PPVntYiodOIEr4JzfLS76hxSLivu0UHxZQ-_06C6uFbpd8YLVlCZjMK5XrT4wCKsozkhdif2Q9l8gdoFzXKW-OblPZzCbePycESPWyEw41zSfb63RlVNIZkp8HBmfi9p6PnY-5fjvskXCkh59iAU8YchJbyK0iyw5ZYtCqWGT5MT_dWPd7a-sFWUFHjoEG73g-Ndu6UENcw_w");'>
                    </div>
                    <div class="absolute inset-0 bg-black/20"></div>
                    <div class="absolute bottom-8 left-8">
                        <span class="text-white text-xs font-bold tracking-widest uppercase">The Process</span>
                        <h4 class="text-white text-2xl serif-text mt-2">Precision Crafting</h4>
                    </div>
                </div>
                <div class="lg:col-span-3 flex flex-col gap-4">
                    <div class="flex-1 relative overflow-hidden rounded-2xl">
                        <div class="w-full h-full bg-cover bg-center hover:scale-110 transition-transform duration-1000"
                            data-alt="Makeup laboratory setting with scientific equipment"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDgVMyUfihs9652YO_3k72_RNLn6Vu7u8ki-55XLFVbggiQt4u-X9kFYTRsAUsf2egiSTmDCZeZTH6MJb1qAmmMiqca1pwMSz9F5sdoi3Q5P3BXxCvxP9zHKh_V-89FCPPEgvNUvYK7x2vgvFuJY7AkYSMbpZcPBie34ZBYjaPKLOZdWRorueqU9c1JfpJDsWG-KdltVwce1KJ6dBd_Jz9lI_OF1dQQa9l2IsSNzChhDdPdzMflqZS-ITRyf27bREwwwAyO8cynxes");'>
                        </div>
                        <div class="absolute inset-0 bg-black/10"></div>
                    </div>
                    <div class="flex-1 grid grid-cols-2 gap-4">
                        <div class="relative overflow-hidden rounded-2xl">
                            <div class="w-full h-full bg-cover bg-center hover:scale-110 transition-transform duration-1000"
                                data-alt="Founder working in the lab"
                                style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuA7mxUe6bsHHuVjUUqQhT1RYq8apmGn-LVKRLNO7CF6RaRmUIpeb8jHxgO8toJD97RxsJVrAfpMowDJE3Q_q_KbgRg7ZVtK6TEHvuHJu2paJZ4I9XHHzas_pl4TMg3MUo2zUAlTXcUmzVvyocnMASnrhw_PuGi0xbuVYrMp3SfYgEWgz3q13uqgkSx16i_ZziUipdLP58oVyIq4lVe5Z7cM2teiphjyYWI98LXFkM9UD7Kqzpx8DcBb7Si42X3C_YCcLX_HJgFkeis");'>
                            </div>
                        </div>
                        <div class="bg-primary/5 dark:bg-[#3d2030] p-8 flex flex-col justify-center rounded-2xl">
                            <h4 class="text-2xl font-bold serif-text mb-4 text-primary">Scientifically Proven</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                                Every batch is hand-tested in our Parisian lab to ensure the pigment density and texture
                                meet our rigorous standards.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="px-6 lg:px-20 py-24">
            <div class="bg-primary/5 dark:bg-[#3d2030] rounded-3xl p-12 lg:p-24 text-center">
                <div class="max-w-2xl mx-auto flex flex-col items-center gap-8">
                    <h2 class="text-4xl lg:text-5xl font-bold serif-text">Experience the Bunga Cosmetics Difference</h2>
                    <p class="text-lg text-gray-600 dark:text-gray-300 leading-relaxed">
                        We invite you to discover our collections and join our community of beauty enthusiasts who
                        refuse to compromise.
                    </p>
                    <div class="flex gap-4">
                        <button
                            class="bg-primary text-white font-bold px-10 h-14 rounded-full hover:opacity-90 transition-all hover:scale-105">
                            Shop Collection
                        </button>
                        <button
                            class="border border-primary text-primary font-bold px-10 h-14 rounded-full hover:bg-primary hover:text-white transition-all">
                            Follow Our Journey
                        </button>
                    </div>
                </div>
            </div>
        </section>
@endsection
