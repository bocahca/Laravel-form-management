<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class SubmissionController extends Controller
{
    public function index(Request $request)
    {
        $submissions = Submission::with('form', 'user')->latest()->paginate(20);
        return view('admin.submissions.index', compact('submissions'));
    }

    public function show(Submission $submission)
    {
        $submission->load(['form', 'user', 'answers.question', 'answers.options']);
        return view('admin.submissions.show', compact('submission'));
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
}
