<?php

use App\Models\Baby;
use Illuminate\Support\Collection;
use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

    public ?string $filterDate = null;

    public function getHistoryProperty(): Collection
    {
        return $this->baby->getHistoryForDate($this->filterDate);
    }

    public function mount(Baby $baby)
    {
        $this->baby = $baby;
    }
}; ?>

<div class="container mx-auto">
    <flux:header container>
        <flux:heading size="xl">{{ $this->baby->name  }}</flux:heading>
        <flux:spacer />
        <flux:date-picker
            wire:model.live="filterDate"
            with-today
            placeholder=""
            class="mr-2" />
        <flux:modal.trigger name="edit-profile">
            <flux:button icon="plus">Add</flux:button>
        </flux:modal.trigger>
    </flux:header>

    <div class="flex flex-col md:flex-row space-y-4 md:space-y-0 md:space-x-4">
        <div class="w-full md:w-1/2">
            <flux:card>
                @php
                    $peeCount = $this->history->whereIn('category', ['wet', 'full'])->count();
                    $poopCount = $this->history->whereIn('category', ['dirty', 'full'])->count();
                @endphp
                <div>{{ $peeCount }} {{ Str::of('wet diaper')->plural($peeCount) }}</div>
                <div>{{ $poopCount }} {{ Str::of('dirty diaper')->plural($poopCount) }}</div>
            </flux:card>
        </div>
        <div class="w-full md:w-1/2">
            <flux:card>
                @php
                    // Group bottle feedings by their unit (oz or ml) and sum amounts
                    $bottleFeedings = $this->history->where('category', 'bottle');
                    $bottleConsumptions = $bottleFeedings->groupBy('unit')->map(function($group) {
                        return $group->sum('amount');
                    })->all();
                    $breastfeedingTime = $this->history->where('category', 'breast')->sum('amount');
                @endphp
                @foreach($bottleConsumptions as $unit => $total)
                    <div>Bottles: {{ $total }}{{ $unit }}</div>
                @endforeach
                <div>Breast: {{ $breastfeedingTime }} minutes</div>
            </flux:card>
        </div>
    </div>

    <flux:modal name="edit-profile">
        <flux:tab.group class="max-w-md mx-auto">

            <div class="flex justify-center">
                <flux:tabs wire:model="tab" variant="segmented">
                    <flux:tab name="feedings" class="text-center">Feedings</flux:tab>
                    <flux:tab name="diapers" class="text-center">Diapers</flux:tab>
                </flux:tabs>
            </div>

            <flux:tab.panel name="feedings">
                <livewire:feedings.add :baby="$this->baby" @updated="$refresh" />
            </flux:tab.panel>

            <flux:tab.panel name="diapers">
                <livewire:diapers.add :baby="$this->baby" @updated="$refresh" />
            </flux:tab.panel>
        </flux:tab.group>
    </flux:modal>

    <x-babies.history :history="$this->history" :date="$this->filterDate" />

</div>
