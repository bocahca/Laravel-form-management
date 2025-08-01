<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\SubmissionController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserFormController;
use App\Http\Controllers\UserSubmissionController;
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

        Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
        Route::patch('submissions/{submission}/review', [SubmissionController::class, 'review'])->name('submissions.review');
        Route::get('submissions/{submission}/pdf', [SubmissionController::class, 'generatePdf'])
            ->name('submissions.pdf');
    });

Route::middleware(['auth', 'role:user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserController::class, 'index'])
            ->name('dashboard');
        Route::get('/forms', [UserFormController::class, 'index'])
            ->name('forms.index');
        Route::get('forms/{form}/fill', [UserFormController::class, 'fill'])->name('forms.fill');
        Route::post('forms/{form}/submit', [UserFormController::class, 'submit'])->name('forms.submit');
        Route::get('submissions/{submission}', [UserSubmissionController::class, 'show'])
            ->name('submissions.show');
    });

require __DIR__ . '/auth.php';
