<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSectionRequest;
use App\Http\Requests\UpdateSectionRequest;
use App\Models\Form;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    // {
    //     //
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Form $form)
    {
        return view('admin.sections.create', compact('form'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSectionRequest $request, Form $form)
    {
        $lastPosition = $form->sections()->max('position') ?? 0;

        $data = $request->validated();
        $data['position'] = $lastPosition + 1;

        $form->sections()->create($data);

        return redirect()->route('admin.forms.show', $form)
            ->with('success', 'Section berhasil ditambahkan!');
    }
    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {
    //     //
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form, Section $section)
    {
        return view('admin.sections.edit', compact('form', 'section'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSectionRequest $request, Form $form, Section $section)
    {
        $section->update($request->validated());
        return redirect()->route('admin.forms.show', $form)
            ->with('success', 'Section berhasil diupdate!');
    }
}
