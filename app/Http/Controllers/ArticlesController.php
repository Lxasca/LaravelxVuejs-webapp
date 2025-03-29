<?php

namespace App\Http\Controllers;

use App\Models\Articles;
use App\Models\Category;
use App\Models\Level;
use Illuminate\Http\Request;

class ArticlesController extends Controller
{
    public function getArticles($withUnpublished = null) {
        $query = Articles::with(['level', 'category'])->orderBy('created_at', 'desc');

        // $withUnpublished vaut non null depuis la requête de l'admin, car en admin on veut voir les articles publiés et non publiés
        // et il est null depuis l'user, car les utilisateurs ne doivent pas accéder aux articles non publiés
        if (is_null($withUnpublished)) {
            $query->where('status', 'published');
        }

        $articles = $query->get();

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
