@extends('layouts.app')

@section('title','Dashboard')

@section('content')
  {{-- Statistik submission --}}
  <div class="grid grid-cols-3 gap-6 mb-8">
    <div class="bg-white p-4 rounded shadow font-medium">
      <div class="text-sm text-gray-500">Pending</div>
      <div class="mt-2 text-3xl font-semibold text-secondary">{{ $pending }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow font-medium">
      <div class="text-sm text-gray-500">Approved</div>
      <div class="mt-2 text-3xl font-semibold text-green-600">{{ $approved }}</div>
    </div>
    <div class="bg-white p-4 rounded shadow font-medium">
      <div class="text-sm text-gray-500">Rejected</div>
      <div class="mt-2 text-3xl font-semibold text-red-600">{{ $rejected }}</div>
    </div>
  </div>

  {{-- Recent Submissions --}}
  <div class="bg-white rounded shadow p-6">
    <h2 class="text-lg font-medium text-gray-700 mb-4">Recent Submissions</h2>

    @if($recent->isEmpty())
      <p class="text-gray-500">Belum ada submission.</p>
    @else
      <ul class="divide-y">
        @foreach($recent as $sub)
          <li class="py-3 flex justify-between items-center">
            <div>
              <div class="font-medium text-gray-800">
                {{ $sub->form->title ?? '–' }}
              </div>
              <div class="text-sm text-gray-500">
                {{ $sub->created_at->format('d M Y H:i') }}
              </div>
            </div>
            <span class="px-2 py-1 rounded text-xs
                         {{ $sub->status==='approved' ? 'bg-green-100 text-green-800' :
                            ($sub->status==='rejected' ? 'bg-red-100 text-red-800' :
                              'bg-yellow-100 text-yellow-800') }}">
              {{ ucfirst($sub->status) }}
            </span>
          </li>
        @endforeach
      </ul>
    @endif
  </div>
@endsection
