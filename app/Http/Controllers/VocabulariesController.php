<?php

namespace App\Http\Controllers;

use App\Models\Exercises;
use App\Models\Vocabularies;
use Illuminate\Http\Request;

class VocabulariesController extends Controller
{
    public function getVocabularies($courseId, $levelId) {

        // tous les exercices qui correspondent au dernier level débloqué de l'user, disons 1
        $exercises = Exercises::where('level_id', $levelId)->with('vocabulary')->get();

        // on veut tous les mots de vocabulaires qui correspondent à ce niveau débloqué
        $vocabularies = $exercises->pluck('vocabulary')->flatten()->unique('id');
        // pluck récupère la relation vocabulary pour chaque exercice, et renvoie un tableau de collections
        // flatten aplatie le tableau de collections en une seule collection
        // unique pour éviter les doublons, car la plupart des vocab sont liés à un plusieurs exercices

        return response()->json($vocabularies);
    }

    public function getVocabulary($id)
    {
       $vocabulary = Vocabularies::find($id);

        return response()->json($vocabulary);
    }

    public function getAllVocabularies()
    {
        $vocabularies = Vocabularies::all(['id', 'word', 'traduction_arabic'])
            ->map(function ($vocabulary) {
                return [
                    'value' => $vocabulary->word,
                    'label' => $vocabulary->traduction_arabic,
                    'id'    => $vocabulary->id,
                ];
            });

        return response()->json($vocabularies);
    }

}
