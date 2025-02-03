<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Articles;
use Illuminate\Http\Request;

class AdminArticleController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_french' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'content_french' => 'nullable|string',
            'content_2' => 'nullable|string',
            'content_2_french' => 'nullable|string',
        ]);

        $article = Articles::create($validatedData);

        return response()->json([
            'message' => 'Article créé avec succès',
            'article' => $article
        ], 201);
    }
}
