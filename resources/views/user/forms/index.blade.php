@extends('layouts.app')

@section('title', 'Daftar Formulir')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <h1 class="text-2xl font-semibold text-gray-800">Daftar Formulir</h1>
        </div>

        <form action="{{ route('user.forms.index') }}" method="GET" class="flex items-center space-x-2 mb-8">
            <div class="flex items-center border border-gray-300 rounded overflow-hidden">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul form…"
                    class="w-64 px-3 py-1 focus:outline-none focus:ring-1 focus:ring-primary focus:border-primary" />
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

            {{-- Tombol tampilkan semua jika sedang mencari --}}
            @if (request('q'))
                <a href="{{ route('user.forms.index') }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-600 rounded hover:bg-gray-200 text-sm font-medium border border-gray-300">
                    Tampilkan Semua
                </a>
            @endif
        </form>

        @if ($forms->isEmpty())
            <div class="bg-white p-6 rounded shadow text-gray-500 text-center">
                Tidak ada formulir yang tersedia.
            </div>
        @else
            <div class="space-y-4">
                @foreach ($forms as $form)
                    <div
                        class="bg-white rounded-lg shadow p-6 flex flex-col md:flex-row md:items-center md:justify-between">
                        {{-- Kiri: judul, deskripsi, tanggal --}}
                        <div class="flex-1 pr-4">
                            <h2 class="text-lg font-semibold text-gray-800 mb-1">
                                {{ $form->title }}
                            </h2>
                            <p class="text-sm text-gray-600 mb-2">
                                {{ \Illuminate\Support\Str::limit($form->description, 100, '...') }}
                            </p>
                            <div class="flex items-center space-x-3">
                                <span class="text-xs text-gray-500">
                                    {{ $form->created_at->format('d M Y') }}
                                </span>
                            </div>
                        </div>
                        {{-- Kanan: tombol isi --}}
                        <div class="mt-4 md:mt-0 flex items-center gap-4">
                            <div class="mt-4 md:mt-0 flex items-center gap-4">
                                <a href="{{ route('user.forms.fill', $form) }}"
                                    class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90 font-medium">
                                    Isi Form
                                </a>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-6">
                {{ $forms->links() }}
            </div>
        @endif
    </div>
@endsection
