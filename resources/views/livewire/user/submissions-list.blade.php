<div>
    <h1 class="text-2xl font-semibold mb-6 text-gray-800">My Submissions</h1>

    {{-- Filter/Search --}}
    <div class="mb-4 flex flex-wrap gap-2 pb-6">
        <select wire:model.live="status" class="border rounded px-5">
            <option value="">Status</option>
            <option value="pending">Pending</option>
            <option value="approved">Approved</option>
            <option value="rejected">Rejected</option>
        </select>
        <input wire:model.live.debounce.300ms="search" placeholder="Cari form..." class="px-3 py-1 border rounded">
    </div>

    <div class="bg-white rounded shadow">
        <table class="min-w-full">
            <thead>
                <tr class="bg-primary text-left text-sm text-neutral-100">
                    <th class="px-4 py-2">Form</th>
                    <th class="px-4 py-2">Waktu Submit</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($submissions as $submission)
                    <tr class="border-b text-sm">
                        <td class="px-4 py-2">{{ $submission->form->title ?? '-' }}</td>
                        <td class="px-4 py-2">{{ $submission->created_at->format('d M Y H:i') }}</td>
                        <td class="px-4 py-2">
                            @if ($submission->status == 'pending')
                                <span class="px-2 py-1 rounded text-xs bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($submission->status == 'approved')
                                <span class="px-2 py-1 rounded text-xs bg-green-100 text-green-800">Approved</span>
                            @else
                                <span class="px-2 py-1 rounded text-xs bg-red-100 text-red-800">Rejected</span>
                            @endif
                        </td>
                        <td class="px-4 py-2">
                            <button type="button"
                                wire:click="$dispatch('openViewModal', { submissionId: {{ $submission->id }}})"
                                class="p-1.5 bg-blue-100 text-blue-600 rounded-full hover:bg-blue-200">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m5.231 13.481L15 17.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v16.5c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Zm3.75 11.625a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                            Tidak ada submission ditemukan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
        <livewire:user.submission-view-modal />
    </div>

    <div class="mt-4">
        {{ $submissions->withQueryString()->links() }}
    </div>
</div>
