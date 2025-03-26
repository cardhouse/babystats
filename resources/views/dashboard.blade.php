<x-layouts.app :title="__('Dashboard')">
    @auth
        @if(auth()->user()->babies->isEmpty())
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                <livewire:babies.create />
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                <div>
                    <h3 class="text-pink-600 font-semibold text-xl">👶 My Babies</h3>
                    <p class="mt-2 text-gray-600 dark:text-gray-300">Manage your baby's profiles and track their growth.</p>
                </div>
                <a href="/babies" class="mt-4 bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600">Go</a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                <!-- Dashboard Cards -->
                <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                    <div>
                        <h3 class="text-blue-600 font-semibold text-xl">🍼 Feeding</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Log and monitor feeding times and types.</p>
                    </div>
                    <a href="/feeding" class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Go</a>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                    <div>
                        <h3 class="text-green-600 font-semibold text-xl">💤 Sleep</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Monitor and analyze sleep patterns.</p>
                    </div>
                    <a href="/sleep" class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Go</a>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                    <div>
                        <h3 class="text-yellow-600 font-semibold text-xl">🚼 Diapers</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Track diaper changes and trends.</p>
                    </div>
                    <a href="/diapers" class="mt-4 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">Go</a>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                    <div>
                        <h3 class="text-purple-600 font-semibold text-xl">📈 Growth</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Track height, weight, and milestones.</p>
                    </div>
                    <a href="/growth" class="mt-4 bg-purple-500 text-white py-2 px-4 rounded-lg hover:bg-purple-600">Go</a>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                    <div>
                        <h3 class="text-gray-600 font-semibold text-xl">⚙️ Settings</h3>
                        <p class="mt-2 text-gray-600 dark:text-gray-300">Customize preferences and notifications.</p>
                    </div>
                    <a href="/settings" class="mt-4 bg-gray-500 text-white py-2 px-4 rounded-lg hover:bg-gray-600">Go</a>
                </div>
            </div>
        @endif
    @endauth
        
</x-layouts.app>
