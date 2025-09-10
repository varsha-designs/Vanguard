<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>@yield('page-title', 'Page')</title>
    <script src="https://cdn.tailwindcss.com"></script> <!-- Tailwind CDN -->
</head>
<body class="h-screen flex bg-gray-100 font-sans">

    <!-- Sidebar -->
    <aside class="w-64 bg-gray-800 text-white flex flex-col">
        <div class="p-6">
            <h1 class="text-2xl font-bold mb-8">Menu</h1>
            <nav class="flex flex-col space-y-2">
                <a href="{{ route('files.upload') }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition
                          {{ request()->routeIs('files.upload') ? 'bg-gray-700 font-semibold' : '' }}">
                    Upload File
                </a>
                <a href="{{ route('files.history') }}"
                   class="flex items-center px-4 py-2 rounded-lg hover:bg-gray-700 transition
                          {{ request()->routeIs('files.history') ? 'bg-gray-700 font-semibold' : '' }}">
                    File History
                </a>
            </nav>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-6 overflow-auto">
        @yield('content')
    </main>

</body>
</html>
