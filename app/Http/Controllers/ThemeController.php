<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Theme;

use Illuminate\Http\Request;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::all();
        return response()->json([
            'status' => true,
            'message' => 'Themes retrieved successfully',
            'data' => $themes
        ], 200);
    }

    public function getArticlesByTheme($theme_id)
    {
        $articles = Theme::findOrFail($theme_id)->articles;
        return response()->json([
            'status' => true,
            'message' => 'Articles retrieved successfully',
            'data' => $articles
        ], 200);
    }
}
