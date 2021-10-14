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

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index']);

Route::match(['get', 'post'], 'login', [\App\Http\Controllers\LoginController::class, 'index'])->name('login');
Route::get('logout', [\App\Http\Controllers\LoginController::class, 'logout'])->name('logout');

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin');

    Route::get('/ads', [\App\Http\Controllers\AdminController::class, 'ads'])->name('admin.ads');
    Route::match(['get', 'post'], '/ads-create/{ad?}', [\App\Http\Controllers\AdminController::class, 'adsCreate'])->name('admin.ads-create');

    Route::middleware([\App\Http\Middleware\UserIsAdmin::class])->group(function () {
        Route::get('/categories', [\App\Http\Controllers\AdminController::class, 'categories'])->name('admin.categories');
        Route::match(['get', 'post'], '/categories-create/{category?}', [\App\Http\Controllers\AdminController::class, 'categoriesCreate'])->name('admin.categories-create');
        Route::get('/subcategories', [\App\Http\Controllers\AdminController::class, 'subcategories'])->name('admin.subcategories');
        Route::match(['get', 'post'], '/subcategories-create/{subcategory?}', [\App\Http\Controllers\AdminController::class, 'subcategoriesCreate'])->name('admin.subcategories-create');
        Route::get('/cities', [\App\Http\Controllers\AdminController::class, 'cities'])->name('admin.cities');
        Route::match(['get', 'post'], '/cities-create/{city?}', [\App\Http\Controllers\AdminController::class, 'citiesCreate'])->name('admin.cities-create');
        Route::get('/delete-entity/{type}/{id}', [\App\Http\Controllers\AdminController::class, 'deleteEntity'])->name('admin.delete-entity');
    });
});
