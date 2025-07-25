{{-- resources/views/admin/forms/index.blade.php --}}
@extends('layouts.app')

@section('title', 'Daftar Form')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        {{-- Judul --}}
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Form</h1>
        </div>
        @if (session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Baris Search + Button --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 space-y-4 md:space-y-0">
            {{-- Search Form --}}
            <form action="{{ route('admin.forms.index') }}" method="GET" class="flex items-center space-x-2">
                <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                    {{-- Search input, fixed width --}}
                    <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul form…"
                        class="w-64 px-3 py-1 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
                    {{-- Submit button --}}
                    <button type="submit"
                        class="flex items-center bg-gray-200 text-gray-700 px-3 py-1 hover:bg-gray-300 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>

                        <span class="ml-1 text-sm">Cari</span>
                    </button>
                </div>
            </form>

            {{-- Button Buat Baru --}}
            <a href="{{ route('admin.forms.create') }}"
                class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 whitespace-nowrap md:ml-4">
                + Buat Form Baru
            </a>
        </div>


        @if ($forms->isEmpty())
            <div class="bg-white p-6 rounded shadow text-gray-500 text-center">
                Belum ada form.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($forms as $form)
                    <div class="bg-white rounded-lg shadow p-6 flex items-center justify-between">
                        {{-- Kiri: judul + deskripsi + tanggal --}}
                        <div class="flex-1 pr-4">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1">
                                {{ $form->title }}
                            </h2>
                            <p class="text-sm text-gray-600 mb-2">
                                {{ \Illuminate\Support\Str::limit($form->description, 100, '...') }}
                            </p>
                            <span class="text-xs text-gray-500">
                                {{ $form->created_at->format('d M Y') }}
                            </span>
                        </div>

                        {{-- Kanan: tombol Detail + dropdown Status --}}
                        <div class="flex items-center space-x-4">
                            {{-- Dropdown Status --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" type="button"
                                    class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold transition-colors focus:outline-none"
                                    :class="{
                                        'bg-green-100 text-green-800': {{ $form->is_active ? 'true' : 'false' }},
                                        'bg-red-100 text-red-800': !{{ $form->is_active ? 'true' : 'false' }}
                                    }">
                                    <span>{{ $form->is_active ? 'Aktif' : 'Nonaktif' }}</span>
                                    <!-- Chevron -->
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="w-4 h-4 ml-1 transition-transform duration-200"
                                        :class="open ? 'rotate-180' : ''" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.584l3.71-4.354a.75.75 0
                                 111.14.976l-4 4.7a.75.75 0 01-1.14 0l-4-4.7a.75.75 0
                                 01.02-1.06z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                                <div x-show="open" @click.away="open = false" x-transition
                                    class="absolute right-0 mt-2 w-36 bg-white border rounded-lg shadow-lg z-20 overflow-hidden">
                                    <form method="POST" action="{{ route('admin.forms.toggle', $form) }}">
                                        @csrf @method('PATCH')
                                        <button type="submit" name="is_active" value="1"
                                            class="w-full text-left px-4 py-2 text-xs font-medium hover:bg-gray-100"
                                            :class="{ 'bg-green-50 text-green-800': {{ $form->is_active ? 'true' : 'false' }} }">
                                            Aktif
                                        </button>
                                        <button type="submit" name="is_active" value="0"
                                            class="w-full text-left px-4 py-2 text-xs font-medium hover:bg-gray-100"
                                            :class="{ 'bg-red-50 text-red-800': !{{ $form->is_active ? 'true' : 'false' }} }">
                                            Nonaktif
                                        </button>
                                    </form>
                                </div>
                            </div>
                            {{-- Detail --}}
                            <a href="{{ route('admin.forms.show', $form) }}"
                                class="inline-flex items-center text-primary hover:text-primary-dark">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-1" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.625 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zM12.375 12a.375.375 0 11-.75 0 .375.375 0 01.75 0zM16.125 12a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                </svg>
                                <span class="font-medium text-sm">Detail</span>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-6">
                {{ $forms->links() }}
            </div>
        @endif
    </div>
@endsection
