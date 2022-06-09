<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
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

Auth::routes();

Route::group(['prefix' => 'admin','middleware' => 'auth'],function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // articles
        Route::resource('articles', ArticleController::class);
        Route::resource('categories', CategoryController::class);

    // users

    Route::group(['prefix' => 'users'],function(){
        Route::get('/settings/{id}', [DashboardController::class, 'profile'])->name('edit.profile');
        Route::post('/update-profile/{id}', [DashboardController::class, 'update'])->name('update-profile');
        Route::get('/detele/{id}', [DashboardController::class, 'delete'])->name('delete.profile');
        Route::get('/add-user', [DashboardController::class, 'addUser'])->name('add.user');
        Route::post('/store-user', [DashboardController::class, 'storeUser'])->name('store.user');
    });
    // categories
    Route::group(['prefix' => 'categories'],function(){
        Route::get('/categories', [DashboardController::class, 'categories'])->name('categories');
        Route::post('/store-categories', [DashboardController::class, 'storeCategories'])->name('store.categories');
        Route::get('/edit-categories/{id}', [DashboardController::class, 'editCategories'])->name('edit.categories');
    });
  
});

