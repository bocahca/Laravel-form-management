<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Form;
use App\Models\Option;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserFormController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = Form::where('is_active', true);
        if ($q) {
            $query->where('title', 'ILIKE', "%{$q}%");
        }

        $forms = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends(['q' => $q]);
        $pendingFormIds = \App\Models\Submission::where('user_id', auth()->id())
            ->where('status', 'pending')
            ->pluck('form_id')
            ->toArray();

        return view('user.forms.index', compact('forms', 'pendingFormIds'));
    }

    public function fill(Form $form)
    {
        $pending = Submission::where('form_id', $form->id)
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->first();

        if ($pending) {
            return redirect()->route('user.forms.index')
                ->with('error', 'Anda masih memiliki pengisian form ini yang belum selesai (pending).');
        }

        $form->load(['sections.questions.options']);
        return view('user.forms.fill', compact('form'));
    }

    public function submit(Request $request, Form $form)
    {
        // Validasi dinamis sesuai tipe pertanyaan
        $rules = [];
        foreach ($form->sections as $section) {
            foreach ($section->questions as $question) {
                $field = "answers.{$question->id}";
                if ($question->type === 'checkbox') {
                    $rules[$field] = 'nullable|array';
                } else {
                    $rules[$field] = 'nullable|string';
                }
            }
        }
        $request->validate($rules);

        // Simpan submission & jawaban ke DB
        DB::transaction(function () use ($request, $form) {
            $submission = Submission::create([
                'form_id' => $form->id,
                'user_id' => auth()->id(),
                'status'  => 'pending',
            ]);

            foreach ($form->sections as $section) {
                foreach ($section->questions as $question) {
                    $jawaban = $request->input("answers.{$question->id}");

                    if (is_null($jawaban) || $jawaban === '') {
                        continue;
                    }
                    
                    if (is_array($jawaban)) { // checkbox
                        $answer = Answer::create([
                            'question_id'   => $question->id,
                            'submission_id' => $submission->id,
                            'answer_text'   => null,
                        ]);

                        $answer->options()->attach($jawaban);
                    } elseif (!is_null($jawaban)) { // text, radio, dropdown
                        Answer::create([
                            'question_id'   => $question->id,
                            'submission_id' => $submission->id,
                            'answer_text'   => $jawaban,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('user.forms.index')->with('success', 'Formulir berhasil disubmit!');
    }
}
