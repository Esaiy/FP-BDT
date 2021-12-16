<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as Controller;

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

Route::get('/', [Controller\FrontEndController::class, 'index'])->name('home');
Route::get('/category/{category}', [Controller\FrontEndController::class, 'searchCategory'])->name('category');
Route::get('/author/{author}', [Controller\FrontEndController::class, 'author'])->name('author');
Route::get('/search', [Controller\FrontEndController::class, 'searchArticle'])->name('search');

Route::group(['middleware' => ['auth']], function() {
    Route::get('/dashboard', [Controller\DashboardController::class, 'index'])
        ->middleware(['auth'])
        ->name('dashboard');

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::resource('category', Controller\CategoryController::class);
        Route::resource('article', Controller\ArticleController::class);
    });
});


require __DIR__.'/auth.php';
