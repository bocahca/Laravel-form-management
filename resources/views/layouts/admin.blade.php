<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Dashboard Admin') • Komdigi</title>

  {{-- Masukkan CSS/JS via Vite --}}
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100">

  {{-- Root Alpine state --}}
  <div x-data="{ sidebarOpen: true }" class="flex min-h-screen">

    <!-- Sidebar -->
    <aside
      :class="sidebarOpen ? 'w-64' : 'w-16'"
      class="bg-white border-r transition-all duration-300"
    >
      @include('layouts.sidebar')
    </aside>

    <!-- Main -->
    <div class="flex-1 flex flex-col">

      <!-- Topbar -->
      <header class="bg-white shadow flex items-center justify-between px-6 py-4">
        <div class="flex items-center space-x-4">
          {{-- Toggle btn --}}
          <button @click="sidebarOpen = !sidebarOpen"
                  class="p-2 rounded hover:bg-gray-100">
            <svg :class="sidebarOpen ? 'rotate-180' : ''"
                 class="w-6 h-6 text-gray-600 transition-transform duration-300"
                 fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
          </button>
          <h2 class="text-xl font-semibold text-[#1F4E79]">
            @yield('title','Dashboard Admin')
          </h2>
        </div>
        @include('layouts.navigation') {{-- profile dropdown --}}
      </header>

      <!-- Page content -->
      <main class="p-6 flex-1 overflow-auto">
        @yield('content')
      </main>
    </div>
  </div>
</body>
</html>
