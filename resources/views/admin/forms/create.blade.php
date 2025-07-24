@extends('layouts.app')

@section('title', 'Buat Form Baru')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <div>
            <a href="{{ route('admin.forms.index') }}" class="inline-flex items-center text-gray-700 hover:text-gray-900">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        <form action="{{ route('admin.forms.store') }}" method="POST">
            @csrf

            <label class="block mb-2 font-medium">Judul</label>
            <input type="text" name="title" placeholder="Masukkan judul form..."
                class="w-full border rounded p-2 @error('title') border-red-500 @enderror">
            @error('title')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <label class="block mt-4 mb-2 font-medium">Deskripsi</label>
            <textarea name="description" class="w-full border rounded p-2 @error('description') border-red-500 @enderror"
                rows="4"></textarea>
            @error('description')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
            <div class="mt-4 flex items-center">
                <input type="hidden" name="is_active" value="0">
            </div>
            <button type="submit" class="mt-6 bg-primary text-white px-4 py-2 rounded hover:bg-primary/90" onclick="this.disabled=true; this.form.submit();">
                Simpan
            </button>
        </form>
    </div>
@endsection
