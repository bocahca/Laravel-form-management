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


    #[On('openReviewModal')]
    public function openModal($submissionId): void
    {
        // Ambil data submission beserta relasi yang dibutuhkan
        $this->submission = Submission::with(['form', 'user'])->findOrFail($submissionId);

        // Isi textarea dengan catatan yang sudah ada (jika ada)
        $this->review_note = $this->submission->review_note ?? '';

        $this->showModal = true;
    }

    public function processReview(string $newStatus): void
    {
        if (!in_array($newStatus, ['approved', 'rejected']) || !$this->submission) {
            return;
        }

        $this->submission->update([
            'status' => $newStatus,
            'review_note' => $this->review_note,
            'reviewed_by' => Auth::id(),  
            'approved_at' => $newStatus === 'approved' ? now() : null,
        ]);

        // Tutup modal
        $this->showModal = false;

        $this->dispatch('submissionUpdated');

        $this->reset('submission', 'review_note');
        $this->dispatch('submissionStatusChanged');
    }

     public function render()
    {
        return view('livewire.admin.submission-review-modal');
    }
}
