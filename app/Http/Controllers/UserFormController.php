<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

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

        // GANTI ke user.forms.index!
        return view('user.forms.index', compact('forms'));
    }
}
