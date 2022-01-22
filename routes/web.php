<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;

Route::get('/', [NewsController::class, 'allNews'])->name('allNews');
// избранные (важные) новости конкретного города
Route::get('/{city}/favorites', [NewsController::class, 'favorites'])->name('favorites');
// мои избранные новости
Route::get('/myfavorites', [NewsController::class, 'myFavorites'])->name('myFavorites');
// просмотр новости
Route::get('/news/{id}', [NewsController::class, 'newsShow'])->name('newsShow');
// добавление новости в мои избранные
Route::get('/addMyFavorites/{id}', [NewsController::class, 'addMyFavorites'])->name('addMyFavorites');

// поиск
Route::post('/search', [NewsController::class, 'searchNews']);
Route::get('/search', [NewsController::class, 'searchNews'])->name('searchNews');

// смена города в куках
Route::get('/city', [NewsController::class, 'changeCity'])->name('changeCity');
