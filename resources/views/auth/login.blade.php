@php
    $locale = app()->getLocale();
    $isRtl = $locale === 'ur';
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', $locale) }}" dir="{{ $isRtl ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('messages.auth.sign_in') }} · {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
<div class="flex min-h-screen">

    {{-- Brand panel --}}
    <div class="relative hidden w-1/2 flex-col justify-between overflow-hidden bg-slate-900 p-12 text-white lg:flex">
        <div class="absolute -end-24 -top-24 h-96 w-96 rounded-full bg-brand-600/30 blur-3xl"></div>
        <div class="absolute -bottom-32 -start-16 h-96 w-96 rounded-full bg-brand-500/20 blur-3xl"></div>

        <div class="relative flex items-center gap-3">
            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-brand-600 text-lg font-bold">N</div>
            <span class="text-lg font-bold">{{ __('messages.brand.name') }}</span>
        </div>

        <div class="relative">
            <h2 class="text-3xl font-bold leading-snug">{{ __('messages.brand.tagline') }}</h2>
            <p class="mt-4 max-w-md text-slate-300">{{ __('messages.dashboard.subtitle') }}</p>

            <div class="mt-10 grid grid-cols-3 gap-4">
                <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                    <p class="text-2xl font-bold">14</p>
                    <p class="text-xs text-slate-400">{{ __('messages.dashboard.total_employees') }}</p>
                </div>
                <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                    <p class="text-2xl font-bold">6</p>
                    <p class="text-xs text-slate-400">{{ __('messages.dashboard.departments') }}</p>
                </div>
                <div class="rounded-xl bg-white/5 p-4 ring-1 ring-white/10">
                    <p class="text-2xl font-bold">i18n</p>
                    <p class="text-xs text-slate-400">EN · اردو</p>
                </div>
            </div>
        </div>

        <p class="relative text-xs text-slate-500">© {{ date('Y') }} {{ __('messages.brand.name') }}.</p>
    </div>

    {{-- Form panel --}}
    <div class="flex w-full flex-col justify-center px-6 py-12 lg:w-1/2 lg:px-20">
        <div class="mx-auto w-full max-w-sm">
            {{-- Mobile logo + language switch --}}
            <div class="mb-8 flex items-center justify-between">
                <div class="flex items-center gap-2 lg:hidden">
                    <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 font-bold text-white">N</div>
                    <span class="font-bold text-slate-900">{{ __('messages.brand.name') }}</span>
                </div>
                <div class="ms-auto flex gap-1 text-sm">
                    <a href="{{ route('locale.update', 'en') }}" class="rounded px-2 py-1 {{ $locale === 'en' ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-100' }}">EN</a>
                    <a href="{{ route('locale.update', 'ur') }}" class="rounded px-2 py-1 {{ $locale === 'ur' ? 'bg-slate-900 text-white' : 'text-slate-500 hover:bg-slate-100' }}">اردو</a>
                </div>
            </div>

            <h1 class="text-2xl font-bold text-slate-900">{{ __('messages.auth.welcome_back') }}</h1>
            <p class="mt-1 text-sm text-slate-500">{{ __('messages.auth.sign_in_subtitle') }}</p>

            {{-- Demo credentials --}}
            <div class="mt-6 rounded-lg border border-brand-100 bg-brand-50 px-4 py-3 text-sm">
                <p class="font-medium text-brand-800">{{ __('messages.auth.demo_note') }}</p>
                <p class="mt-1 text-brand-700" dir="ltr">admin@nexahr.test · password</p>
            </div>

            <x-auth-session-status class="mt-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="mt-6 space-y-4">
                @csrf

                <x-field name="email" :label="__('messages.auth.email')" :required="true">
                    <input id="email" type="email" name="email" value="{{ old('email', 'admin@nexahr.test') }}" class="form-input" required autofocus autocomplete="username" dir="ltr">
                </x-field>

                <x-field name="password" :label="__('messages.auth.password')" :required="true">
                    <input id="password" type="password" name="password" value="password" class="form-input" required autocomplete="current-password" dir="ltr">
                </x-field>

                <div class="flex items-center justify-between">
                    <label for="remember_me" class="inline-flex items-center gap-2 text-sm text-slate-600">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded border-slate-300 text-brand-600 focus:ring-brand-500">
                        {{ __('messages.auth.remember') }}
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-brand-600 hover:text-brand-700">{{ __('messages.auth.forgot') }}</a>
                    @endif
                </div>

                <button type="submit" class="btn-primary w-full">{{ __('messages.auth.login_button') }}</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
