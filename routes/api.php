<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\UserController as User;
use App\Http\Controllers\Api\V1\TransactionController as Transaction;
use App\Http\Controllers\Api\V1\LogController as Log;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('users/{token?}')->group(function () {
    Route::get('', [User::class, 'index'])->name('api-users');
    Route::get('transactions/{client_id?}', [Transaction::class, 'index'])->name('api-transactions');
    Route::post('search/{val_search?}', [User::class, 'search'])->name('api-search-users');
    Route::get('log', [Log::class, 'index'])->name('api-log');
    Route::get('{client_id?}', [User::class, 'show'])->name('api-information-users');    
});