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
        $vocabularies = Vocabularies::all(['id', 'word', 'traduction_arabic', 'transcription_arabic', 'day'])
            ->map(function ($vocabulary) {
                return [
                    'value' => $vocabulary->word,
                    'label' => $vocabulary->traduction_arabic,
                    'id'    => $vocabulary->id,
                    'phonetique' => $vocabulary->transcription_arabic,
                    'day' => $vocabulary->day
                ];
            });

        return response()->json($vocabularies);
    }
}
