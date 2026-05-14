<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Integrated Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        .line-clamp-2 {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
</head>

<body class="bg-gray-100">

<!-- NAVBAR -->
<nav class="bg-blue-600 text-white p-4 flex justify-between">
    <h1 class="font-bold text-lg">📊 Integration Dashboard</h1>

    <div class="flex gap-4 items-center">
        <span>
            Welcome, 
            <strong>
                {{ auth()->user()->full_name ?? auth()->user()->name }}
            </strong>
        </span>

        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="bg-red-500 px-3 py-1 rounded hover:bg-red-600">
                Logout
            </button>
        </form>
    </div>
</nav>

<div class="p-6">

    <!-- USER PROFILE -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-3">👤 Profile</h2>

        <p><strong>Username:</strong> {{ auth()->user()->name }}</p>
        <p><strong>Full Name:</strong> {{ auth()->user()->full_name ?? 'N/A' }}</p>
        <p><strong>Email:</strong> {{ auth()->user()->email }}</p>

        <p>
            <strong>Role:</strong>
            <span class="px-2 py-1 rounded text-white 
                {{ auth()->user()->role === 'admin' ? 'bg-purple-600' : 'bg-blue-600' }}">
                {{ auth()->user()->role }}
            </span>
        </p>
    </div>

    <!-- USERS API -->
    <div class="bg-white p-6 rounded shadow mb-6">
        <h2 class="text-xl font-bold mb-3">👥 Users (Internal API)</h2>

        <!-- SEARCH -->
        <div class="flex gap-2 mb-4">
            <input id="search" placeholder="Search username..."
                class="border px-3 py-2 rounded w-full">

            <select id="role" class="border px-3 py-2 rounded">
                <option value="">All Roles</option>
                <option value="admin">Admin</option>
                <option value="user">User</option>
            </select>

            <button onclick="loadUsers()" 
                class="bg-blue-600 text-white px-4 rounded hover:bg-blue-700">
                Search
            </button>
        </div>

        <!-- TABLE -->
        <table class="w-full text-sm border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2">ID</th>
                    <th class="p-2">Username</th>
                    <th class="p-2">Full Name</th>
                    <th class="p-2">Email</th>
                    <th class="p-2">Role</th>
                </tr>
            </thead>

           <tbody>
    @if($users->isEmpty())
        <tr>
            <td colspan="5">No users found</td>
        </tr>
    @else
        @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->full_name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->role }}</td>
            </tr>
        @endforeach
    @endif
</tbody>
        </table>
    </div>

    <!-- NEWS API -->
    <div class="bg-white p-6 rounded shadow">
        <h2 class="text-xl font-bold mb-3">🌍 News API (External)</h2>

        <!-- SEARCH -->
        <div class="flex gap-2 mb-4">
            <input id="news-search" placeholder="Search news..."
                class="border px-3 py-2 rounded w-full">

            <button onclick="searchNews()" 
                class="bg-green-600 text-white px-4 rounded hover:bg-green-700">
                Search
            </button>
        </div>

        <!-- NEWS GRID -->
        <div id="news" class="grid md:grid-cols-3 gap-4">
            <p>Loading news...</p>
        </div>
    </div>

</div>

<script>

// ================= USERS =================
function loadUsers() {
    const search = document.getElementById('search').value;
    const role = document.getElementById('role').value;

    let url = '/api/users/search?';
    if (search) url += `search=${encodeURIComponent(search)}&`;
    if (role) url += `role=${role}`;

    fetch(url)
    .then(res => res.json())
    .then(data => {
        const table = document.getElementById('users-table');

        if (!data.success) {
            table.innerHTML = `<tr><td colspan="5">Error loading users</td></tr>`;
            return;
        }

        if (data.data.length === 0) {
            table.innerHTML = `<tr><td colspan="5">No users found</td></tr>`;
            return;
        }

        table.innerHTML = data.data.map(u => `
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">${u.id}</td>
                <td class="p-2 font-medium">@${u.name}</td>
                <td class="p-2">${u.full_name ?? 'N/A'}</td>
                <td class="p-2">${u.email}</td>
                <td class="p-2">
                    <span class="px-2 py-1 text-xs rounded 
                        ${u.role === 'admin' ? 'bg-purple-200 text-purple-800' : 'bg-blue-200 text-blue-800'}">
                        ${u.role}
                    </span>
                </td>
            </tr>
        `).join('');
    })
    .catch(() => {
        document.getElementById('users-table').innerHTML =
            `<tr><td colspan="5">API error</td></tr>`;
    });
}

// ================= LOAD NEWS =================
function loadNews() {
    fetch('https://api.thenewsapi.com/v1/news/top?api_token=eAoUNwvgZGmvBoMJVEcU2SqLdppMz4nGzh55VeFm&language=en&locale=us')
    .then(res => res.json())
    .then(result => {

        const news = document.getElementById('news');

        // IMPORTANT FIX: API data is inside result.data
        const articles = result.data || [];

        if (articles.length === 0) {
            news.innerHTML = "No news found";
            return;
        }

        news.innerHTML = articles.slice(0, 6).map(n => `
            <div class="border rounded p-3 hover:shadow bg-white">
                <h3 class="font-bold mb-2">${n.title}</h3>
                <p class="text-sm text-gray-600">
                    ${n.description ?? "No description available"}
                </p>
            </div>
        `).join('');
    })
    .catch((error) => {
        console.log(error);
        document.getElementById('news').innerHTML = "Error loading news";
    });
}

// ================= SEARCH NEWS =================
function searchNews() {
    const q = document.getElementById('news-search').value;

    fetch(`https://api.thenewsapi.com/v1/news/all?api_token=eAoUNwvgZGmvBoMJVEcU2SqLdppMz4nGzh55VeFm&language=en&search=${encodeURIComponent(q)}`)
    .then(res => res.json())
    .then(result => {

        const news = document.getElementById('news');
        const articles = result.data || [];

        if (articles.length === 0) {
            news.innerHTML = "No results found";
            return;
        }

        news.innerHTML = articles.slice(0, 6).map(n => `
            <div class="border rounded p-3 hover:shadow bg-white">
                <h3 class="font-bold mb-2">${n.title}</h3>
                <p class="text-sm text-gray-600">
                    ${n.description ?? "No description"}
                </p>
            </div>
        `).join('');
    })
    .catch((err) => {
        console.log(err);
        document.getElementById('news').innerHTML = "Search error";
    });
}

// INIT
document.addEventListener('DOMContentLoaded', () => {
    loadUsers();
    loadNews();
});

</script>

</body>
</html>