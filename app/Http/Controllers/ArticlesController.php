<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function getArticles() {
        $articles = Articles::with(['level', 'category'])->orderBy('created_at', 'desc')->get();

        return response()->json($articles);
    }

    public function getArticle($id) {
        $article = Articles::find($id);
        return response()->json($article);
    }

    public function updateStatus($id) {
        $article = Articles::find($id);
    }

    public function getLevels() {
        $levels = Level::all();

        return response()->json($levels);
    }

    public function getCategories() {
        $categories = Category::all();

        return response()->json($categories);
    }
}
