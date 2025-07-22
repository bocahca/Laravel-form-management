<nav class="mt-8 pt-4 px-4 space-y-2">
    @php
        $role = auth()->user()->role;
        $isActive = request()->routeIs("$role.dashboard");
    @endphp
    {{-- Home --}}
    <a href="{{ route("$role.dashboard") }}" class="flex items-center rounded-md transition-colors duration-200 w-full"
        :class="sidebarOpen
            ?
            '{{ $isActive
                ? 'bg-primary text-white px-3 py-2 justify-start'
                : 'text-gray-700 hover:bg-gray-100 hover:text-primary px-3 py-2 justify-start' }}' :
            '{{ $isActive
                ? 'bg-primary text-white p-2 justify-center'
                : 'text-gray-700 hover:bg-gray-100 p-2 justify-center' }}'">
        {{-- Icon Home --}}
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
            class="size-6 flex-shrink-0">
            <path stroke-linecap="round" stroke-linejoin="round"
                d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
        </svg>

        <span x-show="sidebarOpen" class="font-medium">Home</span>
    </a>
    @if ($role === 'admin')
        {{-- Forms --}}
        <a href="#"
            class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors
              {{ request()->routeIs('forms.*')
                  ? 'bg-primary text-white'
                  : 'text-gray-700 hover:bg-gray-100 hover:text-primary' }}">
            {{-- Icon Clipboard --}}
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                stroke="currentColor" class="size-6 flex-shrink-0">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 7.5h1.5m-1.5 3h1.5m-7.5 3h7.5m-7.5 3h7.5m3-9h3.375c.621 0 1.125.504 1.125 1.125V18a2.25 2.25 0 0 1-2.25 2.25M16.5 7.5V18a2.25 2.25 0 0 0 2.25 2.25M16.5 7.5V4.875c0-.621-.504-1.125-1.125-1.125H4.125C3.504 3.75 3 4.254 3 4.875V18a2.25 2.25 0 0 0 2.25 2.25h13.5M6 7.5h3v3H6v-3Z" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Forms</span>
        </a>
        {{-- Submissions --}}
        <a href="#"
            class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors
              {{ request()->routeIs('submissions.*')
                  ? 'bg-primary text-white'
                  : 'text-gray-700 hover:bg-gray-100 hover:text-primary' }}">
            {{-- Icon Clipboard List --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="size-6 flex-shrink-0">
                <path
                    d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                <path fill-rule="evenodd"
                    d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z"
                    clip-rule="evenodd" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Submissions</span>
        </a>
    @else
        <a href="#"
            class="flex items-center space-x-3 px-3 py-2 rounded-md transition-colors
              {{ request()->routeIs('submissions.*')
                  ? 'bg-primary text-white'
                  : 'text-gray-700 hover:bg-gray-100 hover:text-primary' }}">
            {{-- Icon Clipboard List --}}
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                class="size-6 flex-shrink-0">
                <path
                    d="M3.375 3C2.339 3 1.5 3.84 1.5 4.875v.75c0 1.036.84 1.875 1.875 1.875h17.25c1.035 0 1.875-.84 1.875-1.875v-.75C22.5 3.839 21.66 3 20.625 3H3.375Z" />
                <path fill-rule="evenodd"
                    d="m3.087 9 .54 9.176A3 3 0 0 0 6.62 21h10.757a3 3 0 0 0 2.995-2.824L20.913 9H3.087ZM12 10.5a.75.75 0 0 1 .75.75v4.94l1.72-1.72a.75.75 0 1 1 1.06 1.06l-3 3a.75.75 0 0 1-1.06 0l-3-3a.75.75 0 1 1 1.06-1.06l1.72 1.72v-4.94a.75.75 0 0 1 .75-.75Z"
                    clip-rule="evenodd" />
            </svg>
            <span x-show="sidebarOpen" class="font-medium">Test</span>
        </a>
    @endif
</nav>
