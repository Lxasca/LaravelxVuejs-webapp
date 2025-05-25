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
            'status' => 'nullable|string',
            'category_id' => 'nullable|exists:categories,id',
            'level_id' => 'nullable|exists:levels,id',
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
            'category_id' => 'nullable|exists:categories,id',
            'level_id' => 'nullable|exists:levels,id',
        ]);
    
        $article = Articles::find($id);
    
        $fields = [
            'title',
            'title_french',
            'content',
            'content_french',
            'content_2',
            'content_2_french',
            'category_id',
            'level_id',
        ];

        $dataToUpdate = [];

        foreach ($fields as $field) {
            if (array_key_exists($field, $validatedData)) {
                $dataToUpdate[$field] = $validatedData[$field];
            }
        }

        $article->update($dataToUpdate);

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

    public function updateStatus($id) {
        $article = Articles::find($id);
        
        if ($article) {
            $article->status = $article->status === 'published' ? 'unpublished' : 'published';
            $article->save();
        }
    }
    

}
