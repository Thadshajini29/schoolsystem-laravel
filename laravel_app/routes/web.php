<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('grades', GradeController::class);
    Route::get('grades/{grade}/subjects', [GradeController::class, 'addSubjects'])->name('grades.add_subjects');
    Route::post('grades/{grade}/subjects', [GradeController::class, 'storeSubjects'])->name('grades.store_subjects');

    Route::resource('subjects', SubjectController::class);
    Route::resource('students', StudentController::class);

    Route::get('students/{student}/subjects', [StudentController::class, 'addSubjects'])->name('students.add_subjects');
    Route::post('students/{student}/subjects', [StudentController::class, 'storeSubjects'])->name('students.store_subjects');
});
