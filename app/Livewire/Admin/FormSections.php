<?php

namespace App\Livewire\Admin;

use App\Models\Form;
use App\Models\Section;
use App\Models\Question;
use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;

class FormSections extends Component
{
    public Form $form;
    public $showSectionModal = false;
    public $isEditSection = false;
    public $sectionTitle;
    public $sectionDescription;
    public $editingSectionId = null;

    public $questionText = '';
    public $questionType = '';
    public $questionOptions = '';
    public $editingQuestionId = null;
    public $currentSectionId = null;
    public $isEditQuestion = false;
    public $showQuestionModal = false;

    #[On('openCreateSectionModal')]
    public function openCreateSectionModal()
    {
        $this->reset(['sectionTitle', 'sectionDescription', 'editingSectionId']);
        $this->isEditSection = false;
        $this->showSectionModal = true;
    }

    #[On('editSection')]
    public function openEditSectionModal($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $this->sectionTitle = $section->title;
        $this->sectionDescription = $section->description;
        $this->editingSectionId = $section->id;
        $this->isEditSection = true;
        $this->showSectionModal = true;
    }

    public function saveSection()
    {
        $this->validate([
            'sectionTitle' => 'required|string|max:255',
            'sectionDescription' => 'nullable|string',
        ]);

        if ($this->isEditSection && $this->editingSectionId) {
            Section::where('id', $this->editingSectionId)->update([
                'title' => $this->sectionTitle,
                'description' => $this->sectionDescription,
            ]);
        } else {
            $maxPos = Section::where('form_id', $this->form->id)->max('position') ?? 0;

            Section::create([
                'form_id' => $this->form->id,
                'title' => $this->sectionTitle,
                'description' => $this->sectionDescription,
                'position' => $maxPos + 1,
            ]);
        }

        $this->showSectionModal = false;
        $this->reset(['sectionTitle', 'sectionDescription', 'editingSectionId']);
    }


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
    #[On('openCreateQuestionModal')]
    public function createQuestion($sectionId)
    {
        $this->resetQuestionFields();
        $this->isEditQuestion = false;
        $this->currentSectionId = $sectionId;
        $this->showQuestionModal = true;
    }

    #[On('openEditQuestionModal')]
    public function editQuestion($questionId)
    {
        $question = Question::with('options')->findOrFail($questionId);
        $this->editingQuestionId = $question->id;
        $this->currentSectionId = $question->section_id;
        $this->questionText = $question->question_text;
        $this->questionType = $question->type;
        $this->questionOptions = $question->options->pluck('option_text')->implode(', ');
        $this->isEditQuestion = true;
        $this->showQuestionModal = true;
    }
    public function saveQuestion()
    {
        $this->validate([
            'questionText' => 'required|string|max:255',
            'questionType' => 'required|string|in:text,checkbox,radio,dropdown,textarea',
        ]);

        DB::transaction(function () {
            if ($this->isEditQuestion && $this->editingQuestionId) {
                // --- UPDATE QUESTION ---
                $question = Question::findOrFail($this->editingQuestionId);
                $question->update([
                    'question_text' => $this->questionText,
                    'type' => $this->questionType,
                ]);

                $question->options()->delete();
                if (in_array($this->questionType, ['checkbox', 'radio', 'dropdown'])) {
                    $options = array_map('trim', explode(',', $this->questionOptions));
                    foreach ($options as $opt) {
                        $question->options()->create(['option_text' => $opt, 'option_value' => $opt]);
                    }
                }
            } else {
                // --- CREATE QUESTION ---
                $maxPos = Question::where('section_id', $this->currentSectionId)->max('position') ?? 0;

                $question = Question::create([
                    'section_id' => $this->currentSectionId, // <-- GUNAKAN: sectionId yg tersimpan
                    'question_text' => $this->questionText,
                    'type' => $this->questionType,
                    'position' => $maxPos + 1,
                ]);

                if (in_array($this->questionType, ['checkbox', 'radio', 'dropdown'])) {
                    $options = array_map('trim', explode(',', $this->questionOptions));
                    foreach ($options as $opt) {
                        $question->options()->create(['option_text' => $opt, 'option_value' => $opt]);
                    }
                }
            }
        });

        $this->resetQuestionFields();
        $this->showQuestionModal = false;
    }

    private function resetQuestionFields()
    {
        $this->reset(['questionText', 'questionType', 'questionOptions', 'editingQuestionId', 'currentSectionId']);
    }

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
