<?php

use App\Http\Controllers\CustomDeclarationController;
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
    return view('login');
});

    Route::get('/dashboard', [CustomDeclarationController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

    Route::post('/declaration/store', [CustomDeclarationController::class, 'store'])->name('declaration.store');
    Route::put('/declaration/update/{id}', [CustomDeclarationController::class, 'updateStatus'])->name('declaration.updateStatus');
    Route::get('/declaration/history/{id}', [CustomDeclarationController::class, 'showHistory'])->name('declaration.showHistory');

require __DIR__.'/auth.php';
