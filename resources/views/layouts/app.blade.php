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

    <title>{{ $title ? $title . ' · ' : '' }}{{ config('app.name', 'Nexa HR') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-slate-800">
<div x-data="{ sidebarOpen: false }" class="min-h-screen bg-slate-100">

    {{-- Mobile overlay --}}
    <div x-show="sidebarOpen" x-transition.opacity @click="sidebarOpen = false"
         class="fixed inset-0 z-30 bg-slate-900/50 lg:hidden" style="display:none"></div>

    {{-- Sidebar --}}
    <aside
        class="fixed inset-y-0 z-40 flex w-64 flex-col bg-slate-900 transition-transform duration-200 lg:translate-x-0
               {{ $isRtl ? 'end-0' : 'start-0' }}"
        :class="sidebarOpen ? 'translate-x-0' : '{{ $isRtl ? 'translate-x-full' : '-translate-x-full' }} lg:translate-x-0'">

        <div class="flex h-16 items-center gap-3 px-6">
            <div class="flex h-9 w-9 items-center justify-center rounded-lg bg-brand-600 font-bold text-white">N</div>
            <div class="leading-tight">
                <p class="text-sm font-bold text-white">{{ __('messages.brand.name') }}</p>
                <p class="text-[11px] text-slate-400">{{ __('messages.brand.tagline') }}</p>
            </div>
        </div>

        <nav class="flex-1 space-y-1 overflow-y-auto px-3 py-4">
            <p class="px-3 pb-1 pt-2 text-[11px] font-semibold uppercase tracking-wider text-slate-500">{{ __('messages.nav.main_menu') }}</p>

            <a href="{{ route('dashboard') }}" class="sidebar-link {{ request()->routeIs('dashboard') ? 'sidebar-link-active' : '' }}">
                <x-icon name="dashboard" class="h-5 w-5 shrink-0" />
                <span>{{ __('messages.nav.dashboard') }}</span>
            </a>
            <a href="{{ route('employees.index') }}" class="sidebar-link {{ request()->routeIs('employees.*') ? 'sidebar-link-active' : '' }}">
                <x-icon name="users" class="h-5 w-5 shrink-0" />
                <span>{{ __('messages.nav.employees') }}</span>
            </a>
            <a href="{{ route('departments.index') }}" class="sidebar-link {{ request()->routeIs('departments.*') ? 'sidebar-link-active' : '' }}">
                <x-icon name="building" class="h-5 w-5 shrink-0" />
                <span>{{ __('messages.nav.departments') }}</span>
            </a>
            <a href="{{ route('leaves.index') }}" class="sidebar-link {{ request()->routeIs('leaves.*') ? 'sidebar-link-active' : '' }}">
                <x-icon name="calendar" class="h-5 w-5 shrink-0" />
                <span>{{ __('messages.nav.leaves') }}</span>
                @php $pending = \App\Models\LeaveRequest::pending()->count(); @endphp
                @if($pending > 0)
                    <span class="ms-auto rounded-full bg-amber-500 px-2 py-0.5 text-[11px] font-semibold text-white">{{ $pending }}</span>
                @endif
            </a>
        </nav>

        <div class="border-t border-white/10 p-3">
            <a href="{{ route('profile.edit') }}" class="sidebar-link {{ request()->routeIs('profile.*') ? 'sidebar-link-active' : '' }}">
                <x-icon name="user-check" class="h-5 w-5 shrink-0" />
                <span>{{ __('messages.nav.profile') }}</span>
            </a>
        </div>
    </aside>

    {{-- Main column --}}
    <div class="{{ $isRtl ? 'lg:pe-64' : 'lg:ps-64' }}">

        {{-- Topbar --}}
        <header class="sticky top-0 z-20 flex h-16 items-center gap-4 border-b border-slate-200 bg-white/90 px-4 backdrop-blur sm:px-6">
            <button @click="sidebarOpen = true" class="text-slate-500 hover:text-slate-700 lg:hidden">
                <x-icon name="menu" class="h-6 w-6" />
            </button>

            <h1 class="text-base font-semibold text-slate-900 sm:text-lg">{{ $title ?? config('app.name') }}</h1>

            <div class="ms-auto flex items-center gap-2 sm:gap-3">
                {{-- Language switcher --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-1.5 rounded-lg border border-slate-200 px-2.5 py-1.5 text-sm text-slate-600 hover:bg-slate-50">
                        <x-icon name="globe" class="h-4 w-4" />
                        <span class="hidden sm:inline">{{ app()->getLocale() === 'ur' ? __('messages.common.urdu') : __('messages.common.english') }}</span>
                        <x-icon name="chevron-down" class="h-3.5 w-3.5" />
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition style="display:none"
                         class="absolute end-0 mt-2 w-36 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-card-md">
                        <a href="{{ route('locale.update', 'en') }}" class="flex items-center justify-between px-3 py-2 text-sm hover:bg-slate-50 {{ app()->getLocale() === 'en' ? 'font-semibold text-brand-600' : 'text-slate-700' }}">
                            English @if(app()->getLocale() === 'en') <x-icon name="check" class="h-4 w-4" /> @endif
                        </a>
                        <a href="{{ route('locale.update', 'ur') }}" class="flex items-center justify-between px-3 py-2 text-sm hover:bg-slate-50 {{ app()->getLocale() === 'ur' ? 'font-semibold text-brand-600' : 'text-slate-700' }}">
                            اردو @if(app()->getLocale() === 'ur') <x-icon name="check" class="h-4 w-4" /> @endif
                        </a>
                    </div>
                </div>

                {{-- User menu --}}
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="flex items-center gap-2 rounded-lg p-1 pe-2 hover:bg-slate-50">
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-sm font-semibold text-brand-700">
                            {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                        </span>
                        <span class="hidden text-sm font-medium text-slate-700 sm:inline">{{ auth()->user()->name }}</span>
                        <x-icon name="chevron-down" class="hidden h-3.5 w-3.5 text-slate-400 sm:inline" />
                    </button>
                    <div x-show="open" @click.outside="open = false" x-transition style="display:none"
                         class="absolute end-0 mt-2 w-48 overflow-hidden rounded-lg border border-slate-200 bg-white py-1 shadow-card-md">
                        <div class="border-b border-slate-100 px-4 py-2">
                            <p class="truncate text-sm font-medium text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="truncate text-xs text-slate-500">{{ auth()->user()->email }}</p>
                        </div>
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-slate-700 hover:bg-slate-50">{{ __('messages.nav.profile') }}</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 px-4 py-2 text-start text-sm text-rose-600 hover:bg-rose-50">
                                <x-icon name="logout" class="h-4 w-4" />
                                {{ __('messages.nav.logout') }}
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Flash message --}}
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
                 class="mx-4 mt-4 flex items-center gap-3 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800 sm:mx-6">
                <x-icon name="check-circle" class="h-5 w-5 shrink-0 text-emerald-600" />
                <span>{{ session('success') }}</span>
                <button @click="show = false" class="ms-auto text-emerald-600 hover:text-emerald-800">
                    <x-icon name="x" class="h-4 w-4" />
                </button>
            </div>
        @endif

        {{-- Page content --}}
        <main class="p-4 sm:p-6">
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
