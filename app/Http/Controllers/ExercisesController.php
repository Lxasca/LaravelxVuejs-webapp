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

    public function countWithSameScenario($id)
    {
        // Récupérer l'exercice actif
        $currentExercise = Exercises::find($id);

        $scenario = $currentExercise->scenario;
        $order = $currentExercise->order;

        // Initialiser le compteur
        $count = 1; // Inclut l'exercice actuel

        // Récupérer et compter les exercices avec le même scénario avant
        $previousExercises = Exercises::where('order', '<', $order)
            ->where('scenario', $scenario)
            ->orderBy('order', 'desc')
            ->get();

        foreach ($previousExercises as $exercise) {
            if ($exercise->scenario !== $scenario) {
                break;
            }
            $count++;
        }

        // Récupérer et compter les exercices avec le même scénario après
        $nextExercises = Exercises::where('order', '>', $order)
            ->orderBy('order', 'asc')
            ->get();

        foreach ($nextExercises as $exercise) {
            if ($exercise->scenario !== $scenario) {
                break;
            }
            $count++;
        }

        return response()->json($count);
    }

    public function getExercise($id) {
        $exercise = Exercises::find($id);
        return response()->json($exercise);
    }

}
