<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\MessageController;
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

Route::get('messages', [MessageController::class, 'index']);
Route::post('messages', [MessageController::class, 'store']);

// Route::get('admin/books', [BookController::class, 'index'])->name('book.index');
// Route::get('admin/books/{id}', [BookController::class, 'show'])->whereNumber('id')->name('book.show');
// Route::prefix('admin/books')->group(function () {
//     Route::get('', [BookController::class, 'index'])->name('book.index');
//     Route::get('{id}', [BookController::class, 'show'])->whereNumber('id')->name('book.show');
// });
Route::prefix('admin/books')->name('book.')->controller(BookController::class)->group(function () {
    Route::get('', 'index')->name('index');
    Route::get('{book}', 'show')->whereNumber('book')->name('show');
    Route::get('create', 'create')->name('create');
    Route::post('', 'store')->name('store');
    Route::get('{book}/edit', 'edit')->whereNumber('book')->name('edit');
});
