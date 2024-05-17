<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Auth\Admin\AuthenticatedSessionController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\Mime\MessageConverter;

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
});

require __DIR__ . '/auth.php';


Route::get('messages', [MessageController::class, 'index']);
Route::post('messages', [MessageController::class, 'store']);
// Route::get('messages/{id}/delete', [MessageController::class, 'destroy']);
Route::delete('messages/{id}/delete', [MessageController::class, 'destroy']);

Route::prefix('admin')->group(function () {
    Route::name('admin.')->controller(AuthenticatedSessionController::class)->group(function () {
        Route::get('login', 'create')->name('create')->middleware('guest:admin');
        Route::post('login', 'store')->name('store')->middleware('guest:admin');
        Route::post('logout', 'destroy')->name('destroy')->middleware('auth:admin');
    });

    Route::prefix('books')->name('book.')->controller(BookController::class)->middleware('auth:admin')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('{book}', 'show')->whereNumber('book')->name('show');
        Route::get('create', 'create')->name('create');
        // Route::get('create', 'create')->name('create')->can('create', App\Models\Book::class);
        Route::post('', 'store')->name('store');
        // Route::post('', 'store')->name('store')->can('create', App\Models\Book::class);
        Route::get('{book}/edit', 'edit')->whereNumber('book')->name('edit');
        // Route::get('{book}/edit', 'edit')->whereNumber('book')->name('edit')->can('update', 'book');
        Route::put('{book}', 'update')->whereNumber('book')->name('update');
        // Route::put('{book}', 'update')->whereNumber('book')->name('update')->can('update', 'book');
        Route::delete('{book}', 'destroy')->whereNumber('book')->name('destroy');
        // Route::delete('{book}', 'destroy')->whereNumber('book')->name('destroy')->can('delete', 'book');
    });
});
