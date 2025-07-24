{{-- resources/views/admin/questions/edit.blade.php --}}
@extends('layouts.app')

@section('title', 'Edit Pertanyaan')

@section('content')
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <a href="{{ route('admin.forms.show', $section->form) }}"
            class="inline-flex items-center text-gray-700 hover:text-gray-900 mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali ke Form
        </a>

        <h2 class="text-xl font-semibold mb-4 text-gray-800">Edit Pertanyaan</h2>

        <form action="{{ route('admin.sections.questions.update', [$section, $question]) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="block mb-2 font-medium">Pertanyaan</label>
            <input type="text" name="question_text" value="{{ old('question_text', $question->question_text) }}"
                class="w-full border rounded p-2 @error('question_text') border-red-500 @enderror">
            @error('question_text')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            <label class="block mt-4 mb-2 font-medium">Tipe Jawaban</label>
            <select name="type" class="w-full border rounded p-2 @error('type') border-red-500 @enderror">
                <option value="">-- Pilih Tipe --</option>
                <option value="text" {{ old('type', $question->type) == 'text' ? 'selected' : '' }}>Text</option>
                <option value="checkbox" {{ old('type', $question->type) == 'checkbox' ? 'selected' : '' }}>Checkbox
                </option>
                <option value="radio" {{ old('type', $question->type) == 'radio' ? 'selected' : '' }}>Radio</option>
            </select>
            @error('type')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror

            {{-- Option input (dynamic, bisa pakai JS, tapi cukup manual dulu) --}}
            <div class="mt-4" id="options-container">
                <label class="block mb-2 font-medium">Opsi (hanya untuk tipe checkbox/radio)</label>
                <textarea name="options" class="w-full border rounded p-2 @error('options') border-red-500 @enderror" rows="3"
                    placeholder="Pisahkan dengan koma, contoh: Pilihan 1, Pilihan 2">{{ old('options', $question->options ? implode(', ', $question->options) : '') }}</textarea>
                @error('options')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end space-x-2 mt-6">
                <button type="reset" class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300">
                    Reset
                </button>
                <button type="submit" class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
                    Update Pertanyaan
                </button>
            </div>
        </form>
    </div>
@endsection
