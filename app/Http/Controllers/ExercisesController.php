<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use Illuminate\Http\Request;

class ExercisesController extends Controller
{
    public function compareScenarioOfExercices($id) {
        // Récupérer le scénario de l'exercice actuel
        $currentExercise = Exercises::find($id);
        $currentScenario = $currentExercise->scenario;
    
        // Récupérer le prochain exercice basé sur le champ 'order'
        //$nextExercise = Exercises::where('order', $currentExercise->order + 1)->get();
        $nextScenario = Exercises::where('order', $currentExercise->order + 1)->value('scenario');

    
        // Si c'est le dernier exercice du niveau
        /**if (!$nextExercise) {
            return response()->json(0);
        }**/
    
        $areScenariosEqual = $currentScenario === $nextScenario;
    
        return response()->json($areScenariosEqual);
    }
    
}
