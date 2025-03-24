<?php

use App\Http\Controllers\Admin\AdminArticleController;
use App\Http\Controllers\ArticlesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\ExercisesController;
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
// Compare le scenario de l'exercise actif avec le scenario de l'exercice suivant
Route::get('/compare-scenario-of-exercises/{id}', [ExercisesController::class, 'compareScenarioOfExercices']);
//
Route::get('/count-with-same-type/{id}', [ExercisesController::class, 'countWithSameType']);
//
Route::get('/get-exercise/{id}', [ExercisesController::class, 'getExercise']);
Route::get('/get-next-exercise-by-order/{id}', [ExercisesController::class, 'getNextExerciseByOrder']);
Route::get('/get-next-exercise-for-next-scenario/{id}', [ExercisesController::class, 'getNextExerciseForNextScenario']);
//
Route::get('/get-previous-exercise-scenario/{id}', [ExercisesController::class, 'getPreviousExerciseScenario']);

// Articles
Route::get('/get-articles', [ArticlesController::class, 'getArticles']);
Route::get('/get-article/{id}', [ArticlesController::class, 'getArticle']);


// ADMIN
Route::post('/admin/create-article', [AdminArticleController::class, 'store']);
Route::put('/admin/edit-article/{id}', [AdminArticleController::class, 'edit']);
Route::delete('/admin/edit-article/{id}', [AdminArticleController::class, 'destroy']);

Route::get('/get-vocabularies', [VocabulariesController::class, 'getAllVocabularies']);

// auth
Route::get('/connexion', [AuthController::class, 'connexion']);
Route::post('/inscription', [AuthController::class, 'inscription']);
Route::get('/get-length-password', [AuthController::class, 'getLengthPassword']);
Route::post('/compare-password', [AuthController::class, 'comparePassword']);


Route::get('/{any}', function () {
    return view('welcome');
})->where('any', '.*');