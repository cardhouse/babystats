<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] flex p-6 lg:p-8 items-center lg:justify-center min-h-screen flex-col">
    
    <header class="bg-blue-500 dark:bg-blue-700 text-white p-6 text-center">
        @if (Route::has('login'))
            <nav class="flex items-center justify-end gap-4">
                @auth
                    <a
                        href="{{ url('/dashboard') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal"
                    >
                        Dashboard
                    </a>
                @else
                    <a
                        href="{{ route('login') }}"
                        class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] text-[#1b1b18] border border-transparent hover:border-[#19140035] dark:hover:border-[#3E3E3A] rounded-sm text-sm leading-normal"
                    >
                        Log in
                    </a>
    
                    @if (Route::has('register'))
                        <a
                            href="{{ route('register') }}"
                            class="inline-block px-5 py-1.5 dark:text-[#EDEDEC] border-[#19140035] hover:border-[#1915014a] border text-[#1b1b18] dark:border-[#3E3E3A] dark:hover:border-[#62605b] rounded-sm text-sm leading-normal">
                            Register
                        </a>
                    @endif
                @endauth
            </nav>
        @endif
        <h1 class="text-4xl font-bold">Baby Stats Tracker</h1>
        <p class="text-lg mt-2">The easiest way to track your baby's feedings, sleep, and diaper changes!</p>
        <button onclick="toggleDarkMode()" class="mt-3 bg-gray-200 dark:bg-gray-800 text-gray-900 dark:text-white py-2 px-4 rounded-lg shadow-md hover:bg-gray-300 dark:hover:bg-gray-700">Toggle Dark Mode</button>
    </header>
    
    <main class="max-w-4xl mx-auto p-6 text-center">
        <section class="my-10">
            <h2 class="text-2xl font-semibold">Track Everything, Stay Organized</h2>
            <p class="mt-2 text-gray-700 dark:text-gray-300">Easily log and monitor your baby's habits to ensure they are happy and healthy.</p>
        </section>
        
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl">
                <h3 class="text-xl font-semibold">🍼 Feeding</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Track breastfeeding, formula, and solid food with ease.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl">
                <h3 class="text-xl font-semibold">💤 Sleep</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Monitor naps and nighttime sleep to establish routines.</p>
            </div>
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl">
                <h3 class="text-xl font-semibold">🚼 Diapers</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Keep track of wet and dirty diapers for better health insights.</p>
            </div>
        </section>
        
        <section class="mt-10">
            <a href="/app.html" class="bg-blue-500 dark:bg-blue-700 text-white py-3 px-6 rounded-lg text-lg shadow-md hover:bg-blue-600 dark:hover:bg-blue-800">Get Started</a>
        </section>
    </main>
    
    <footer class="bg-gray-800 dark:bg-gray-900 text-white text-center p-4 mt-10">
        <p>&copy; 2025 Baby Stats Tracker. All Rights Reserved.</p>
    </footer>

    @if (Route::has('login'))
        <div class="h-14.5 hidden lg:block"></div>
    @endif
</body>
</html>