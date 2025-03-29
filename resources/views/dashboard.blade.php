<x-layouts.app :title="__('Dashboard')">
    @auth
        @if(auth()->user()->babies->isEmpty())
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between items-center text-center h-full">
                <livewire:babies.create />
            </div>
        @else
            <livewire:babies.show :baby="auth()->user()->babies->first()" />
        @endif
    @endauth
        
</x-layouts.app>
