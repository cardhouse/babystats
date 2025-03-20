<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Baby Stats Tracker</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 dark:bg-gray-900 dark:text-white flex flex-col min-h-screen">
    <header class="bg-blue-500 dark:bg-blue-700 text-white py-4 px-4 flex flex-col md:flex-row items-center justify-between shadow-md w-full">
        <div class="flex items-center space-x-3 mb-4 md:mb-0">
            <img src="{{ Vite::asset('resources/images/bottle.jpeg') }}" alt="Baby Stats Logo" class="w-12 h-12 rounded-full">
            <h1 class="text-2xl md:text-3xl font-bold">Baby Stats Tracker</h1>
        </div>
        <div class="flex flex-col sm:flex-row sm:space-x-4 space-y-2 sm:space-y-0 w-full sm:w-auto text-center">
            @auth
                <a href="{{ route('dashboard') }}" class="bg-white dark:bg-gray-800 text-blue-500 dark:text-blue-300 py-2 px-6 rounded-lg text-lg font-semibold shadow-md hover:bg-gray-200 dark:hover:bg-gray-700 w-full sm:w-auto">Dashboard</a>
            @else
                <a href="/login" class="bg-yellow-400 text-gray-900 py-2 px-6 rounded-lg text-lg font-semibold shadow-md hover:bg-yellow-500 w-full sm:w-auto">Login</a>
            @endauth
        </div>
    </header>
    
    <main class="max-w-4xl mx-auto p-4 md:p-6 text-center flex-grow">
        <section class="my-6 md:my-10">
            <h2 class="text-xl md:text-2xl font-semibold">Track Everything, Stay Organized</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">Easily log and monitor your baby's habits to ensure they are happy and healthy.</p>
        </section>
        
        <section class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 md:gap-6">
            <div class="bg-white dark:bg-gray-800 p-4 md:p-6 shadow-lg rounded-xl">
                <h3 class="text-lg md:text-xl font-semibold">🍼 Feeding</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Track breastfeeding, formula, and solid food with ease.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 md:p-6 shadow-lg rounded-xl">
                <h3 class="text-lg md:text-xl font-semibold">💤 Sleep</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Monitor naps and nighttime sleep to establish routines.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-4 md:p-6 shadow-lg rounded-xl">
                <h3 class="text-lg md:text-xl font-semibold">🚼 Diapers</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Keep track of wet and dirty diapers for better health insights.</p>
            </div>
        </section>
        
        <section class="mt-6 md:mt-10">
            @auth
                <a href="/app.html" class="bg-blue-500 dark:bg-blue-700 text-white py-2 md:py-3 px-4 md:px-6 rounded-lg text-lg shadow-md hover:bg-blue-600 dark:hover:bg-blue-800">Get Started</a>
            @else
                <a href="/register" class="bg-blue-500 dark:bg-blue-700 text-white py-2 md:py-3 px-4 md:px-6 rounded-lg text-lg shadow-md hover:bg-blue-600 dark:hover:bg-blue-800">Get Started</a>
            @endauth
        </section>
    </main>
    
    <footer class="bg-gray-800 dark:bg-gray-900 text-white text-center p-3 md:p-4 mt-6 md:mt-10">
        <p>&copy; 2025 Baby Stats Tracker. All Rights Reserved.</p>
    </footer>
</body>
</html>
