<?php

namespace App\Http\Controllers;

use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function subscribe($theme_id)
    {
        $user = Auth::user();

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'theme_id' => $theme_id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Subscribed to theme successfully',
            'data' => $subscription
        ], 201);
    }

    public function getSubscriptions()
    {
        $user = Auth::user();
        $subscriptions = Subscription::where('user_id', $user->id)->with('theme')->get();

        return response()->json([
            'status' => true,
            'message' => 'Subscriptions retrieved successfully',
            'data' => $subscriptions
        ], 200);
    }
}
