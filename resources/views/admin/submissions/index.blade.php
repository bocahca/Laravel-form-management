@extends('layouts.app')

@section('title', 'Review Submissions')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl font-semibold mb-6 text-gray-800">Review Submissions</h1>

        {{-- Filter/Search --}}
        <form action="{{ route('admin.submissions.index') }}" method="GET" class="mb-4 flex flex-wrap gap-2 pb-6">
            <select name="status" class="border rounded px-5">
                <option value="">Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
            </select>
            <input name="q" value="{{ request('q') }}" placeholder="Cari form/user..."
                class="px-3 py-1 border rounded">

            <button type="submit"
                class="flex items-center bg-gray-200 text-gray-700 px-3 py-1 hover:bg-gray-300 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>

                <span class="ml-1 text-sm">Cari</span>
            </button>
        </form>

        <div class="bg-white rounded shadow">
            <table class="min-w-full">
                <thead>
                    <tr class="bg-primary text-left text-sm text-neutral-100">
                        <th class="px-4 py-2">Form</th>
                        <th class="px-4 py-2">User</th>
                        <th class="px-4 py-2">Waktu Submit</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($submissions as $submission)
                        <tr class="border-b text-sm">
                            <td class="px-4 py-2">{{ $submission->form->title ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $submission->user->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $submission->created_at->format('d M Y H:i') }}</td>
                            <td class="px-4 py-2 text-start">
                                @if ($submission->status == 'pending')
                                    <span class="text-yellow-600 py-1">Pending</span>
                                @elseif($submission->status == 'approved')
                                    <span class="text-green-600 py-1 ">Approved</span>
                                @else
                                    <span class=" text-red-800 py-1 ">Rejected</span>
                                @endif
                            </td>
                            <td class="px-4 py-2">
                                <button type="button"
                                    onclick="Livewire.dispatch('showSubmissionReviewModal', { submissionId: {{ $submission->id }} })"
                                    class="p-1 text-indigo-600 hover:text-indigo-200" title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500">Tidak ada submission ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <livewire:admin.submission-review-modal />
        </div>
        <div class="mt-4">
            {{ $submissions->withQueryString()->links() }}
        </div>
    </div>
@endsection
