<?php

namespace App\Http\Controllers;

use App\Models\Exercices;
use App\Models\Exercises;
use App\Models\Levels;
use Illuminate\Http\Request;

class LevelsController extends Controller
{
    public function getLevel($id) {
        $level = Levels::find($id);
        return response()->json($level);
    }

    public function getExercisesOfLevel($id) {
        $exercises = Exercises::where('level_id', $id)->with('vocabulary')->orderBy('order', 'asc')->get();
        
        return response()->json($exercises);
    }

    public function getFirstExerciseOfLevel($id) {
        $exercise = Exercises::with('vocabulary')->find($id);
        
        return response()->json($exercise);
    }
}
