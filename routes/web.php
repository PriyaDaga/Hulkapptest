<?php

//use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

//Route::resource('/users','UserController');
//Route::get('/dashboard', [UserController::class,'dashboard'])->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/users', [ProfileController::class, 'users'])->name('profile.users');
    Route::get('/users/edit/{id}', [ProfileController::class, 'edituser'])->name('user.edit');
    Route::post('/users/update/{id}', [ProfileController::class, 'updateuser'])->name('user.update');
    Route::get('/users/delete/{id}', [ProfileController::class, 'deleteuser'])->name('user.delete');
    Route::get('/users/verify/{id}', [ProfileController::class, 'verifyuser'])->name('user.verify');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
