<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class UserSubmissionController extends Controller
{
    public function show(Submission $submission)
    {
        if (!auth()->user()->role==='admin' && $submission->user_id !== auth()->id()) {
            abort(403);
        }   // Load relasi form, sections, questions, answers & options
        $submission->load([
            'form.sections.questions.options',
            'answers.options',
        ]);

        return view('user.submissions.show', [
            'submission' => $submission,
            'form'       => $submission->form,
        ]);
    }
}
