<?php

namespace App\Livewire\User;

use App\Models\Submission;
use Livewire\Component;
use Livewire\Attributes\On;

class SubmissionViewModal extends Component
{
    public bool $showModal = false;
    public ?Submission $submission = null;

    #[On('openViewModal')]
    public function openModal($submissionId)
    {
        $this->submission = Submission::with(['form', 'user'])
            ->findOrFail($submissionId);

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->reset('submission');
    }

    public function render()
    {
        return view('livewire.user.submission-view-modal');
    }
}
