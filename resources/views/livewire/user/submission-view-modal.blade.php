<div>
    @if ($showModal && $submission)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg w-full max-w-2xl p-6 shadow-xl relative">
                {{-- Tombol Tutup --}}
                <button wire:click="closeModal"
                    class="absolute top-3 right-4 text-gray-400 hover:text-gray-700 text-2xl font-bold">
                    &times;
                </button>

                <h2 class="text-xl font-bold mb-4">View Submission</h2>

                <div class="border-t border-b py-4">
                    <table class="w-full text-sm">
                        <tbody>
                            <tr>
                                <td class="font-semibold pr-4 py-1 w-40">Form</td>
                                <td>: {{ $submission->form->title }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold pr-4 py-1">Tanggal Submit</td>
                                <td>: {{ $submission->created_at->format('d M Y, H:i') }}</td>
                            </tr>
                            <tr>
                                <td class="font-semibold pr-4 py-1">Status</td>
                                <td>:
                                    @if ($submission->status == 'pending')
                                        <span class="font-semibold text-yellow-600">Pending</span>
                                    @elseif($submission->status == 'approved')
                                        <span class="font-semibold text-green-600">Approved</span>
                                    @else
                                        <span class="font-semibold text-red-800">Rejected</span>
                                    @endif
                                </td>
                            </tr>
                            @if ($submission->approved_at)
                                <tr>
                                    <td class="font-semibold pr-4 py-1">Direview pada</td>
                                    <td>: {{ $submission->approved_at->format('d M Y, H:i') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td class="font-semibold pr-4 py-1 align-top">Catatan Review</td>
                                <td class="align-top">: <span
                                        class="italic">"{{ $submission->review_note ?: '-' }}"</span></td>
                            </tr>
                            <tr>
                                <td class="font-semibold pr-4 py-1">Cetak PDF</td>
                                <td>:
                                    <a href="{{ route('user.submissions.pdf', $submission->id) }}" target="_blank"
                                        class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 hover:underline">
                                        Lihat & Cetak PDF
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="2" stroke="currentColor" class="size-4 ml-1">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 6H5.25A2.25 2.25 0 0 0 3 8.25v10.5A2.25 2.25 0 0 0 5.25 21h10.5A2.25 2.25 0 0 0 18 18.75V10.5m-4.5 4.5V11.25m0 0-3.75 3.75M13.5 11.25l3.75 3.75" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif
</div>
