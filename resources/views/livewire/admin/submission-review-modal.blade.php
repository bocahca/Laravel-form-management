<div>
    @if ($showModal && $submission)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40">
            <div class="bg-white rounded-lg w-full max-w-2xl p-8 shadow-xl relative">
                <button wire:click="$set('showModal', false)"
                    class="absolute top-2 right-3 text-gray-500 hover:text-gray-700 text-2xl">
                    &times;
                </button>
                <h2 class="text-xl font-bold mb-3">Review Submission</h2>
                <div class="mb-3">
                    <table class="w-full text-sm">
                        <tr>
                            <td class="font-semibold pr-4 py-1">Form</td>
                            <td>{{ $submission->form->title }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold pr-4 py-1">User</td>
                            <td>{{ $submission->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold pr-4 py-1">Tanggal Submit</td>
                            <td>{{ $submission->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <td class="font-semibold pr-4 py-1">Status</td>
                            <td @if ($submission->status == 'pending') <span class="text-yellow-600 py-1">Pending</span>
                                @elseif($submission->status == 'approved')
                                    <span class="text-green-600 py-1 ">Approved</span>
                                @else
                                    <span class=" text-red-800 py-1 ">Rejected</span>
                                @endif
                                </td>
                        </tr>
                        <tr>
                            <td class="font-semibold pr-4 py-1">Catatan Review</td>
                            <td class="italic font-semibold">"{{ $submission->review_note ?: '-' }}"</td>
                        </tr>
                    </table>
                </div>
                <div class="mb-4">
                    <a href="{{ route('admin.submissions.show', $submission) }}"
                        class="inline-flex items-center px-3 py-1 rounded text-blue-700 hover:bg-blue-50 font-medium"
                        target="_blank">
                        Lihat Submission
                    </a>
                </div>
                @if ($submission->status == 'pending')
                    <form wire:submit.prevent="review">
                        <div class="mb-2">
                            <label class="block font-medium mb-1">Catatan Review</label>
                            <textarea wire:model.defer="review_note" rows="2" class="w-full border rounded p-2"></textarea>
                        </div>
                        <div class="flex gap-3 mt-3">
                            <button type="submit" wire:click="$set('status', 'approved')"
                                class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">Approve</button>
                            <button type="submit" wire:click="$set('status', 'rejected')"
                                class="bg-red-600 text-white px-4 py-1 rounded hover:bg-red-700">Reject</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif
</div>
