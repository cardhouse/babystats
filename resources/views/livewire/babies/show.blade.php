<?php

use App\Models\Baby;
use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

    public ?string $filterDate = null;

    // Listen for the updated event to refresh the component
    protected $listeners = ['updated' => '$refresh'];
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
    <flux:card>
        @php
            $history = collect($this->baby->getHistoryForDate($this->filterDate));
            $peeCount = $history->whereIn('category', ['wet', 'full'])->count();
            $poopCount = $history->whereIn('category', ['dirty', 'full'])->count();
        @endphp
        <div>Pee Count: {{ $peeCount }}</div>
        <div>Poop Count: {{ $poopCount }}</div>
    </flux:card>

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

    <x-babies.history :history="$this->baby->getHistoryForDate($this->filterDate)" :date="$this->filterDate" />


</div>
