<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ApiService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    protected ApiService $apiService;

    public function __construct(ApiService $apiService)
    {
        $this->apiService = $apiService;
    }

    /**
     * Get top headlines
     * GET /api/news/headlines
     */
    public function headlines(Request $request)
    {
        $category = $request->get('category');
        $country = $request->get('country', 'us');
        $limit = min((int) $request->get('limit', 10), 50);

        $result = $this->apiService->getTopHeadlines($category, $country, $limit);

        if (empty($result['articles'])) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to fetch headlines. Please try again later.',
                'data' => [],
            ], 503);
        }

        return response()->json($result);
    }

    /**
     * Search news articles
     * GET /api/news/search?q=keyword
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $query = $request->get('q');
        $category = $request->get('category');

        $result = $this->apiService->searchNews($query, $category);

        return response()->json([
            'success' => true,
            'query' => $query,
            'category' => $category,
            'data' => $result['articles'],
            'totalResults' => $result['totalResults'],
            'source' => $result['source'],
        ]);
    }

    /**
     * Get news by category
     * GET /api/news/category/{category}
     */
    public function byCategory(Request $request, string $category)
    {
        $validCategories = ['business', 'entertainment', 'general', 'health', 'science', 'sports', 'technology'];
        
        if (!in_array($category, $validCategories)) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid category. Valid categories: ' . implode(', ', $validCategories),
            ], 400);
        }

        $limit = min((int) $request->get('limit', 10), 50);
        $result = $this->apiService->getByCategory($category, $limit);

        return response()->json([
            'success' => true,
            'category' => $category,
            'data' => $result['articles'],
            'totalResults' => $result['totalResults'],
            'source' => $result['source'],
        ]);
    }

    /**
     * Get available categories
     * GET /api/news/categories
     */
    public function categories()
    {
        return response()->json([
            'success' => true,
            'categories' => [
                ['slug' => 'technology', 'name' => 'Technology', 'icon' => '💻'],
                ['slug' => 'business', 'name' => 'Business', 'icon' => '💼'],
                ['slug' => 'science', 'name' => 'Science', 'icon' => '🔬'],
                ['slug' => 'health', 'name' => 'Health', 'icon' => '🏥'],
                ['slug' => 'sports', 'name' => 'Sports', 'icon' => '⚽'],
                ['slug' => 'entertainment', 'name' => 'Entertainment', 'icon' => '🎬'],
                ['slug' => 'general', 'name' => 'General', 'icon' => '📰'],
            ],
        ]);
    }

    /**
     * Clear news cache
     * POST /api/news/clear-cache (protected)
     */
    public function clearCache()
    {
        $this->apiService->clearCache();

        return response()->json([
            'success' => true,
            'message' => 'News cache cleared successfully',
        ]);
    }
}