<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Submission;
use Illuminate\Support\Facades\Auth;

class SubmissionReviewModal extends Component
{
    public $showModal = false;
    public $submission = null;
    public $review_note = '';
    public $approved_by = '';
    public $approved_at = null;
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
            'approved_by' => Auth::user()->id, // atau ->id jika menyimpan ID
            'approved_at' => now(),
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
