<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function getArticles() {
        $articles = Articles::orderBy('created_at', 'desc')->get();

        return response()->json($articles);
    }

    public function getArticle($id) {
        $article = Articles::find($id);
        return response()->json($article);
    }

    public function updateStatus($id) {
        $article = Articles::find($id);

        

    }
}
