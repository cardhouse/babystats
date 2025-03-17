<x-layouts.app :title="__('Dashboard')">
    <div >
        @if(auth()->user()->has('babies'))
            <livewire:babies.index />
        @else
            <livewire:babies.create />
        @endif
        
    </div>
</x-layouts.app>
