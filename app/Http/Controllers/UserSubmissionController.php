<?php

namespace App\Http\Controllers;

use App\Models\Submission;
use Illuminate\Http\Request;

class UserSubmissionController extends Controller
{

    public function index()
    {
        return view('user.submissions.index');
    }
}
