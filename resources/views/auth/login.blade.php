@extends('layouts.app')

@section('content')
    <style>
        .sprinkle-bg {
            background-color: #f8f5f6;
            background-image: radial-gradient(#f42559 1px, transparent 1px), radial-gradient(#ffd1dc 1px, transparent 1px);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
        }

        .heart-button {
            clip-path: path('M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z');
        }
    </style>
    <main class="flex-1 flex items-center justify-center px-4 py-10">
        <div class="w-full max-w-md">
            <div
                class="bg-white/90 dark:bg-background-dark/90 backdrop-blur-sm rounded-xl p-8 shadow-2xl border border-primary/5 flex flex-col">
                <div class="flex flex-col items-center text-center mb-8">
                    <div
                        class="w-32 h-32 bg-primary/10 rounded-full flex items-center justify-center mb-6 relative overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center opacity-90"
                            data-alt="Cute cartoon cat holding a big pink lollipop"
                            style='background-image: url("https://lh3.googleusercontent.com/aida-public/AB6AXuDSJeZy7o0mCKEep_fYe15Txu2feuabo-sSyUgs-SkjrSZlR6kyWqV5XcxkUmzLDxqFgTsCdyYaY_I2mv4kruW97wPI0FKuH6hdnDe4cU74wpboCLTCT2mxBUVLmR_rhlF6IfPzbABXFyWSyS6a8Oa-JwdJO_cxbNKkjx6zgnCxriq2UUFr3tPJw-CC0IHFHL4SFBMIFt0HVFT_kRjxkBeU17SzB3pdbqdhE6ZdI7jh3u-Lou6Qj6F6QxweOLMT4gu6WjiHqIaJHOI");'>
                        </div>
                        <span class="material-symbols-outlined text-6xl text-primary relative z-10">pets</span>
                    </div>
                    <h1 class="text-[#181113] dark:text-white text-3xl font-black mb-2">Welcome Back, Sweetie!</h1>
                    <p class="text-gray-500 dark:text-gray-400 font-medium">Log in to see your favorite snacks</p>
                </div>

                {{-- Fungsi Error Handling --}}
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-600 rounded-r-lg">
                        <p class="text-xs font-bold text-red-600 uppercase tracking-tight">
                            {{ $errors->first() }}
                        </p>
                    </div>
                @endif

                {{-- Fungsi Form Action & Method --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div class="flex flex-col gap-2">
                        <label class="text-[#181113] dark:text-gray-200 text-sm font-bold px-4">Email or Username</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">alternate_email</span>
                            {{-- Fungsi Name, Value Old, & Required --}}
                            <input name="email" value="{{ old('email') }}"
                                class="w-full h-14 pl-12 pr-6 rounded-full border-2 border-primary/10 focus:border-primary focus:ring-0 bg-primary/5 dark:bg-white/5 dark:text-white transition-all"
                                placeholder="yourname@candy.com" type="text" required autofocus />
                        </div>
                    </div>

                    <div class="flex flex-col gap-2">
                        <label class="text-[#181113] dark:text-gray-200 text-sm font-bold px-4">Secret Password</label>
                        <div class="relative">
                            <span
                                class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-primary/60">lock</span>
                            {{-- Fungsi Name & Required --}}
                            <input name="password"
                                class="w-full h-14 pl-12 pr-6 rounded-full border-2 border-primary/10 focus:border-primary focus:ring-0 bg-primary/5 dark:bg-white/5 dark:text-white transition-all"
                                placeholder="••••••••" type="password" required />
                        </div>
                    </div>

                    <div class="flex justify-between items-center px-2">
                        <label class="flex items-center gap-2 cursor-pointer group">
                            {{-- Fungsi Remember Me --}}
                            <input name="remember" class="rounded text-primary focus:ring-primary/20 border-primary/20"
                                type="checkbox" />
                            <span
                                class="text-xs font-bold text-gray-500 group-hover:text-primary transition-colors">Remember
                                me</span>
                        </label>
                        <button class="text-xs font-bold text-primary hover:underline" type="button">Forgot your
                            candy?</button>
                    </div>

                    <button
                        class="w-full bg-primary text-white h-16 rounded-full font-black text-lg flex items-center justify-center gap-2 hover:scale-[1.02] active:scale-95 transition-all shadow-xl shadow-primary/30 mt-4"
                        type="submit">
                        <span class="material-symbols-outlined">favorite</span>
                        Login
                    </button>

                    <div class="pt-2 text-center">
                        <p class="text-xs font-bold text-gray-500 dark:text-gray-400">
                            Belum punya akun?
                            <a href="{{ route('register') }}" class="text-primary hover:underline">Register</a>
                        </p>
                    </div>
                </form>

                <div class="mt-8">
                    <div class="flex items-center gap-3">
                        <div class="h-px flex-1 bg-primary/10"></div>
                        <span class="text-[11px] font-black text-primary/40 uppercase tracking-widest">Or</span>
                        <div class="h-px flex-1 bg-primary/10"></div>
                    </div>

                    <a href="{{ route('auth.google.redirect') }}"
                        class="mt-4 w-full h-14 rounded-full bg-white dark:bg-white/10 border-2 border-primary/15 hover:border-primary/25 hover:bg-primary/5 transition-all shadow-sm flex items-center justify-center gap-3 font-black text-[#181113] dark:text-white">
                        <svg class="w-5 h-5" viewBox="0 0 48 48" aria-hidden="true" focusable="false">
                            <path fill="#FFC107" d="M43.611 20.083H42V20H24v8h11.303C33.677 32.659 29.223 36 24 36c-6.627 0-12-5.373-12-12s5.373-12 12-12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4 12.954 4 4 12.954 4 24s8.954 20 20 20 20-8.954 20-20c0-1.341-.138-2.651-.389-3.917z"/>
                            <path fill="#FF3D00" d="M6.306 14.691l6.571 4.819C14.655 16.108 19.017 12 24 12c3.059 0 5.842 1.154 7.961 3.039l5.657-5.657C34.046 6.053 29.268 4 24 4c-7.682 0-14.354 4.327-17.694 10.691z"/>
                            <path fill="#4CAF50" d="M24 44c5.167 0 9.86-1.977 13.409-5.192l-6.19-5.238C29.211 35.091 26.715 36 24 36c-5.202 0-9.641-3.313-11.283-7.946l-6.522 5.025C9.505 39.556 16.227 44 24 44z"/>
                            <path fill="#1976D2" d="M43.611 20.083H42V20H24v8h11.303c-.792 2.236-2.231 4.161-4.084 5.57l.003-.002 6.19 5.238C36.971 39.205 44 34 44 24c0-1.341-.138-2.651-.389-3.917z"/>
                        </svg>
                        Continue with Google
                    </a>
                </div>
            </div>
        </div>
    </main>
@endsection
