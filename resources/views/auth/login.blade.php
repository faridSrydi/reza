@extends('layouts.app')

@section('content')
    <style type="text/tailwindcss">
        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 300, 'GRAD' 0, 'opsz' 24;
        }

        body {
            font-family: "Plus Jakarta Sans", sans-serif;
        }

        .serif-text {
            font-family: "Playfair Display", serif;
        }

        .form-input:focus {
            @apply border-primary ring-0;
        }
    </style>

        <div class="w-full px-6 lg:px-20 py-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 w-full overflow-hidden rounded-3xl border border-[#f3e7ed] dark:border-[#3d2030] bg-white dark:bg-background-dark">
            <div class="hidden lg:block relative overflow-hidden">
                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-1000 hover:scale-105"
                    data-alt="Luxury beauty products and model aesthetic"
                    style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDFeTl7PnG9U0aHcyHFA3ogsywCj940rvmBlVRIyq9my06vaxkI_CkIoErnt0GWFebrwjKGINyCUWsPOOsdke3L5PtjvCpBFMD-aGQL2Dmupx_Bx8cIL82O6SRVFBj2PJroYNZ1u3X0scLk2BqydpkyVzx_U2hDmXk5BPrJQAf_5CESRe69VB-mKY6XCKrICACEPL34stqbS5AxGJFCpVimFlTWfNQhAO0u4-mj6yqwuB0g939FgoTfpTZyDCbym7yHwLJTycxrFBM");'>
                </div>
                <div class="absolute inset-0 bg-black/10"></div>
                <div class="absolute bottom-20 left-20 right-20 text-white">
                    <h2 class="text-5xl font-bold serif-text mb-4 leading-tight">Elevate Your<br />Beauty Ritual</h2>
                    <p class="text-lg font-light max-w-md opacity-90">Join our exclusive community and discover the
                        pinnacle of luxury makeup and skincare.</p>
                </div>
            </div>

            <div class="flex items-center justify-center p-8 lg:p-24">
                <div class="w-full max-w-md flex flex-col gap-8">
                    <div class="flex flex-col gap-2">
                        <h1 class="text-4xl font-bold serif-text">Welcome Back</h1>
                        <p class="text-gray-500 dark:text-gray-400">Please enter your details to sign in.</p>
                    </div>

                    {{-- Fungsi Error Handling --}}
                    @if ($errors->any())
                        <div class="p-4 bg-red-50 border-l-4 border-red-600 rounded-r-lg">
                            <p class="text-xs font-bold text-red-600 uppercase tracking-tight">
                                {{ $errors->first() }}
                            </p>
                        </div>
                    @endif

                    {{-- Form Mulai Disini --}}
                    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
                        @csrf

                        <div class="flex flex-col gap-2">
                            <label class="text-sm font-semibold uppercase tracking-wider text-gray-400" for="email">Email
                                Address</label>
                            <input
                                class="form-input w-full h-14 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary"
                                id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                                type="text" required autofocus />
                        </div>

                        <div class="flex flex-col gap-2">
                            <div class="flex justify-between items-center">
                                <label class="text-sm font-semibold uppercase tracking-wider text-gray-400"
                                    for="password">Password</label>
                                <button type="button" class="text-xs font-bold text-primary hover:underline">Forgot
                                    Password?</button>
                            </div>
                            <input
                                class="form-input w-full h-14 px-4 rounded-lg bg-[#f8f6f7] dark:bg-[#2d1622] border-[#f3e7ed] dark:border-[#3d2030] text-sm focus:ring-primary"
                                id="password" name="password" placeholder="••••••••" type="password" required />
                        </div>

                        <div class="flex items-center gap-2 mt-2">
                            <input class="rounded text-primary focus:ring-primary border-[#f3e7ed] cursor-pointer"
                                id="remember" name="remember" type="checkbox" />
                            <label class="text-sm text-gray-500 cursor-pointer" for="remember">Remember me</label>
                        </div>

                        <button
                            class="w-full h-14 bg-primary text-white font-bold rounded-lg hover:opacity-90 transition-opacity mt-2"
                            type="submit">
                            Login
                        </button>

                        <div class="relative flex items-center py-4">
                            <div class="flex-grow border-t border-[#f3e7ed] dark:border-[#3d2030]"></div>
                            <span
                                class="flex-shrink mx-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Or</span>
                            <div class="flex-grow border-t border-[#f3e7ed] dark:border-[#3d2030]"></div>
                        </div>

                        <a href="{{ route('auth.google.redirect') }}"
                            class="w-full h-14 flex items-center justify-center gap-3 bg-white dark:bg-transparent border border-[#f3e7ed] dark:border-[#3d2030] rounded-lg text-sm font-bold hover:bg-[#f8f6f7] dark:hover:bg-[#3d2030] transition-colors">
                            <svg class="size-5" viewBox="0 0 24 24">
                                <path
                                    d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"
                                    fill="#4285F4"></path>
                                <path
                                    d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"
                                    fill="#34A853"></path>
                                <path
                                    d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"
                                    fill="#FBBC05"></path>
                                <path
                                    d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"
                                    fill="#EA4335"></path>
                            </svg>
                            Sign in with Google
                        </a>
                    </form>

                    <div class="text-center text-sm text-gray-500">
                        Don't have an account?
                        <a class="text-primary font-bold hover:underline" href="{{ route('register') }}">Create
                            Account</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
@endsection
