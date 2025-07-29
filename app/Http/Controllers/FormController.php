<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreFormRequest;
use App\Http\Requests\UpdateFormRequest;
use App\Models\Form;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FormController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $q = $request->input('q');

        $query = Form::where('user_id', Auth::id());

        if ($q) {
            $query->where('title', 'ILIKE', "%{$q}%");
        }

        $forms = $query
            ->orderByDesc('created_at')
            ->paginate(10)
            ->appends(['q' => $q]);

        return view('admin.forms.index', compact('forms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.forms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreFormRequest $request)
    {
        $forms = Auth::user()
                    ->forms()
                    ->create($request->validated());

        return redirect()->route('admin.forms.show', $forms)
            ->with('success', 'Formulir berhasil dibuat');
    }

    /**
     * Display the specified resource.
     */
    public function show(Form $form)
    {
        if ($form->user_id !== Auth::id()) {
            abort(403);
        }
        return view('admin.forms.show', compact('form'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Form $form)
    {
        if ($form->user_id !== Auth::id()) {
            abort(403);
        }
        return view('admin.forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFormRequest $request, Form $form)
    {

        if ($form->user_id !== Auth::id()) {
            abort(403);
        }

        $form->update($request->validated());

        return redirect()
            ->route('admin.forms.show', $form)
            ->with('success', 'Form berhasil diperbarui.');
    }
    public function toggle(Request $request, Form $form)
    {

        if ($form->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil nilai baru dari request (0 atau 1)
        $newStatus = $request->input('is_active', 0);

        // Update model
        $form->update(['is_active' => (bool) $newStatus]);

        // Redirect kembali dengan flash message
        return back()->with('success', 'Status form berhasil diubah!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Form $form)
    {
        if ($form->user_id !== Auth::id()) {
            abort(403);
        }

        $form->delete();

        return redirect()
            ->route('admin.forms.index')
            ->with('success', 'Formulir berhasil dihapus');
    }
}
