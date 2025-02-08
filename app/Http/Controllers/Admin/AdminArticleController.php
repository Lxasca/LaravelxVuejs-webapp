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

    public function edit(Request $request, $id)
    {
        $validatedData = $request->validate([
            'title' => 'nullable|string|max:255',
            'title_french' => 'nullable|string|max:255',
            'content' => 'nullable|string',
            'content_french' => 'nullable|string',
            'content_2' => 'nullable|string',
            'content_2_french' => 'nullable|string',
        ]);
    
        $article = Articles::find($id);
    
        $article->update([
            'title' => $validatedData['title'] ?? $article->title,
            'title_french' => $validatedData['title_french'] ?? $article->title_french,
            'content' => $validatedData['content'] ?? $article->content,
            'content_french' => $validatedData['content_french'] ?? $article->content_french,
            'content_2' => $validatedData['content_2'] ?? $article->content_2,
            'content_2_french' => $validatedData['content_2_french'] ?? $article->content_2_french,
        ]);
    
        return response()->json([
            'message' => 'Article mis à jour avec succès',
            'article' => $article
        ]);
    }
    
    public function destroy($id)
    {
        $article = Articles::find($id);
        $article->delete();

        return response()->json(['message' => 'Article supprimé avec succès']);
    }

}
