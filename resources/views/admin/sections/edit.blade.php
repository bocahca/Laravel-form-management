@extends('layouts.app')

@section('title', 'Edit Section')

@section('content')
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <a href="{{ route('admin.forms.show', $section->form) }}" class="inline-flex items-center text-gray-700 hover:text-gray-900 mb-4">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
        </svg>
        Kembali ke Form
    </a>

    <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Section</h2>

    <form action="{{ route('admin.forms.sections.update', [$section->form, $section]) }}" method="POST">
        @csrf
        @method('PUT')

        <label class="block mb-2 font-medium">Judul Section</label>
        <input type="text" name="title" value="{{ old('title', $section->title) }}"
            class="w-full border rounded p-2 @error('title') border-red-500 @enderror">
        @error('title')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        <label class="block mt-4 mb-2 font-medium">Deskripsi</label>
        <textarea name="description"
            class="w-full border rounded p-2 @error('description') border-red-500 @enderror"
            rows="4">{{ old('description', $section->description) }}</textarea>
        @error('description')
            <p class="text-red-600 text-sm">{{ $message }}</p>
        @enderror

        <div class="flex justify-end space-x-2 mt-6">
            <button type="reset" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                Reset
            </button>
            <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                Update Section
            </button>
        </div>
    </form>
</div>
@endsection
