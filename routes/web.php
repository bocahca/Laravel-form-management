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
    Route::get('submissions/{submission}', [UserSubmissionController::class, 'show'])
        ->name('user.submissions.show');
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

        Route::resource('forms.sections', SectionController::class)
            ->except('show');
        Route::patch('forms/{form}/sections/{section}/up',    [SectionController::class, 'moveUp'])
            ->name('forms.sections.moveUp');
        Route::patch('forms/{form}/sections/{section}/down',  [SectionController::class, 'moveDown'])
            ->name('forms.sections.moveDown');

        // Nested di bawah forms.sections
        Route::resource('sections.questions', QuestionController::class)
            ->except('show');
        Route::patch('sections/{section}/questions/{question}/up',    [QuestionController::class, 'moveUp'])
            ->name('sections.questions.moveUp');
        Route::patch('sections/{section}/questions/{question}/down',  [QuestionController::class, 'moveDown'])
            ->name('sections.questions.moveDown');

        Route::get('submissions', [SubmissionController::class, 'index'])->name('submissions.index');
        Route::get('submissions/{submission}', [SubmissionController::class, 'show'])->name('submissions.show');
        Route::patch('submissions/{submission}/review', [SubmissionController::class, 'review'])->name('submissions.review');
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
    });

require __DIR__ . '/auth.php';
