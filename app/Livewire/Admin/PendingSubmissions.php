<?php

namespace App\Livewire\Admin;

use App\Models\Submission;
use Livewire\Attributes\On;
use Livewire\Component;

class PendingSubmissions extends Component
{
    #[On('submissionStatusChanged')]
    public function refreshList() { }

    public function render()
    {
        return view('livewire.admin.pending-submissions', [
            'latestPending' => Submission::with(['form', 'user'])
                ->where('status', 'pending')
                ->latest()
                ->take(5)
                ->get(),
        ]);
    }
}
