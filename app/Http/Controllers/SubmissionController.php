<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class SubmissionController extends Controller
{
    public function index()
    {
        return view('admin.submissions.index');
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
