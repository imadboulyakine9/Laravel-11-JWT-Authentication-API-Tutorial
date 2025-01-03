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
}
