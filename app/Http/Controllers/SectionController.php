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

    public function moveUp(Form $form, Section $section): RedirectResponse
    {
        abort_unless($section->form_id === $form->id, 404);

        $above = $form->sections()
            ->where('position', '<', $section->position)
            ->orderByDesc('position')
            ->first();

        if ($above) {
            // Swap position
            $tmp = $above->position;
            $above->position   = $section->position;
            $section->position = $tmp;

            $above->save();
            $section->save();
        }

        return back()->with('success', 'Section berhasil dinaikkan.');
    }

    /**
     * Turunkan posisi Section satu tingkat.
     */
    public function moveDown(Form $form, Section $section): RedirectResponse
    {
        abort_unless($section->form_id === $form->id, 404);

        // Cari section dengan order tepat di bawah
        $below = $form->sections()
            ->where('position', '>', $section->position)
            ->orderBy('position')
            ->first();

        if ($below) {
            $tmp = $below->position;
            $below->position   = $section->position;
            $section->position = $tmp;

            $below->save();
            $section->save();
        }

        return back()->with('success', 'Section berhasil diturunkan.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form, Section $section)
    {
        $section->delete();
        return redirect()->route('admin.forms.show', $form)->with('success', 'Section dihapus!');
    }
}
