<?php

use App\Models\Baby;
use Illuminate\Support\Collection;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Baby $baby;
    public string $selectedDate;

    public function mount(Baby $baby)
    {
        $this->authorize('view', $baby);
        $this->baby = $baby;
        $this->selectedDate = now()->format('Y-m-d');
    }

    public function getHistoryForDate()
    {
        return $this->baby->getHistoryForDate($this->selectedDate);
    }

    public function with(): array
    {
        return [
            'history' => $this->getHistoryForDate(),
        ];
    }
}; ?>


<div class="min-h-screen">
    <div class="overflow-hidden rounded-lg bg-white shadow-sm">
        <h2 class="sr-only" id="profile-overview-title">{{ $baby->name }}'s Dashboard</h2>
        <div class="bg-white p-6">
            <div class="sm:flex sm:items-center sm:justify-between">
                <div class="sm:flex sm:space-x-5">
                    <div class="shrink-0">
                        <img class="mx-auto size-20 rounded-full"
                            src="{{ Vite::asset('resources/images/bottle.jpeg') }}">
                    </div>
                    <div class="mt-4 text-center sm:mt-0 sm:pt-1 sm:text-left">
                        <p class="text-xl font-bold text-gray-900 sm:text-2xl">{{ $baby->name }}</p>
                        <p class="text-sm font-medium text-gray-600">{{ $baby->age }}</p>
                    </div>
                </div>
                <flux:dropdown>
                    <flux:button icon:trailing="plus" class="bg-pink-500 hover:bg-pink-600 text-white" size="sm">
                        Add
                    </flux:button>
                    <flux:menu>
                        <flux:modal.trigger name="new-diaper" class="w-full">
                            <flux:menu.item class="text-pink-600">New Diaper</flux:menu.item>
                        </flux:modal.trigger>
                        <flux:modal.trigger name="new-feeding" class="w-full">
                            <flux:menu.item class="text-blue-600">New Feeding</flux:menu.item>
                        </flux:modal.trigger>
                    </flux:menu>
                </flux:dropdown>
            </div>
        </div>
        <x-babies.statistics :history="$history" />
    </div>
    

    <flux:modal name="new-diaper" title="New Diaper" size="lg">
        <livewire:diapers.add :baby="$this->baby" @updated="$refresh" />
    </flux:modal>

    <flux:modal name="new-feeding" title="New Feeding" size="lg">
        <livewire:feedings.add :baby="$this->baby" @updated="$refresh" />
    </flux:modal>

    <!-- History Section -->
    <div class="bg-white mt-4 rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-4 sm:p-6">
            <x-babies.history :history="$history" wire:key="{{ $selectedDate }}" />
        </div>
    </div>
</div>
</div>
