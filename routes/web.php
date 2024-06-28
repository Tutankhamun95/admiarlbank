<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TransactionController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});






Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [AccountController::class, 'dashboard'])->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    //Admiral Bank
    // Route::apiResource('accounts', AccountController::class);
    // Route::get('deposit', [AccountController::class, 'deposit']);
    // Route::post('accounts/{account}/deposit', [AccountController::class, 'deposit']);
    // Route::get('deposit', [AccountController::class, 'deposit']);
    Route::get('/deposit', [AccountController::class, 'showDepositForm'])->name('deposit');
    Route::post('/store', [AccountController::class, 'store'])->name('store');


    Route::get('/transfer', [AccountController::class, 'transfer'])->name('transfer');
    Route::post('/send', [AccountController::class, 'send'])->name('send');

    Route::get('/transactions', [TransactionController::class, 'transactions'])->name('transactions');
    Route::get('/transactions/list', [TransactionController::class, 'getTransactions'])->name('transactions.list');

    // Route::post('accounts/transfer', [AccountController::class, 'transfer']);
    // Route::apiResource('transactions', TransactionController::class);

    // Route::post('/testStore', [TestController::class, 'testStore'])->name('testStore');


});

require __DIR__ . '/auth.php';
