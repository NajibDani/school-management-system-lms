<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminTeacherController;
use App\Http\Controllers\Admin\AdminParentController;
use App\Http\Controllers\Admin\AdminClassController;
use App\Http\Controllers\Admin\AdminModulController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Student\StudentController; // Controller untuk profil siswa
use App\Http\Controllers\Parent\ParentDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Home route - hanya untuk pengguna yang sudah login
Route::middleware(['auth'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Dashboard Admin
    Route::middleware(['role:Admin'])->group(function () {
        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

        // CRUD Siswa
        Route::prefix('admin/students')->name('admin.students.')->group(function () {
            Route::get('/', [AdminStudentController::class, 'index'])->name('index');
            Route::get('/create', [AdminStudentController::class, 'create'])->name('create');
            Route::post('/store', [AdminStudentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminStudentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminStudentController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminStudentController::class, 'destroy'])->name('destroy');
        });

        // CRUD Teacher
        Route::prefix('admin/teachers')->name('admin.teachers.')->group(function () {
            Route::get('/', [AdminTeacherController::class, 'index'])->name('index');
            Route::get('/create', [AdminTeacherController::class, 'create'])->name('create');
            Route::post('/store', [AdminTeacherController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminTeacherController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminTeacherController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminTeacherController::class, 'destroy'])->name('destroy');
        });

        // CRUD Parents
        Route::prefix('admin/parents')->name('admin.parents.')->group(function () {
            Route::get('/', [AdminParentController::class, 'index'])->name('index');
            Route::get('/create', [AdminParentController::class, 'create'])->name('create');
            Route::post('/store', [AdminParentController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminParentController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminParentController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminParentController::class, 'destroy'])->name('destroy');
        });

        // CRUD Classes
        Route::prefix('admin/classes')->name('admin.classes.')->group(function () {
            Route::get('/', [AdminClassController::class, 'index'])->name('index');
            Route::get('/create', [AdminClassController::class, 'create'])->name('create');
            Route::post('/store', [AdminClassController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminClassController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminClassController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminClassController::class, 'destroy'])->name('destroy');
        });

        // CRUD Course
        Route::prefix('admin/courses')->name('admin.courses.')->group(function () {
            Route::get('/', [AdminCourseController::class, 'index'])->name('index');
            Route::post('/store', [AdminCourseController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminCourseController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminCourseController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminCourseController::class, 'destroy'])->name('destroy');
        });

        // CRUD Modul
        Route::prefix('admin/modules')->name('admin.modules.')->group(function () {
            Route::get('/', [AdminModulController::class, 'index'])->name('index');
            Route::get('/create', [AdminModulController::class, 'create'])->name('create');
            Route::post('/store', [AdminModulController::class, 'store'])->name('store');
            Route::get('/{id}/edit', [AdminModulController::class, 'edit'])->name('edit');
            Route::put('/{id}', [AdminModulController::class, 'update'])->name('update');
            Route::delete('/{id}', [AdminModulController::class, 'destroy'])->name('destroy');
        });
    });

    // Dashboard Teacher
    Route::middleware(['role:Teacher'])->group(function () {
        Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'index'])->name('teacher.dashboard');
    });

    // Dashboard Student
    Route::middleware(['role:Student'])->group(function () {
        Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');

        // Profil Siswa
        Route::prefix('student/profile')->name('student.profile.')->group(function () {
            Route::get('/', [StudentController::class, 'profile'])->name('index'); // Lihat profil siswa
            Route::put('/update', [StudentController::class, 'update'])->name('update'); // Update profil siswa
        });
    });

    // Dashboard Parent
    Route::middleware(['role:Parent'])->group(function () {
        Route::get('/parent/dashboard', [ParentDashboardController::class, 'index'])->name('parent.dashboard');
    });
});

// Guest routes - hanya untuk pengguna yang belum login
Route::middleware(['guest'])->group(function () {
    // Route untuk form registrasi
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);

    // Login routes
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});