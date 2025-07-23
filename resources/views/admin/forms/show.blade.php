{{-- resources/views/admin/forms/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Detail Form')

@section('content')
    <div class="bg-gray-100 min-h-screen py-8">
        <div class="max-w-4xl mx-auto space-y-6">

            {{-- HEADER FORM --}}
            <div class="bg-white shadow rounded-lg overflow-hidden">
                {{-- HEADER FORM --}}
                <div class="bg-primary-dark px-6 py-4 flex items-start justify-between">
                    {{-- Judul & Deskripsi --}}
                    <div>
                        <h1 class="text-2xl font-semibold text-neutral-50">{{ $form->title }}</h1>
                        <p class="text-neutral-200 mt-1">{{ $form->description }}</p>

                        <div class="mt-3 flex flex-wrap items-center space-x-4 text-sm">
                            {{-- Status Pill --}}
                            @if ($form->is_active)
                                <span class="inline-block bg-green-300 text-green-900 px-3 py-1 rounded-full">
                                    Aktif
                                </span>
                            @else
                                <span class="inline-block bg-red-300 text-red-900 px-3 py-1 rounded-full">
                                    Tidak Aktif
                                </span>
                            @endif

                            {{-- Metadata --}}
                            <span class="text-neutral-300">Dibuat: {{ $form->created_at->format('d M Y') }}</span>
                            @if ($form->updated_at->gt($form->created_at))
                                <span class="text-neutral-300">Diubah: {{ $form->updated_at->format('d M Y') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Tombol aksi: Edit / Hapus --}}
                    <div class="flex items-center space-x-3 py-7">
                        <a href="{{ route('admin.forms.edit', $form) }}"
                            class="p-2 bg-yellow-200 text-yellow-800 rounded-full hover:bg-yellow-300">
                            {{-- Icon Pensil --}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                            </svg>

                            </svg>
                        </a>

                        <form action="{{ route('admin.forms.destroy', $form) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus form ini?');">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-200 text-red-800 rounded-full hover:bg-red-300">
                                {{-- Icon Tong Sampah --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>

                            </button>
                        </form>
                    </div>
                </div>

                {{-- Kembali & Tambah Section --}}
                <div class="px-6 py-4 border-t flex justify-between bg-white">
                    <a href="{{ route('admin.forms.index') }}"
                        class="px-4 py-2 inline-flex items-center text-gray-700 hover:text-gray-900">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                        </svg>
                        Kembali
                    </a>
                    <a href="#" class="flex items-center px-4 py-2 bg-primary text-white rounded hover:bg-primary/90">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                        Tambah Section
                    </a>
                </div>
            </div>


            {{-- SECTIONS --}}
            @foreach ($form->sections as $section)
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    {{-- Header Section --}}
                    <div class="bg-primary px-6 py-4 flex items-start justify-between">
                        <div>
                            <h2 class="text-xl font-semibold text-white">{{ $section->title }}</h2>
                            <p class="text-blue-100 mt-1">{{ $section->description }}</p>
                        </div>
                        <div class="flex items-center space-x-2">
                            {{-- Edit Section --}}
                            <a href="#" class="p-2 bg-yellow-200 text-yellow-800 rounded-full hover:bg-yellow-300">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                </svg>

                            </a>
                            {{-- Delete Section --}}
                            <form action="#" method="POST" onsubmit="return confirm('Hapus section ini?');">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-200 text-red-800 rounded-full hover:bg-red-300">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                    </svg>

                                </button>
                            </form>
                            {{-- Tambah Pertanyaan --}}
                            <a href="{{ route('admin.questions.create', ['section' => $section]) }}"
                                class="flex items-center px-3 py-1 bg-gray-100 text-gray-800 rounded hover:bg-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                Tambah Pertanyaan
                            </a>
                        </div>
                    </div>

                    {{-- Daftar Pertanyaan --}}
                    <div class="px-6 py-4 space-y-4">
                        @foreach ($section->questions as $question)
                            <div class="flex items-center justify-between">
                                <div class="flex-1">
                                    <p class="font-medium text-gray-800">{{ $question->text }}</p>
                                    {{-- Tipe input preview --}}
                                    @if ($question->type === 'text')
                                        <input type="text" disabled class="mt-1 w-1/2 border-gray-300 rounded" />
                                    @elseif($question->type === 'checkbox')
                                        <div class="mt-1 space-x-2">
                                            @foreach ($question->options as $opt)
                                                <label class="inline-flex items-center">
                                                    <input type="checkbox" disabled class="form-checkbox" />
                                                    <span class="ml-1 text-gray-700">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @elseif($question->type === 'radio')
                                        <div class="mt-1 space-x-4">
                                            @foreach ($question->options as $opt)
                                                <label class="inline-flex items-center">
                                                    <input type="radio" disabled class="form-radio" />
                                                    <span class="ml-1 text-gray-700">{{ $opt }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                                {{-- Edit/Delete Question --}}
                                <div class="flex items-center space-x-2">
                                    <a href="{{ route('admin.questions.edit', $question) }}"
                                        class="p-2 bg-yellow-200 text-yellow-800 rounded-full hover:bg-yellow-300">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L6.832 19.82a4.5 4.5 0 0 1-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 0 1 1.13-1.897L16.863 4.487Zm0 0L19.5 7.125" />
                                        </svg>

                                    </a>
                                    <form action="{{ route('admin.questions.destroy', $question) }}" method="POST"
                                        onsubmit="return confirm('Hapus pertanyaan ini?');">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                            class="p-2 bg-red-200 text-red-800 rounded-full hover:bg-red-300">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                            </svg>

                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach

                        @if ($section->questions->isEmpty())
                            <p class="text-gray-500 italic">Belum ada pertanyaan.</p>
                        @endif
                    </div>
                </div>
            @endforeach

            @if ($form->sections->isEmpty())
                <p class="text-center text-gray-500 italic">Belum ada section yang dibuat.</p>
            @endif

        </div>
    </div>
@endsection
