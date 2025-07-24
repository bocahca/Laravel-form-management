<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (Auth::user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index'])
            ->name('dashboard');
        Route::patch('forms/{form}/toggle', [FormController::class, 'toggle'])
            ->name('forms.toggle');
        Route::resource('forms', FormController::class);
        Route::patch('forms/{form}/sections/{section}/up',    [SectionController::class, 'moveUp'])
            ->name('forms.sections.moveUp');
        Route::patch('forms/{form}/sections/{section}/down',  [SectionController::class, 'moveDown'])
            ->name('forms.sections.moveDown');
    });

Route::middleware(['auth', 'role:user'])
    ->get('/user/dashboard', [UserController::class, 'index'])
    ->name('user.dashboard');

require __DIR__ . '/auth.php';
