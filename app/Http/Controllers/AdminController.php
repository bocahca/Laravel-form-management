<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $forms = Form::where('user_id', Auth::id())->withCount('submissions')->get();
        $formsCount = $forms->count();
        $totalSubmissions = $forms->sum('submissions_count');
        $pendingCount = Submission::where('status', 'pending')->count();
        return view('admin.dashboard', compact('formsCount', 'totalSubmissions', 'pendingCount'));
    }
}
