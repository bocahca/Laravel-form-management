<?php

namespace App\Livewire\Admin;

use App\Models\Form;
use App\Models\Section;
use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Facades\DB;

class FormSections extends Component
{
    public Form $form;

    public function render()
    {
        $this->form->refresh(); 
        return view('livewire.admin.form-sections');
    }

    // ========== SECTION ==========

    public function moveUpSection($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $above = Section::where('form_id', $section->form_id)
            ->where('position', '<', $section->position)
            ->orderByDesc('position')
            ->first();

        if ($above) {
            DB::transaction(function () use ($section, $above) {
                [$section->position, $above->position] = [$above->position, $section->position];
                $section->save();
                $above->save();
            });
        }
    }

    public function moveDownSection($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $below = Section::where('form_id', $section->form_id)
            ->where('position', '>', $section->position)
            ->orderBy('position')
            ->first();

        if ($below) {
            DB::transaction(function () use ($section, $below) {
                [$section->position, $below->position] = [$below->position, $section->position];
                $section->save();
                $below->save();
            });
        }
    }

    public function deleteSection($sectionId)
    {
        Section::findOrFail($sectionId)->delete();
    }

    // ========== QUESTION ==========

    public function moveUpQuestion($questionId)
    {
        $question = Question::findOrFail($questionId);
        $above = Question::where('section_id', $question->section_id)
            ->where('position', '<', $question->position)
            ->orderByDesc('position')
            ->first();

        if ($above) {
            DB::transaction(function () use ($question, $above) {
                [$question->position, $above->position] = [$above->position, $question->position];
                $question->save();
                $above->save();
            });
        }
    }

    public function moveDownQuestion($questionId)
    {
        $question = Question::findOrFail($questionId);
        $below = Question::where('section_id', $question->section_id)
            ->where('position', '>', $question->position)
            ->orderBy('position')
            ->first();

        if ($below) {
            DB::transaction(function () use ($question, $below) {
                [$question->position, $below->position] = [$below->position, $question->position];
                $question->save();
                $below->save();
            });
        }
    }

    public function deleteQuestion($questionId)
    {
        Question::findOrFail($questionId)->delete();
    }
}
