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
}
