<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    public function getPosts($limit = 10)
    {
        $cacheKey = 'posts_' . $limit;
        
        return Cache::remember($cacheKey, 3600, function () use ($limit) {
            try {
                $response = Http::timeout(10)->get("https://jsonplaceholder.typicode.com/posts");
                
                if ($response->successful()) {
                    return $response->json();
                }
            } catch (\Exception $e) {
                return [];
            }
            
            return [];
        });
    }
}