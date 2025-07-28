<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;
use App\Models\Section;
use App\Models\Question;
use App\Models\Option;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{
    public function create(Section $section)
    {
        return view('admin.questions.create', compact('section'));
    }

    public function store(StoreQuestionRequest $request, Section $section)
    {
        $lastPos = $section->questions()->max('position') ?? 0;
        $data = $request->validated();
        $data['position'] = $lastPos + 1;

        DB::transaction(function () use ($section, $data, $request) {
            $question = $section->questions()->create([
                'question_text' => $data['question_text'],
                'type' => $data['type'],
                'position' => $data['position'],
            ]);

            // Hanya untuk tipe opsi
            if (in_array($question->type, ['dropdown', 'radio', 'checkbox']) && $request->filled('options')) {
                $opsi = array_map('trim', explode(',', $request->options));
                foreach ($opsi as $i => $opt) {
                    if ($opt !== '') {
                        $question->options()->create([
                            'option_text' => $opt,
                            'option_value' => $opt,
                        ]);
                    }
                }
            }
        });

        return redirect()->route('admin.forms.show', $section->form_id)
            ->with('success', 'Pertanyaan berhasil ditambahkan!');
    }

    public function edit(Section $section, Question $question)
    {
        $options_value = '';
        if (in_array($question->type, ['dropdown', 'radio', 'checkbox'])) {
            $options_value = $question->options->pluck('option_text')->implode(', ');
        }
        return view('admin.questions.edit', compact('section', 'question', 'options_value'));
    }

    public function update(UpdateQuestionRequest $request, Section $section, Question $question)
    {
        DB::transaction(function () use ($question, $request) {
            $question->update([
                'question_text' => $request->question_text,
                'type' => $request->type,
            ]);

            if (in_array($request->type, ['dropdown', 'radio', 'checkbox'])) {
                $question->options()->delete();
                $opsi = array_map('trim', explode(',', $request->options));
                foreach ($opsi as $i => $opt) {
                    if ($opt !== '') {
                        $question->options()->create([
                            'option_text' => $opt,
                            'option_value' => $opt,
                        ]);
                    }
                }
            } else {
                $question->options()->delete();
            }
        });

        return redirect()->route('admin.forms.show', $section->form_id)
            ->with('success', 'Pertanyaan berhasil diupdate!');
    }
}
