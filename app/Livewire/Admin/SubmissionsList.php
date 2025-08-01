<?php

namespace App\Livewire\Admin;

use App\Models\Submission;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\Attributes\On; // <-- Import On
use Livewire\Attributes\Url;


class SubmissionsList extends Component
{
    use WithPagination;

    #[Url(as: 'status', keep: true)]
    public $status = '';

    #[Url(as: 'q', keep: true)]
    public $search = '';

    #[On('submissionUpdated')]
    public function refreshList()
    {
        $this->render();
    }

    public function updated($property)
    {
        if (in_array($property, ['status', 'search'])) {
            $this->resetPage();
        }
    }

    public function render()
    {
        // Logika render tetap sama seperti sebelumnya
        $submissions = Submission::with(['user', 'form'])
            ->when($this->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->when($this->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->whereHas('user', function ($q) use ($search) {
                        $q->where('name', 'ILIKE', '%' . $search . '%');
                    })
                        ->orWhereHas('form', function ($q) use ($search) {
                            $q->where('title', 'ILIKE', '%' . $search . '%');
                        });
                });
            })
            ->latest()
            ->paginate(10);

        return view('livewire.admin.submissions-list', [
            'submissions' => $submissions,
        ]);
    }
}
