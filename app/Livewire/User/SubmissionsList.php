<?php

namespace App\Livewire\User;

use App\Models\Submission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\Url;

class SubmissionsList extends Component
{
    use WithPagination;

    #[Url(as: 'status', keep: true)]
    public $status = '';

    #[Url(as: 'q', keep: true)]
    public $search = '';

    public function render()
    {
        $submissions = Submission::with(['form'])
            ->where('user_id', Auth::id())
            ->when($this->status, function ($query) {
                return $query->where('status', $this->status);
            })
            ->when($this->search, function ($query) {
                return $query->whereHas('form', function ($q) {
                    $q->where('title', 'ILIKE', '%' . $this->search . '%');
                });
            })
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('livewire.user.submissions-list', [
            'submissions' => $submissions
        ]);
    }
}
