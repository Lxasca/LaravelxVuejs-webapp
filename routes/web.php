<?php

use App\Http\Controllers\CoursesController;
use App\Http\Controllers\LevelsController;
use App\Http\Controllers\VocabulariesController;
use Illuminate\Support\Facades\Route;


// Affichage des Parcours
Route::get('/get-courses', [CoursesController::class, 'getCourses']);
// Affichage d'un Parcours
Route::get('/get-course/{id}', [CoursesController::class, 'getCourse']);
// Affichage des Niveaux d'un Parcours donné
Route::get('/get-levels-of-course/{id}', [CoursesController::class, 'getLevelsOfCourse']);
// Affichage d'un Niveau (Levels)
Route::get('/get-level/{id}', [LevelsController::class, 'getLevel']);
// Affichage des Exercises d'un Niveau donné
Route::get('/get-exercises-of-level/{id}', [LevelsController::class, 'getExercisesOfLevel']);
// Affichage des mots de vocabulaires
Route::get('/get-vocabularies/{course_id}/{level_id}', [VocabulariesController::class, 'getVocabularies']);
// Affiche chaque Vocabularies dont l'id s trouve dans le tableau $vocabularieis de Exercises
Route::get('/get-vocabulary/{id}', [VocabulariesController::class, 'getVocabulary']);
//
Route::get('/get-first-exercise-of-level/{id}', [LevelsController::class, 'getFirstExerciseOfLevel']);



Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');