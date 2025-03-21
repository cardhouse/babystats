<?php

use App\Models\Baby;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public $babies;

    public function mount()
    {
        $user = Auth::user();
        $this->babies = $user->babies;

        // If the user only has one baby, redirect to the baby's page
        if ($this->babies->count() === 1) {
            return $this->redirectRoute('babies.show', ['baby' => $this->babies->first()]);
        }
    }
}; ?>

@push('header-items')
    <flux:text class="text-pink-500 font-bold text-2xl">My Babies</flux:text>
@endpush

<div class="flex h-full w-full flex-1 flex-col gap-6 rounded-xl bg-pink-50 p-6">
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
        @foreach($this->babies as $baby)
        <div class="relative flex flex-col items-center justify-center p-6 bg-white rounded-xl shadow-md border border-pink-200">
            <h3 class="text-pink-600 font-semibold text-xl">{{ $baby->name }}</h3>
            <p class="text-pink-400">Age: {{ $baby->age }} months</p>
            <a href="/babies/{{ $baby->id }}" class="mt-4 bg-pink-500 text-white py-2 px-4 rounded-lg hover:bg-pink-600">View Stats</a>
        </div>
        @endforeach
    </div>
</div>
