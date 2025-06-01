<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TitleController;

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

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'login'])->name('login.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/', [TitleController::class, 'index'])->name('titles.index');
    Route::get('/load-more', [TitleController::class, 'loadMore'])->name('titles.loadMore');
    Route::get('/titles/{imdbID}', [TitleController::class, 'show'])->name('titles.show');

    Route::get('/lang/{locale}', function ($locale) {
        if (! in_array($locale, ['en', 'id'])) {
            abort(400);
        }
        session(['locale' => $locale]);
        app()->setLocale($locale);
        return redirect()->back();
    })->name('lang.switch');

    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
});
