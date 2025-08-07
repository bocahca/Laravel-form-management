<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<title>
    @hasSection('title')
        @yield('title')
    @else
        {{ auth()->user()->role === 'admin' ? 'Dashboard Admin' : 'Dashboard User' }}
    @endif
</title>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
    {{-- Masukkan CSS/JS via Vite --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-sans antialiased bg-gray-100">

    <div x-data="{
        manualOpen: JSON.parse(localStorage.getItem('sidebarManual')) || false,
        sidebarOpen: false,

        openSidebar() {
            if (!this.manualOpen) this.sidebarOpen = true;
        },
        closeSidebar() {
            if (!this.manualOpen) this.sidebarOpen = false;
        },
        toggleManual() {
            this.manualOpen = !this.manualOpen;
            this.sidebarOpen = this.manualOpen;
        }
    }" x-init="sidebarOpen = manualOpen;

    $watch('manualOpen', val => localStorage.setItem('sidebarManual', JSON.stringify(val)));" class="flex min-h-screen">

        <!-- Sidebar -->
        <aside @mouseenter="openSidebar()" @mouseleave="closeSidebar()" :class="sidebarOpen ? 'w-64' : 'w-16'"
            class="bg-white border-r transition-all duration-300 sticky top-0 h-screen">
            @include('layouts.sidebar')
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col">

            <!-- Topbar -->
            <header class="bg-white shadow flex items-center justify-between px-6 py-4">
                <div class="flex items-center space-x-4">
                    <button @click="toggleManual()" class="p-2 rounded hover:bg-gray-100">
                        <svg :class="sidebarOpen ? 'rotate-180' : ''"
                            class="w-6 h-6 text-gray-600 transition-transform duration-300" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                    <h2 class="text-xl font-semibold text-[#1F4E79]">
                        @hasSection('pageHeading')
                            @yield('pageHeading')
                        @else
                            {{ auth()->user()->role === 'admin' ? 'Dashboard Admin' : 'Dashboard' }}
                        @endif
                    </h2>
                </div>
                @include('layouts.navigation')
            </header>

            <main class="p-6 overflow-auto">
                @yield('content')
            </main>
        </div>
    </div>

    @livewireScripts
</body>

</html>
