<?php

namespace App\Http\Controllers;

use App\Models\BrowsingHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrowsingHistoryController extends Controller
{
    public function getHistory()
    {
        $user = Auth::user();
        $history = BrowsingHistory::where('user_id', $user->id)->with('article')->orderBy('viewed_at', 'desc')->get();

        return response()->json([
            'status' => true,
            'message' => 'Browsing history retrieved successfully',
            'data' => $history
        ], 200);
    }
}
