{{-- resources/views/admin/forms/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Form')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow space-y-6">
        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('admin.forms.show', $form) }}" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- Form Edit --}}
        <form action="{{ route('admin.forms.update', $form) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')

            {{-- Judul --}}
            <div>
                <label for="title" class="block mb-1 font-medium">Judul</label>
                <input id="title" type="text" name="title" value="{{ old('title', $form->title) }}"
                    placeholder="Masukkan judul form…"
                    class="w-full border rounded p-2 @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Deskripsi --}}
            <div>
                <label for="description" class="block mb-1 font-medium">Deskripsi</label>
                <textarea id="description" name="description" rows="4" placeholder="Masukkan deskripsi…"
                    class="w-full border rounded p-2 @error('description') border-red-500 @enderror">{{ old('description', $form->description) }}</textarea>
                @error('description')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Status Form (select 1/0) --}}
            <div>
                <label for="is_active" class="block mb-1 font-medium">Status Form</label>
                <select id="is_active" name="is_active"
                    class="w-full border rounded p-2 text-gray-700 focus:ring-primary focus:border-primary">
                    <option value="1" {{ old('is_active', $form->is_active) ? 'selected' : '' }}>
                        Aktif
                    </option>
                    <option value="0" {{ !old('is_active', $form->is_active) ? 'selected' : '' }}>
                        Nonaktif
                    </option>
                </select>
            </div>

            {{-- Aksi Simpan & Reset --}}
            <div class="flex items-center mt-6">
                {{-- Simpan --}}
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                    Simpan Perubahan
                </button>

                {{-- Reset --}}
                <button type="reset" class="ml-auto text-gray-700 hover:underline">
                    Reset
                </button>
            </div>
        </form>
    </div>
@endsection
