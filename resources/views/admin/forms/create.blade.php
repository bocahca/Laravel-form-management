@extends('layouts.app')

@section('title','Buat Form Baru')

@section('content')
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('admin.forms.store') }}" method="POST">
      @csrf

      <label class="block mb-2 font-medium">Judul</label>
      <input type="text" name="title" placeholder="Masukkan judul form..."
             class="w-full border rounded p-2 @error('title') border-red-500 @enderror">
      @error('title')
        <p class="text-red-600 text-sm">{{ $message }}</p>
      @enderror

      <label class="block mt-4 mb-2 font-medium">Deskripsi</label>
      <textarea name="description"
                class="w-full border rounded p-2 @error('description') border-red-500 @enderror"
                rows="4"></textarea>
      @error('description')
        <p class="text-red-600 text-sm">{{ $message }}</p>
      @enderror
        <div class="mt-4 flex items-center">
            <input type="hidden" name="is_active" value="0">
        </div>
      <button type="submit"
              class="mt-6 bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
        Simpan
      </button>
    </form>
  </div>
@endsection
