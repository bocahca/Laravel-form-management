<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $query = Submission::with('form', 'user')->latest();

        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        if ($search = $request->input('q')) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('form', fn($q2) => $q2->where('title', 'ILIKE', "%$search%"))
                    ->orWhereHas('user', fn($q2) => $q2->where('name', 'ILIKE', "%$search%"));
            });
        }

        $submissions = $query->orderByDesc('created_at')->paginate(20);

        return view('admin.submissions.index', compact('submissions'));
    }

    public function review(Request $request, Submission $submission)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'review_note' => 'nullable|string|max:1000',
        ]);
        $submission->update([
            'status' => $request->status,
            'review_note' => $request->review_note,
        ]);
        return redirect()->back()->with('success', 'Submission telah direview!');
    }

    public function generatePdf(Submission $submission)
    {

        $submission->load('user', 'form', 'answers.question', 'answers.options');

        $stampPath = '';
        if ($submission->status === 'approved') {
            $imagePath = public_path('images/stamp-approved.png');
            if (File::exists($imagePath)) {
                $stampPath = $imagePath;
            }
        }

        $pdf = Pdf::loadView(
            'admin.submissions.pdf',
            [
                'submission' => $submission,
                'form' => $submission->form,
                'stampPath' => $stampPath,
            ]
        )
            ->setPaper('A4', 'portrait');;

        return $pdf->stream('submission-' . $submission->id . '.pdf');
    }
}
