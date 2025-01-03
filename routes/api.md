<?php 

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ThemeController;
use App\Http\Controllers\SubscriptionController;
use App\Http\Controllers\BrowsingHistoryController;
use App\Http\Controllers\RecommendationController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ThemeManagerController;
use App\Http\Controllers\EditorController;

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:api');
    Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:api');
    Route::get('/profile', [AuthController::class, 'profile'])->middleware('auth:api');
});

Route::middleware('auth:api')->group(function () {
    // Common User Routes
    Route::get('articles', [ArticleController::class, 'index']); // List all articles
    Route::get('articles/{id}', [ArticleController::class, 'show']); // View a specific article
    Route::get('themes', [ThemeController::class, 'index']); // List all themes
    Route::get('themes/{theme_id}/articles', [ThemeController::class, 'getArticlesByTheme']); // Articles by theme

    // Subscribed User Routes
    Route::middleware('role:subscriber')->group(function () {
        Route::post('subscribe/{theme_id}', [SubscriptionController::class, 'subscribe']); // Subscribe to a theme
        Route::get('subscriptions', [SubscriptionController::class, 'getSubscriptions']); // View subscriptions
        Route::post('articles/propose', [ArticleController::class, 'propose']); // use put
        Route::get('browsing-history', [BrowsingHistoryController::class, 'index']); // View browsing history
        Route::post('browsing-history/filter', [BrowsingHistoryController::class, 'filter']); // Filter browsing history
        Route::post('articles/{id}/rate', [ArticleController::class, 'rate']); // Rate an article
        Route::post('articles/{id}/chat', [ChatController::class, 'addMessage']); // Add chat message
        Route::get('articles/{id}/chat', [ChatController::class, 'getMessages']); // Get chat messages
        Route::get('recommendations', [RecommendationController::class, 'getRecommendations']); // Get recommended articles
    });

    // Theme Manager Routes
    Route::middleware('role:theme_manager')->group(function () {
        Route::get('theme/statistics', [ThemeManagerController::class, 'statistics']); // View statistics for theme
        Route::get('theme/articles', [ThemeManagerController::class, 'getSubmittedArticles']); // View submitted articles
        Route::post('theme/articles/{id}/publish', [ThemeManagerController::class, 'publishArticle']); // Propose article for publishing
        Route::delete('theme/articles/{id}', [ThemeManagerController::class, 'deleteArticle']); // Delete an article
        Route::post('theme/chat/moderate', [ChatController::class, 'moderate']); // Moderate chat messages
    });

    // Editor Routes
    Route::middleware('role:editor')->group(function () {
        Route::get('editor/statistics', [EditorController::class, 'getStatistics']); // View global statistics
        Route::post('editor/issues', [EditorController::class, 'publishIssue']); // Publish an issue
        Route::put('editor/issues/{id}/status', [EditorController::class, 'toggleIssueStatus']); // Activate/Deactivate issue
        Route::put('editor/articles/{id}/status', [EditorController::class, 'toggleArticleStatus']); // Activate/Deactivate article
        Route::post('editor/users/{id}/block', [EditorController::class, 'blockUser']); // Block user
        Route::post('editor/users/{id}/unblock', [EditorController::class, 'unblockUser']); // Unblock user
        Route::delete('editor/users/{id}', [EditorController::class, 'deleteUser']); // Delete user
    });

    
});
