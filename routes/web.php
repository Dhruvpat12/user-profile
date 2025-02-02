<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\CategoryController;
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

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::group(['middleware' => 'auth'], function () {
    Route::get('/profile', [UserProfileController::class, 'index'])->name('profile');
    Route::any('/update-profile', [UserProfileController::class, 'edit'])->name('update-profile');
    
    Route::any('/category', [CategoryController::class, 'index'])->name('category');
    Route::any('/add-category', [CategoryController::class, 'addcategory'])->name('add-category');    
    Route::any('/show-category-list', [CategoryController::class, 'showlist'])->name('show-category-list');
    Route::any('/list-category-data', [CategoryController::class, 'listdata'])->name('list-category-data');
    Route::any('/edit-category/{id}', [CategoryController::class, 'editcategory'])->name('edit-category');
    Route::any('/update-category/{id}', [CategoryController::class, 'update'])->name('update-category');
    Route::any('/deletecategory/{id}', [CategoryController::class, 'delete'])->name('deletecategory');
    Route::any('/categories-display', [CategoryController::class, 'categories_display'])->name('categories-display');
    
      
    });