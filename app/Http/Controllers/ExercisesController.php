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

    public function countWithSameType($id)
    {
        $currentExercise = Exercises::find($id);

        if (!$currentExercise) {
            return response()->json(0); 
        }

        $type = $currentExercise->type; // !
        $order = $currentExercise->order;

        $count = 1;

        // Récupère les exercices précédents (même scénario)
        $previousExercises = Exercises::where('order', '<', $order)
            ->orderBy('order', 'desc')
            ->get();

        foreach ($previousExercises as $exercise) {
            if ($exercise->type !== $type) { // !
                break;
            }
            $count++;
        }

        // Récupère les exercices suivants (même scénario)
        $nextExercises = Exercises::where('order', '>', $order)
            ->orderBy('order', 'asc')
            ->get();

        foreach ($nextExercises as $exercise) {
            if ($exercise->type !== $type) { // !
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

    public function getNextExerciseByOrder($id) {
        $actualExercise = Exercises::find($id);

        $exercise = Exercises::where('order', '>', $actualExercise->order)
        ->orderBy('order', 'asc')
        ->first();
        
        return response()->json($exercise);
    }

    public function getPreviousExerciseScenario($id)
    {
        $currentExercise = Exercises::find($id);

        if (!$currentExercise) {
            return response()->json(['error' => 'Exercice non trouvé'], 404);
        }

        $previousExercise = Exercises::where('order', '<', $currentExercise->order)
            ->orderBy('order', 'desc')
            ->first();

        if (!$previousExercise) {
            return response()->json(['error' => 'Aucun exercice précédent'], 404);
        }

        return response()->json(['scenario' => $previousExercise->scenario]);
    }

    public function getNextExerciseForNextScenario($id)
    {
        $currentExercise = Exercises::find($id);
        $currentScenario = $currentExercise->scenario;
        $currentOrder = $currentExercise->order;
    
        $exercisesInOrder = Exercises::orderBy('order', 'asc')->get();
    
        $lastExerciseInSequence = null;
    
        // on parcourt les exercices pour trouver la suite d'exercices avec le même scénario
        foreach ($exercisesInOrder as $exercise) {
            if ($exercise->order > $currentOrder && $exercise->scenario === $currentScenario) {
                $lastExerciseInSequence = $exercise;
            }
    
            // et si on rencontre un exercice avec un scénario différent, on arrête la recherche de la suite
            if ($exercise->scenario !== $currentScenario && $lastExerciseInSequence !== null) {
                break;
            }
        }

        // $lastExerciseOfScenario = exercice avec l'order le plus élevé qui a le même scenario que le currentExercise
        // on chercher à récupérer l'exercise suivant cet exercise, donc le premier exo du prochain scenario

        $nextExercise = Exercises::where('order', '>', $currentOrder)
        ->where('scenario', '!=', $currentScenario)
        ->orderBy('order', 'asc')
        ->first();


        return response()->json($nextExercise);
    }

}
