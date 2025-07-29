<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Submission;

class SubmissionReviewModal extends Component
{
    public $showModal = false;
    public $submission = null;
    public $review_note = '';
    public $status = '';

    protected $listeners = ['showSubmissionReviewModal' => 'show'];

    public function show($submissionId)
    {
        $this->submission = Submission::with(['form', 'user'])->findOrFail($submissionId);
        $this->review_note = $this->submission->review_note ?? '';
        $this->status = $this->submission->status ?? '';
        $this->showModal = true;
    }

    public function review()
    {
        $this->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $this->submission->update([
            'status' => $this->status,
            'review_note' => $this->review_note,
        ]);

        session()->flash('success', 'Status submission berhasil diupdate.');
        $this->showModal = false;
        $this->dispatch('submissionReviewed');
    }

    public function render()
    {
        return view('livewire.admin.submission-review-modal');
    }
}
