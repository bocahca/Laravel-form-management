<?php

namespace App\Livewire\Admin;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class SubmissionReviewModal extends Component
{
    public bool $showModal = false;
    public ?Submission $submission = null;
    public string $review_note = '';

    /**
     * Listener untuk event 'openReviewModal'.
     * Mengambil data submission dan menampilkan modal.
     */
    #[On('openReviewModal')]
    public function openModal($submissionId): void
    {
        // Ambil data submission beserta relasi yang dibutuhkan
        $this->submission = Submission::with(['form', 'user'])->findOrFail($submissionId);

        // Isi textarea dengan catatan yang sudah ada (jika ada)
        $this->review_note = $this->submission->review_note ?? '';

        $this->showModal = true;
    }

    /**
     * Memproses review (Approve/Reject), mengupdate database,
     * dan memberitahu komponen lain bahwa proses selesai.
     */
    public function processReview(string $newStatus): void
    {
        // Validasi sederhana
        if (!in_array($newStatus, ['approved', 'rejected']) || !$this->submission) {
            return;
        }

        // Update data di database
        $this->submission->update([
            'status' => $newStatus,
            'review_note' => $this->review_note,
            'reviewed_by' => Auth::id(),
            // Penting: Hanya isi 'approved_at' jika statusnya 'approved'
            'approved_at' => $newStatus === 'approved' ? now() : null,
        ]);

        // Tutup modal
        $this->showModal = false;

        // 💡 KUNCI UTAMA: Pancarkan event untuk memberitahu komponen daftar agar refresh
        $this->dispatch('submissionUpdated');

        // Reset state internal modal untuk persiapan pembukaan berikutnya
        $this->reset('submission', 'review_note');
    }

    public function render()
    {
        return view('livewire.admin.submission-review-modal');
    }
}
