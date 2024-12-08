<?php

use App\Http\Controllers\CoursesController;
use Illuminate\Support\Facades\Route;


// Affichage des Parcours
Route::get('/get-courses', [CoursesController::class, 'getCourses']);
// Affichage d'un Parcours
Route::get('/get-course/{id}', [CoursesController::class, 'getCourse']);
// Affichage des Niveaux d'un Parcours donné
Route::get('/get-levels-of-course/{id}', [CoursesController::class, 'getLevelsOfCourse']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');