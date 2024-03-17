<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\MotherController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RescueBabyController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChildController;

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



Route::get('/', [WelcomeController::class, 'index']);

Route::get('/home', function () {
    return redirect('/');
})->name('home');

Route::resource('babies', RescueBabyController::class);
//child routes
// Route::resource('child', ChildController::class)->name('child');'
Route::resource('child', ChildController::class);


//mother routes
Route::resource('mother', MotherController::class);

Route::get('/contact', [ContactController::class, 'index'])->name('contact');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
