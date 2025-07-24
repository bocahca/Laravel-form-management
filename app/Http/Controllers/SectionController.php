<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Section;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
    public function destroy(string $id)
    {
        //
    }
}
