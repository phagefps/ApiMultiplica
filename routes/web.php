<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController as User;
use App\Http\Controllers\TransactionController as Transaction;

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

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('users/{token?}')->group(function () {
    Route::get('', [User::class, 'index'])->name('users');
    Route::get('transactions/{client_id?}', [Transaction::class, 'index'])->name('transactions');
    Route::get('/{client_id?}', [User::class, 'show'])->name('transactions');
});