<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News Dashboard - Laravel Integration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-600 to-purple-700 min-h-screen flex items-center justify-center">
    <div class="text-center text-white">
        <div class="text-6xl mb-4">📰</div>
        <h1 class="text-5xl font-bold mb-4">News Dashboard</h1>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Laravel Integration Project featuring Authentication, REST APIs & Live News Feed
        </p>
        
        <div class="space-x-4 mb-12">
            <a href="{{ route('login') }}" class="bg-white text-blue-600 px-8 py-3 rounded-lg font-semibold hover:bg-gray-100 transition shadow-lg">
                Login
            </a>
            <a href="{{ route('register') }}" class="bg-transparent border-2 border-white px-8 py-3 rounded-lg font-semibold hover:bg-white hover:text-blue-600 transition">
                Register
            </a>
        </div>

        <!-- Features Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 max-w-5xl mx-auto">
            <div class="bg-white bg-opacity-20 p-6 rounded-lg backdrop-blur">
                <div class="text-3xl mb-3">🔐</div>
                <h3 class="font-bold mb-2">Authentication</h3>
                <p class="text-sm">Laravel Breeze with role-based access (Admin/User)</p>
            </div>
            <div class="bg-white bg-opacity-20 p-6 rounded-lg backdrop-blur">
                <div class="text-3xl mb-3">🗄️</div>
                <h3 class="font-bold mb-2">Internal API</h3>
                <p class="text-sm">Custom REST API for user management</p>
            </div>
            <div class="bg-white bg-opacity-20 p-6 rounded-lg backdrop-blur">
                <div class="text-3xl mb-3">📰</div>
                <h3 class="font-bold mb-2">News API</h3>
                <p class="text-sm">Live headlines from News API integration</p>
            </div>
            <div class="bg-white bg-opacity-20 p-6 rounded-lg backdrop-blur">
                <div class="text-3xl mb-3">⚡</div>
                <h3 class="font-bold mb-2">Caching</h3>
                <p class="text-sm">Redis/cached API responses for speed</p>
            </div>
        </div>

        <!-- API Endpoints -->
        <div class="mt-12 bg-white bg-opacity-10 p-6 rounded-lg max-w-3xl mx-auto">
            <h3 class="font-bold text-xl mb-4">🔌 Available API Endpoints</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-left text-sm">
                <div>
                    <p class="font-semibold mb-2">News Endpoints:</p>
                    <code class="block bg-black bg-opacity-30 p-2 rounded mb-1">GET /api/news/headlines</code>
                    <code class="block bg-black bg-opacity-30 p-2 rounded mb-1">GET /api/news/search?q=term</code>
                    <code class="block bg-black bg-opacity-30 p-2 rounded mb-1">GET /api/news/category/tech</code>
                </div>
                <div>
                    <p class="font-semibold mb-2">User Endpoints:</p>
                    <code class="block bg-black bg-opacity-30 p-2 rounded mb-1">GET /api/users</code>
                    <code class="block bg-black bg-opacity-30 p-2 rounded mb-1">GET /api/users/{id}</code>
                    <code class="block bg-black bg-opacity-30 p-2 rounded mb-1">GET /api/users/search</code>
                </div>
            </div>
        </div>
    </div>
</body>
</html>