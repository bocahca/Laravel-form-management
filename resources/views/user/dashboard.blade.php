@extends('layouts.app')

@section('title', 'Dashboard')

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

        @if ($recent->isEmpty())
            <p class="text-gray-500">Belum ada submission.</p>
        @else
            <ul class="divide-y">
                @foreach ($recent as $sub)
                    <li class="py-3 flex justify-between items-center">
                        <div>
                            <div class="font-medium text-gray-800">
                                {{ $sub->form->title ?? '–' }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $sub->created_at->format('d M Y H:i') }}
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <span
                                class="px-2 py-1 rounded text-xs
                    {{ $sub->status === 'approved'
                        ? 'bg-green-100 text-green-800'
                        : ($sub->status === 'rejected'
                            ? 'bg-red-100 text-red-800'
                            : 'bg-yellow-100 text-yellow-800') }}">
                                {{ ucfirst($sub->status) }}
                            </span>
                            <a href="{{ route('user.submissions.show', $sub) }}"
                                class="p-1.5 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </a>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
