<?php

namespace App\Http\Controllers;

use App\Models\Vocabularies;

class VocabulariesController extends Controller
{

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
