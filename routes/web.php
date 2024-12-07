<?php

use App\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;


// Affichage des Parcours
Route::get('/get-courses', [CoursesController::class, 'getCourses']);

Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');