<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - News Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* ✅ FIXED LINE CLAMP (STANDARD + WEBKIT) */
        .line-clamp-2 {
            display: -webkit-box;
            display: box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            box-orient: vertical;
            overflow: hidden;
        }

        .line-clamp-3 {
            display: -webkit-box;
            display: box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-purple-600 text-white p-4">
    <div class="container mx-auto flex justify-between items-center">
        <h1 class="text-xl font-bold">📰 News Admin Dashboard</h1>

        <div class="flex items-center space-x-4">
            <span>
                Welcome, {{ auth()->user()->full_name ?? auth()->user()->name }} (Admin)
            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="bg-red-500 px-4 py-2 rounded hover:bg-red-600">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<div class="container mx-auto p-6">

    <!-- STATS -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">Total Users</h3>
            <p class="text-3xl font-bold text-purple-600" id="total-users">-</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">Admins</h3>
            <p class="text-3xl font-bold text-blue-600" id="total-admins">-</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">Regular Users</h3>
            <p class="text-3xl font-bold text-green-600" id="total-regular">-</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow">
            <h3 class="text-gray-500">News Articles</h3>
            <p class="text-3xl font-bold text-orange-600" id="total-news">-</p>
        </div>
    </div>

    <!-- USERS -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-2xl font-bold mb-4">👥 User Management</h2>

        <div class="flex gap-4 mb-4">
            <input id="user-search" type="text" placeholder="Search users..."
                class="flex-1 px-4 py-2 border rounded-lg">

            <select id="role-filter" class="px-4 py-2 border rounded-lg">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button onclick="searchUsers()"
                class="bg-purple-600 text-white px-6 py-2 rounded-lg">
                🔍 Search
            </button>
        </div>

        <table class="w-full">
            <thead class="bg-gray-100">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Joined</th>
                </tr>
            </thead>

            <tbody id="users-table">
                <tr>
                    <td colspan="6" class="text-center p-4">Loading...</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- NEWS -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="text-2xl font-bold mb-4">📰 News</h2>

        <div id="news-grid" class="grid md:grid-cols-3 gap-6">
            <p>Loading news...</p>
        </div>
    </div>

</div>

<script>

function loadStats() {
    fetch('/api/users')
    .then(res => res.json())
    .then(data => {
        if (!data.success) return;

        document.getElementById('total-users').textContent = data.count;

        const admins = data.data.filter(u => u.role === 'admin').length;
        document.getElementById('total-admins').textContent = admins;
        document.getElementById('total-regular').textContent = data.count - admins;
    });
}

function searchUsers() {
    fetch('/api/users')
    .then(res => res.json())
    .then(data => {
        const tbody = document.getElementById('users-table');

        tbody.innerHTML = data.data.map(user => `
            <tr>
                <td>${user.id}</td>
                <td>@${user.name}</td>
                <td>${user.full_name}</td>
                <td>${user.email}</td>
                <td>${user.role}</td>
                <td>${new Date(user.created_at).toLocaleDateString()}</td>
            </tr>
        `).join('');
    });
}

function loadNews() {
    fetch('/api/news/headlines')
    .then(res => res.json())
    .then(data => {
        const grid = document.getElementById('news-grid');

        grid.innerHTML = data.articles.map(article => `
            <div class="border rounded-lg overflow-hidden">
                <img src="${article.urlToImage ?? 'https://picsum.photos/400/200'}"
                     class="w-full h-48 object-cover">

                <div class="p-4">
                    <h3 class="font-bold line-clamp-2">${article.title}</h3>
                    <p class="text-sm text-gray-600 line-clamp-3">${article.description ?? ''}</p>

                    <a href="${article.url}" target="_blank"
                       class="block mt-3 bg-blue-600 text-white px-3 py-2 rounded text-center">
                       Read More
                    </a>
                </div>
            </div>
        `).join('');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    loadStats();
    searchUsers();
    loadNews();
});

</script>

</body>
</html>