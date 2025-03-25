<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\VocabulariesController;
use Illuminate\Support\Facades\Route;



// Articles
Route::get('/get-articles', [ArticlesController::class, 'getArticles']);
Route::get('/get-article/{id}', [ArticlesController::class, 'getArticle']);

Route::get('/get-levels', [ArticlesController::class, 'getLevels']);
Route::get('/get-categories', [ArticlesController::class, 'getCategories']);

// ADMIN
Route::post('/admin/create-article', [AdminArticleController::class, 'store']);
Route::put('/admin/edit-article/{id}', [AdminArticleController::class, 'edit']);
Route::delete('/admin/edit-article/{id}', [AdminArticleController::class, 'destroy']);
Route::put('/admin/update-status-article/{id}', [AdminArticleController::class, 'updateStatus']);


Route::get('/get-vocabularies', [VocabulariesController::class, 'getAllVocabularies']);
Route::get('/get-vocabulary/{id}', [VocabulariesController::class, 'getVocabulary']);

// auth
Route::get('/connexion', [AuthController::class, 'connexion']);
Route::post('/inscription', [AuthController::class, 'inscription']);
Route::get('/get-length-password', [AuthController::class, 'getLengthPassword']);
Route::post('/compare-password', [AuthController::class, 'comparePassword']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');