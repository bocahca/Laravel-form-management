<?php

namespace App\Http\Controllers;

use App\Models\Form;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.dashboard');
    }
}
