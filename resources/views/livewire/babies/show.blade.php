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
        <flux:heading size="xl">{{ $this->baby->name }}</flux:heading>
        <flux:spacer />
        <flux:date-picker wire:model.live="filterDate" with-today placeholder="" class="mr-2" />
        <flux:dropdown>
            <flux:button icon:trailing="plus">Add</flux:button>
            <flux:menu>
                <flux:modal.trigger name="new-diaper" class="w-full">
                    <flux:menu.item>New Diaper</flux:menu.item>
                </flux:modal.trigger>
                <flux:modal.trigger name="new-feeding" class="w-full">
                    <flux:menu.item>New Feeding</flux:menu.item>
                </flux:modal.trigger>
            </flux:menu>
        </flux:dropdown>
        
    </flux:header>

    <flux:modal name="new-diaper" title="New Diaper" size="lg">
        <livewire:diapers.add :baby="$this->baby" @updated="$refresh" />
    </flux:modal>

    <flux:modal name="new-feeding" title="New Feeding" size="lg">
        <livewire:feedings.add :baby="$this->baby" @updated="$refresh" />
    </flux:modal>
            
    <x-babies.statistics :history="$this->history" />
    <x-babies.history :history="$this->history" :date="$this->filterDate" />

</div>
