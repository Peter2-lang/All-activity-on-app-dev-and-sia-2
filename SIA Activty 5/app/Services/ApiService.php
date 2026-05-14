<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class ApiService
{
    protected string $apiKey;
    protected string $baseUrl;
    protected int $timeout = 10;
    protected int $cacheTime;

    public function __construct()
    {
        $this->apiKey = config('news.api_key');
        $this->baseUrl = config('news.base_url', 'https://newsapi.org/v2');
        $this->cacheTime = config('news.cache_time', 300);
    }

    /**
     * Get top headlines from News API
     */
    public function getTopHeadlines(?string $category = null, ?string $country = null, int $pageSize = 10): array
    {
        $cacheKey = "headlines_" . ($category ?? 'general') . "_" . ($country ?? 'us') . "_" . $pageSize;

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($category, $country, $pageSize) {
            return $this->fetchHeadlines($category, $country, $pageSize);
        });
    }

    /**
     * Search news articles
     */
    public function searchNews(string $query, ?string $category = null): array
    {
        $cacheKey = "search_" . md5($query . $category);

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($query, $category) {
            return $this->fetchSearchResults($query, $category);
        });
    }

    /**
     * Get news by category
     */
    public function getByCategory(string $category, int $pageSize = 10): array
    {
        $cacheKey = "category_" . $category . "_" . $pageSize;

        return Cache::remember($cacheKey, $this->cacheTime, function () use ($category, $pageSize) {
            return $this->fetchHeadlines($category, 'us', $pageSize);
        });
    }

    /**
     * Fetch headlines from News API
     */
    protected function fetchHeadlines(?string $category, ?string $country, int $pageSize): array
    {
        // If no API key, return demo data
        if (empty($this->apiKey)) {
            return $this->getDemoHeadlines();
        }

        try {
            $response = Http::timeout($this->timeout)
                ->get("{$this->baseUrl}/top-headlines", [
                    'apiKey' => $this->apiKey,
                    'country' => $country ?? 'us',
                    'category' => $category ?? 'technology',
                    'pageSize' => $pageSize,
                ]);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'status' => $data['status'] ?? 'ok',
                    'articles' => $data['articles'] ?? [],
                    'totalResults' => $data['totalResults'] ?? 0,
                    'source' => 'NewsAPI.org',
                    'cached' => false,
                ];
            }

            Log::error('News API Error', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $this->getDemoHeadlines();

        } catch (\Exception $e) {
            Log::error('News API Exception', ['message' => $e->getMessage()]);
            return $this->getDemoHeadlines();
        }
    }

    /**
     * Search news from News API
     */
    protected function fetchSearchResults(string $query, ?string $category): array
    {
        // If no API key, search in demo data
        if (empty($this->apiKey)) {
            return $this->searchDemoData($query, $category);
        }

        try {
            $params = [
                'apiKey' => $this->apiKey,
                'q' => $query,
                'pageSize' => 20,
                'sortBy' => 'publishedAt',
            ];

            if ($category) {
                $params['category'] = $category;
            }

            $response = Http::timeout($this->timeout)
                ->get("{$this->baseUrl}/everything", $params);

            if ($response->successful()) {
                $data = $response->json();
                return [
                    'success' => true,
                    'status' => $data['status'] ?? 'ok',
                    'articles' => $data['articles'] ?? [],
                    'totalResults' => $data['totalResults'] ?? 0,
                    'source' => 'NewsAPI.org',
                    'cached' => false,
                ];
            }

            return $this->searchDemoData($query, $category);

        } catch (\Exception $e) {
            Log::error('News Search Error', ['message' => $e->getMessage()]);
            return $this->searchDemoData($query, $category);
        }
    }

    /**
     * Demo headlines when API key is not available
     */
    protected function getDemoHeadlines(): array
    {
        return [
            'success' => true,
            'status' => 'ok',
            'articles' => [
                [
                    'source' => ['id' => 'demo', 'name' => 'Tech Daily'],
                    'author' => 'John Smith',
                    'title' => 'Laravel 11 Introduces New Features for Developers',
                    'description' => 'The latest Laravel release brings improved performance and new developer tools.',
                    'url' => 'https://example.com/laravel-11',
                    'urlToImage' => 'https://picsum.photos/400/200?random=1',
                    'publishedAt' => now()->subHours(2)->toIso8601String(),
                    'content' => 'Laravel continues to be one of the most popular PHP frameworks...',
                ],
                [
                    'source' => ['id' => 'demo', 'name' => 'Tech Daily'],
                    'author' => 'Jane Doe',
                    'title' => 'AI Revolution: How Machine Learning is Changing Web Development',
                    'description' => 'Explore how AI tools are transforming the way developers build applications.',
                    'url' => 'https://example.com/ai-web-dev',
                    'urlToImage' => 'https://picsum.photos/400/200?random=2',
                    'publishedAt' => now()->subHours(5)->toIso8601String(),
                    'content' => 'Artificial intelligence is making waves in the tech industry...',
                ],
                [
                    'source' => ['id' => 'demo', 'name' => 'Tech Daily'],
                    'author' => 'Mike Johnson',
                    'title' => 'Top 10 JavaScript Frameworks to Watch in 2024',
                    'description' => 'A comprehensive guide to the most popular JavaScript frameworks.',
                    'url' => 'https://example.com/js-frameworks',
                    'urlToImage' => 'https://picsum.photos/400/200?random=3',
                    'publishedAt' => now()->subHours(8)->toIso8601String(),
                    'content' => 'JavaScript frameworks continue to evolve rapidly...',
                ],
                [
                    'source' => ['id' => 'demo', 'name' => 'Tech Daily'],
                    'author' => 'Sarah Wilson',
                    'title' => 'Cloud Computing Trends: What to Expect This Year',
                    'description' => 'Major cloud providers are introducing new services and features.',
                    'url' => 'https://example.com/cloud-trends',
                    'urlToImage' => 'https://picsum.photos/400/200?random=4',
                    'publishedAt' => now()->subHours(12)->toIso8601String(),
                    'content' => 'Cloud technology continues to advance at a rapid pace...',
                ],
                [
                    'source' => ['id' => 'demo', 'name' => 'Tech Daily'],
                    'author' => 'Tom Brown',
                    'title' => 'Cybersecurity Best Practices for Web Applications',
                    'description' => 'Essential tips to secure your web applications from threats.',
                    'url' => 'https://example.com/cybersecurity',
                    'urlToImage' => 'https://picsum.photos/400/200?random=5',
                    'publishedAt' => now()->subHours(18)->toIso8601String(),
                    'content' => 'Security should be a top priority for all web developers...',
                ],
                [
                    'source' => ['id' => 'demo', 'name' => 'Tech Daily'],
                    'author' => 'Lisa Davis',
                    'title' => 'The Future of Web Development: What Lies Ahead',
                    'description' => 'Predictions and trends for the future of web development.',
                    'url' => 'https://example.com/future-web',
                    'urlToImage' => 'https://picsum.photos/400/200?random=6',
                    'publishedAt' => now()->subHours(24)->toIso8601String(),
                    'content' => 'The web development landscape is constantly changing...',
                ],
            ],
            'totalResults' => 6,
            'source' => 'Demo Data (Configure NEWS_API_KEY for real data)',
            'cached' => true,
        ];
    }

    /**
     * Search in demo data
     */
    protected function searchDemoData(string $query, ?string $category): array
    {
        $articles = $this->getDemoHeadlines()['articles'];
        
        $queryLower = strtolower($query);
        $filtered = array_filter($articles, function ($article) use ($queryLower) {
            return str_contains(strtolower($article['title']), $queryLower) 
                || str_contains(strtolower($article['description']), $queryLower);
        });

        return [
            'success' => true,
            'status' => 'ok',
            'articles' => array_values($filtered),
            'totalResults' => count($filtered),
            'source' => 'Demo Data (Search)',
            'cached' => false,
        ];
    }

    /**
     * Clear all cached news data
     */
    public function clearCache(): void
    {
        Cache::flush();
    }

    /**
     * Check if API key is configured
     */
    public function hasApiKey(): bool
    {
        return !empty($this->apiKey);
    }
}