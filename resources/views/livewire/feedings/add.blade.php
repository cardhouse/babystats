<?php

use App\Models\Baby;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

    public ?string $newFeedingType = null;
    public ?int $newFeedingAmount = null;
    public ?string $newFeedingUnit = null;
    public ?string $newFeedingSide = null;

    public function mount(Baby $baby)
    {
        $this->baby = $baby;
    }

    public function addFeeding()
    {
        $this->validate([
            'newFeedingType' => 'required|in:breast,bottle',
            'newFeedingAmount' => 'required|int|min:1|max:60',
            'newFeedingUnit' => 'required_if:newFeedingType,bottle',
            'newFeedingSide' => 'required_if:newFeedingType,breast',
        ]);

        $this->baby->feedings()->create([
            'type' => $this->newFeedingType,
            'amount' => $this->newFeedingAmount,
            'unit' => $this->newFeedingUnit ?? 'min',
            'side' => $this->newFeedingSide,
            'date_time' => now(),
        ]);

        $this->newFeedingType = null;
        $this->newFeedingAmount = null;
        $this->newFeedingUnit = null;
        $this->newFeedingSide = null;
        $this->newFeedingDuration = null;

        $this->dispatch('updated');
    }
    
}; ?>

<flux:card class="bg-white dark:bg-gray-800 shadow-lg rounded-xl flex flex-col justify-between h-full"> 
    <flux:heading size="xl" class="text-blue-500">🍼 Feeding</flux:heading>
    <flux:subheading>Input feeding info for the little one.</flux:subheading>

    <form wire:submit.prevent="addFeeding">
        <!-- Select the type of feeding -->
        <flux:label class="mt-4">Feeding Type</flux:label>
        <flux:select wire:model.live="newFeedingType" variant="listbox" placeholder="Feeding type" class="w-full mt-2">
            <flux:select.option value="breast">Breast</flux:select.option>
            <flux:select.option value="bottle">Bottle</flux:select.option>
        </flux:select>

        <!-- If the type is a bottle, have inputs for the number and measurement (ml, oz) -->
        @if ($this->newFeedingType === 'bottle')
            
                <flux:input.group class="w-full mt-4">
                    <flux:input wire:model="newFeedingAmount" type="number" placeholder="Amount" />
                    
                    <flux:select inset="top bottom" wire:model="newFeedingUnit" variant="listbox">
                        <flux:select.option selected>ml</flux:select.option>
                        <flux:select.option>oz</flux:select.option>
                    </flux:select>
                </flux:input.group>
            
        @elseif($this->newFeedingType === 'breast')
            <flux:radio.group wire:model="newFeedingSide" variant="segmented" class="mt-4">
                    <flux:radio value="left" label="Left" />
                    <flux:radio value="right" label="Right" />
            </flux:radio.group>
            <flux:input.group class="mt-4">
                <flux:input wire:model="newFeedingAmount" type="number" placeholder="Duration" />
                <flux:input.group.suffix>minutes</flux:input.group.suffix>
            </flux:input.group>
            
        @endif
        
        <flux:button type="submit" class="w-full mt-4">Log Feeding</flux:button>
    </form>
</flux:card>