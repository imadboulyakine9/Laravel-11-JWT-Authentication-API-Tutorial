<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = Article::all();
        return response()->json([
            'status' => true,
            'message' => 'Articles retrieved successfully',
            'data' => $articles
        ], 200);
    }

    public function show($id)
    {
        $article = Article::findOrFail($id);
        return response()->json([
            'status' => true,
            'message' => 'Article found successfully',
            'data' => $article
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $article = Article::create($request->all());
        return response()->json([
            'status' => true,
            'message' => 'Article created successfully',
            'data' => $article
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $validator->errors()
            ], 422);
        }

        $article = Article::findOrFail($id);
        $article->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Article updated successfully',
            'data' => $article
        ], 200);
    }

    public function destroy($id)
    {
        $article = Article::findOrFail($id);
        $article->delete();
        
        return response()->json([
            'status' => true,
            'message' => 'Article deleted successfully'
        ], 204);
    }
}
