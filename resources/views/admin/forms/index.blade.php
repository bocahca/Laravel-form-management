@extends('layouts.app')

@section('title', 'Daftar Form')

@section('content')
  <div class="flex items-center justify-between mb-6">
    <h1 class="text-2xl font-semibold text-gray-800">Daftar Form</h1>
    <a href="{{ route('admin.forms.create') }}"
       class="bg-primary text-white px-4 py-2 rounded hover:bg-primary/90">
      + Buat Form Baru
    </a>
  </div>

  @if($forms->isEmpty())
    <div class="bg-white p-6 rounded shadow text-gray-500">
      Belum ada form.
    </div>
  @else
    <div class="overflow-x-auto bg-white rounded shadow">
      <table class="min-w-full divide-y">
        <thead class="bg-primary">
          <tr>
            <th class="px-4 py-2 text-left text-white">#</th>
            <th class="px-4 py-2 text-left text-white">Judul</th>
            <th class="px-4 py-2 text-left text-white">Status</th>
            <th class="px-4 py-2 text-left text-white">Dibuat</th>
            <th class="px-4 py-2 text-center text-white">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @foreach($forms as $form)
            <tr>
              <td class="px-4 py-2">{{ $forms->firstItem() + $loop->index }}</td>
              <td class="px-4 py-2">{{ $form->title }}</td>
              <td class="px-4 py-2">
                @if($form->is_active)
                  <span class="text-xs font-semibold text-green-800 bg-green-100 px-2 py-1 rounded">
                    Aktif
                  </span>
                @else
                  <span class="text-xs font-semibold text-red-800 bg-red-100 px-2 py-1 rounded">
                    Nonaktif
                  </span>
                @endif
              </td>
              <td class="px-4 py-2 text-sm text-gray-600">
                {{ $form->created_at->format('d M Y') }}
              </td>
              <td class="px-4 py-2">
                <div class="flex justify-center space-x-2">
                  <a href="{{ route('admin.forms.edit', $form) }}"
                     class="text-sm text-primary hover:underline">Edit</a>
                  <form action="{{ route('admin.forms.destroy', $form) }}"
                        method="POST"
                        onsubmit="return confirm('Yakin ingin hapus form ini?');">
                    @csrf @method('DELETE')
                    <button type="submit"
                            class="text-sm text-red-600 hover:underline">
                      Hapus
                    </button>
                  </form>
                </div>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
      {{ $forms->links() }}
    </div>
  @endif
@endsection
