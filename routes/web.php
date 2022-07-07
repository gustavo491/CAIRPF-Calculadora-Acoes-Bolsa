<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');

    Route::group(['prefix' => '/transactions'], function () {
        Route::get('', [App\Http\Controllers\TransactionsController::class, 'index'])->name('transactions');
        Route::get('add', [App\Http\Controllers\TransactionsController::class, 'create'])->name('add-transaction');
        Route::get('import', [App\Http\Controllers\TransactionsController::class, 'import'])->name('import-transaction');
        Route::post('add/save', [App\Http\Controllers\TransactionsController::class, 'store'])->name('save-transaction');
        Route::get('edit/{id}', [App\Http\Controllers\TransactionsController::class, 'edit'])->name('edit-transaction');
        Route::post('edit/save/{id}', [App\Http\Controllers\TransactionsController::class, 'update'])->name('update-transaction');
        Route::post('delete/{id}', [App\Http\Controllers\TransactionsController::class, 'destroy'])->name('destroy-transaction');
        Route::post('import/save', [App\Http\Controllers\TransactionsController::class, 'import'])->name('import-transactions');
    });

    Route::group(['prefix' => '/actives'], function () {
        Route::get('', [App\Http\Controllers\ActivesController::class, 'index'])->name('actives');
        Route::get('add', [App\Http\Controllers\ActivesController::class, 'create'])->name('add-active');
        Route::get('import', [App\Http\Controllers\ActivesController::class, 'import'])->name('import-active');
        Route::post('add/save', [App\Http\Controllers\ActivesController::class, 'store'])->name('save-active');
        Route::get('edit/{id}', [App\Http\Controllers\ActivesController::class, 'edit'])->name('edit-active');
        Route::post('edit/save/{id}', [App\Http\Controllers\ActivesController::class, 'update'])->name('update-active');
        Route::post('delete/{id}', [App\Http\Controllers\ActivesController::class, 'destroy'])->name('destroy-active');
    });

    Route::group(['prefix' => '/reports'], function () {
        Route::get('', [App\Http\Controllers\ReportsController::class, 'index'])->name('reports');
        Route::post('preview', [App\Http\Controllers\ReportsController::class, 'preview'])->name('preview-report');
        Route::post('excel', [App\Http\Controllers\ReportsController::class, 'excel'])->name('excel-report');
        Route::post('pdf', [App\Http\Controllers\ReportsController::class, 'pdf'])->name('pdf-report');
    });
});

require __DIR__.'/auth.php';
