<x-layouts.app.header :title="$title ?? null">
    <flux:main class="bg-gray-100 dark:bg-gray-900 dark:text-white">
        {{ $slot }}
    </flux:main>
</x-layouts.app.header>
