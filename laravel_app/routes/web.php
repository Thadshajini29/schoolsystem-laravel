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
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Admin-only routes - Full Access
    Route::middleware(['role:admin'])->group(function () {
        // Students management
        Route::get('students/create', [StudentController::class, 'create'])->name('students.create');
        Route::post('students', [StudentController::class, 'store'])->name('students.store');
        Route::delete('students/{student}', [StudentController::class, 'destroy'])->name('students.destroy');
        
        // Grades management
        Route::get('grades/create', [GradeController::class, 'create'])->name('grades.create');
        Route::post('grades', [GradeController::class, 'store'])->name('grades.store');
        Route::delete('grades/{grade}', [GradeController::class, 'destroy'])->name('grades.destroy');
        
        // Subjects management
        Route::get('subjects/create', [SubjectController::class, 'create'])->name('subjects.create');
        Route::post('subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::delete('subjects/{subject}', [SubjectController::class, 'destroy'])->name('subjects.destroy');
    });

    // Admin and Teacher routes - View and Edit
    Route::middleware(['role:admin,teacher'])->group(function () {
        // Students - Edit
        Route::get('students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit');
        Route::put('students/{student}', [StudentController::class, 'update'])->name('students.update');
        Route::get('students/{student}/subjects', [StudentController::class, 'addSubjects'])->name('students.add_subjects');
        Route::post('students/{student}/subjects', [StudentController::class, 'storeSubjects'])->name('students.store_subjects');
        
        // Grades - Edit
        Route::get('grades/{grade}/edit', [GradeController::class, 'edit'])->name('grades.edit');
        Route::put('grades/{grade}', [GradeController::class, 'update'])->name('grades.update');
        Route::get('grades/{grade}/subjects', [GradeController::class, 'addSubjects'])->name('grades.add_subjects');
        Route::post('grades/{grade}/subjects', [GradeController::class, 'storeSubjects'])->name('grades.store_subjects');
        
        // Subjects - Edit
        Route::get('subjects/{subject}/edit', [SubjectController::class, 'edit'])->name('subjects.edit');
        Route::put('subjects/{subject}', [SubjectController::class, 'update'])->name('subjects.update');
    });

    // All authenticated users - View only
    Route::get('students', [StudentController::class, 'index'])->name('students.index');
    Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');
    
    Route::get('grades', [GradeController::class, 'index'])->name('grades.index');
    Route::get('grades/{grade}', [GradeController::class, 'show'])->name('grades.show');
    
    Route::get('subjects', [SubjectController::class, 'index'])->name('subjects.index');
    Route::get('subjects/{subject}', [SubjectController::class, 'show'])->name('subjects.show');
});
