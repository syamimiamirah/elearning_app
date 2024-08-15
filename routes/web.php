<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ServerSideController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{student}/show', [StudentController::class, 'show'])->name('students.show');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::delete('/students/delete', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::patch('/students/{student}', [StudentController::class, 'update'])->name('students.update');
    Route::get('/students/{student}/edit', [StudentController::class, 'edit'])->name('students.edit'); 

    Route::get('/serverside', [ServerSideController::class, 'index'])->name('serverside.index');
    Route::get('/serverside/data', [ServerSideController::class, 'getData'])->name('serverside.data');
    Route::get('/serverside/{student}/show', [ServerSideController::class, 'show'])->name('serverside.show');
    Route::get('/serverside/create', [ServerSideController::class, 'create'])->name('serverside.create');
    Route::post('/serverside', [ServerSideController::class, 'store'])->name('serverside.store');
    Route::delete('/serverside/{student}', [ServerSideController::class, 'destroy'])->name('serverside.destroy');
    Route::put('/serverside/{student}', [ServerSideController::class, 'update'])->name('serverside.update');
    Route::get('/serverside/{student}/edit', [ServerSideController::class, 'edit'])->name('serverside.edit'); 
});

require __DIR__.'/auth.php';
