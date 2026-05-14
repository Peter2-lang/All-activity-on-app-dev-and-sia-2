<?php

return [
    'api_key' => env('NEWS_API_KEY', ''),
    'base_url' => env('NEWS_API_BASE_URL', 'https://newsapi.org/v2'),
    'default_country' => 'us',
    'default_category' => 'technology',
    'cache_time' => 300, // 5 minutes
];