<?php

namespace App\Http\Controllers;

use App\Models\Vocabularies;
use Illuminate\Http\Request;

class VocabulariesController extends Controller
{
    public function getVocabularies($courseId, $levelId) {
        $vocabularies = Vocabularies::with('level', $levelId);

        return response()->json($vocabularies);
    }
}
