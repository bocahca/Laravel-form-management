<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\Submission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $activeFormsCount = Form::where('is_active', true)->count();

        $recent = Submission::with('form')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->limit(5)
            ->get(['id', 'form_id', 'status', 'created_at']);

        $statuses = Submission::selectRaw('status, count(*) as total')
            ->where('user_id', Auth::id())
            ->groupBy('status')
            ->pluck('total', 'status')
            ->all();

        $pending  = $statuses['pending']  ?? 0;
        $approved = $statuses['approved'] ?? 0;
        $rejected = $statuses['rejected'] ?? 0;
        return view('user.dashboard', compact(
            'activeFormsCount',
            'recent',
            'pending',
            'approved',
            'rejected'
        ));
    }
}
