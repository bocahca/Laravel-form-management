<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Form;

class FormStatusToggle extends Component
{
    public Form $form;

    public function mount(Form $form)
    {
        $this->form = $form;
    }

    public function setStatus($isActive)
    {
        $this->form->is_active = $isActive;
        $this->form->save();
    }

    public function render()
    {
        return view('livewire.admin.form-status-toggle');
    }
}
