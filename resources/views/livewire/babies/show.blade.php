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

<div class="min-h-screen bg-gray-50">
    <div class="sticky top-0 z-10 bg-white border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <div class="bg-pink-50 rounded-full p-2">
                        <flux:icon name="heart" class="w-6 h-6 text-pink-400" />
                    </div>
                    <div class="min-w-0">
                        <h1 class="text-lg font-semibold text-gray-900 truncate">{{ $baby->name }}</h1>
                        <p class="text-sm text-pink-400">Age: {{ $baby->age }} months</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <flux:date-picker wire:model.live="selectedDate" with-today placeholder="" class="bg-white rounded-lg shadow-sm border-gray-200" size="sm" />
                    <flux:dropdown>
                        <flux:button icon:trailing="plus" class="bg-pink-500 hover:bg-pink-600 text-white" size="sm">Add</flux:button>
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
        </div>
    </div>

    <flux:modal name="new-diaper" title="New Diaper" size="lg">
        <livewire:diapers.add :baby="$this->baby" @updated="$refresh" />
    </flux:modal>

    <flux:modal name="new-feeding" title="New Feeding" size="lg">
        <livewire:feedings.add :baby="$this->baby" @updated="$refresh" />
    </flux:modal>
            
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6" wire:poll.60s>
        <!-- Statistics Section - Always on top on mobile -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-900">Statistics</h2>
                <div class="mt-4">
                    <x-babies.statistics :history="$history" />
                </div>
            </div>
        </div>

        <!-- History Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="p-4 sm:p-6">
                <h2 class="text-xl font-semibold text-gray-900">{{ $baby->name }}'s History</h2>
                <div class="mt-4">
                    <x-babies.history :history="$history" wire:key="{{ $selectedDate }}" />
                </div>
            </div>
        </div>
    </div>
</div>
