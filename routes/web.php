<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('users/{id}/login-with-account-details', [AccountController::class, 'loginWithAccountDetails'])
    ->name('account-details.login');

Route::middleware(['auth', 'verified'])->group(function () {
   
    Route::resource('account', AccountController::class);
    Route::get('account/{account}/view-password', [AccountController::class, 'viewPassword'])->name('account.view-password');


});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


require __DIR__.'/auth.php';
