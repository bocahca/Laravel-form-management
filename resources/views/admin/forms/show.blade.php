{{-- resources/views/admin/forms/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Form')

@section('content')
    <div class="p-8">
        <div class="max-w-4xl mx-auto">

            {{-- CARD UTAMA --}}
            <div class="bg-white p-6 sm:p-8 rounded-lg shadow-sm">

                {{-- BAGIAN HEADER FORM --}}
                <div class="flex justify-between items-start">
                    {{-- Kiri: Judul, Deskripsi, Meta --}}
                    <div>
                        <div class="flex items-center gap-x-3 mb-2">
                            <h1 class="text-3xl font-bold text-gray-800">{{ $form->title }}</h1>
                            {{-- Tombol Edit Form --}}
                            <a href="{{ route('admin.forms.edit', $form) }}"
                                class="p-1.5 bg-yellow-100 text-yellow-600 rounded-full hover:bg-yellow-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            {{-- Tombol Hapus Form --}}
                            <form action="{{ route('admin.forms.destroy', $form) }}" method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus form ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-1.5 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                        <p class="text-gray-600 mb-4">{{ $form->description }}</p>

                        <div class="flex flex-wrap items-center gap-x-4 gap-y-2 text-sm">
                            {{-- Status Pill --}}
                            @if ($form->is_active)
                                <span class="inline-block bg-green-100 text-green-800 px-3 py-1 rounded-full font-medium">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-block bg-red-200 text-red-800 px-3 py-1 rounded-full font-medium">
                                    Nonaktif
                                </span>
                            @endif
                            {{-- Metadata --}}
                            <span class="text-gray-500">Dibuat: {{ $form->created_at->format('d M Y') }}</span>
                            @if ($form->updated_at->gt($form->created_at))
                                <span class="text-gray-500">Diubah: {{ $form->updated_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Kanan: Tombol Aksi Utama --}}
                    <div class="flex flex-col items-end gap-y-3 flex-shrink-0 ml-6">
                        <a href="{{ route('admin.forms.index') }}"
                            class="px-4 py-2 inline-flex items-center
                            text-gray-700 hover:text-gray-900">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                            Kembali
                        </a>
                        <a href="{{ route('admin.forms.sections.create', $form) }}"
                            class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-semibold rounded-md hover:bg-indigo-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Tambah Section
                        </a>
                    </div>
                </div>

                {{-- sections list --}}
                <div class="mt-8 pt-8 border-t border-gray-400">
                    <div class="space-y-6">
                        @forelse ($form->sections as $section)
                            <div class="rounded-lg">
                                {{-- Header Section --}}
                                <div class="bg-primary p-4 rounded-t-lg flex justify-between items-start gap-4">
                                    <div>
                                        <div class="flex items-center gap-x-2">
                                            <h2 class="text-l font-bold text-neutral-50">{{ $section->title }}</h2>
                                            <div class="flex items-center gap-x-1.5">
                                                {{-- Tombol Naik Posisi --}}
                                                @if (!$loop->first)
                                                    <form
                                                        action="{{ route('admin.forms.sections.moveUp', [$form, $section]) }}"
                                                        method="POST" class="inline-flex">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" title="Naikkan Posisi"
                                                            class="p-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                                                class="w-3.5 h-3.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M4.5 15.75l7.5-7.5 7.5 7.5" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Tombol Turun Posisi --}}
                                                @if (!$loop->last)
                                                    <form
                                                        action="{{ route('admin.forms.sections.moveDown', [$form, $section]) }}"
                                                        method="POST" class="inline-flex">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" title="Turunkan Posisi"
                                                            class="p-1.5 bg-gray-100 text-gray-600 rounded-full hover:bg-gray-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="3" stroke="currentColor"
                                                                class="w-3.5 h-3.5">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                @endif

                                                {{-- Spacer --}}
                                                @if (!$loop->first || !$loop->last)
                                                    <div class="w-px h-5 bg-primary-dark"></div>
                                                @endif
                                                {{-- Edit Section --}}
                                                <a href="{{ route('admin.forms.sections.edit', [$form, $section]) }}"
                                                    class="p-1.5 bg-yellow-100 text-yellow-600 rounded-full hover:bg-yellow-200">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                        class="w-4 h-4">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                    </svg>
                                                </a>
                                                {{-- Delete Section --}}
                                                <form
                                                    action="{{ route('admin.forms.sections.destroy', [$form, $section]) }}"
                                                    method="POST" onsubmit="return confirm('Hapus section ini?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                        class="p-1.5 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                        </svg>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                        <p class="text-neutral-200 mt-1 text-sm">{{ $section->description }}</p>
                                    </div>
                                    {{-- Tambah Pertanyaan --}}
                                    <a href="{{ route('admin.sections.questions.create', $section) }}"
                                        {{-- TODO: Ganti dengan route create question --}}
                                        class="flex-shrink-0 inline-flex items-center px-3 py-2 bg-green-600 text-white text-xs font-bold rounded-md hover:bg-gray-50 border border-gray-300 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                        Tambah Pertanyaan
                                    </a>
                                </div>

                                {{-- Body Section (Putih) - Daftar Pertanyaan --}}
                                <div class="bg-white px-6 py-4 rounded-b-lg border-x border-b border-gray-200">
                                    <div class="space-y-6">
                                        @forelse ($section->questions()->orderBy('position')->get() as $question)
                                            {{-- Wrapper untuk setiap baris pertanyaan --}}
                                            <div class="flex items-start justify-between gap-x-4 py-2">

                                                {{-- Kiri: Nomor, Teks Pertanyaan, dan Preview Input --}}
                                                <div class="flex-1">
                                                    <div class="flex items-center mb-3">
                                                        <span
                                                            class="font-semibold text-gray-800 mr-2">{{ $loop->iteration }}.</span>
                                                        <p class="font-semibold text-gray-800">
                                                            {{ $question->question_text }}</p>
                                                    </div>

                                                    {{-- Tipe input preview --}}
                                                    <div class="ml-6 text-sm">
                                                        @php
                                                            $commonClasses =
                                                                'w-full max-w-sm border-gray-300 rounded-md bg-gray-50 text-sm shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50';
                                                            $optionClasses =
                                                                'form-radio text-primary border-gray-400 bg-gray-100 focus:ring-primary/50';
                                                            $checkboxClasses =
                                                                'form-checkbox text-primary border-gray-400 bg-gray-100 rounded focus:ring-primary/50';
                                                        @endphp

                                                        @if ($question->type === 'text')
                                                            <input type="text" class="{{ $commonClasses }}">
                                                        @elseif ($question->type === 'textarea')
                                                            <textarea rows="3" class="{{ $commonClasses }}"></textarea>
                                                        @elseif ($question->type === 'dropdown')
                                                            <select class="{{ $commonClasses }}">
                                                                <option>Pilih salah satu...</option>
                                                                @foreach ($question->options ?? [] as $opt)
                                                                    <option>{{ $opt->option_text }}</option>
                                                                @endforeach
                                                            </select>
                                                        @elseif ($question->type === 'radio')
                                                            <div class="flex items-center gap-x-6">
                                                                @foreach ($question->options ?? [] as $opt)
                                                                    <label class="inline-flex items-center text-gray-700">
                                                                        <input type="radio"
                                                                            name="radio-preview-{{ $question->id }}"
                                                                            class="{{ $optionClasses }}">
                                                                        <span
                                                                            class="ml-2">{{ $opt->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @elseif($question->type === 'checkbox')
                                                            <div class="flex items-center gap-x-6">
                                                                @foreach ($question->options ?? [] as $opt)
                                                                    <label class="inline-flex items-center text-gray-700">
                                                                        <input type="checkbox"
                                                                            class="{{ $checkboxClasses }}">
                                                                        <span
                                                                            class="ml-2">{{ $opt->option_text }}</span>
                                                                    </label>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>

                                                {{-- Kanan: Tombol Aksi Pertanyaan (Urutan, Edit, Hapus) --}}
                                                <div class="flex items-center space-x-2 flex-shrink-0">
                                                    {{-- Tombol Naik Posisi --}}
                                                    @if (!$loop->first)
                                                        <form
                                                            action="{{ route('admin.sections.questions.moveUp', [$section, $question]) }}"
                                                            method="POST" class="inline-flex">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" title="Naikkan Posisi"
                                                                class="p-1.5 bg-gray-100 text-gray-500 rounded-full hover:bg-gray-200">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M5 15l7-7 7 7" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    {{-- Tombol Turun Posisi --}}
                                                    @if (!$loop->last)
                                                        <form
                                                            action="{{ route('admin.sections.questions.moveDown', [$section, $question]) }}"
                                                            method="POST" class="inline-flex">
                                                            @csrf
                                                            @method('PATCH')
                                                            <button type="submit" title="Turunkan Posisi"
                                                                class="p-1.5 bg-gray-100 text-gray-500 rounded-full hover:bg-gray-200">
                                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                    fill="none" viewBox="0 0 24 24"
                                                                    stroke="currentColor" stroke-width="2.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="M19 9l-7 7-7-7" />
                                                                </svg>
                                                            </button>
                                                        </form>
                                                    @endif
                                                    {{-- Tombol Edit Pertanyaan --}}
                                                    <a href="{{ route('admin.sections.questions.edit', [$section, $question]) }}"
                                                        class="p-1.5 bg-yellow-100 text-yellow-600 rounded-full hover:bg-yellow-200">
                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                                        </svg>
                                                    </a>
                                                    {{-- Tombol Hapus Pertanyaan --}}
                                                    <form
                                                        action="{{ route('admin.sections.questions.destroy', [$section, $question]) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Hapus pertanyaan ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="p-1.5 bg-red-100 text-red-600 rounded-full hover:bg-red-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        @empty
                                            <p class="text-center text-gray-500 italic py-4">Belum ada pertanyaan di
                                                section ini.</p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <p class="text-gray-500 italic">Belum ada section yang dibuat untuk form ini.</p>
                            </div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
@endsection
