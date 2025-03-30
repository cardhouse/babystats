<?php

use App\Models\Baby;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Baby $baby;

    public ?string $newFeedingCategory = null;
    public ?int $newFeedingAmount = null;
    public ?string $newFeedingUnit = null;
    public ?string $newFeedingSide = null;

    public function mount(Baby $baby)
    {
        $this->authorize('update', $baby);
        $this->baby = $baby;
    }

    public function addFeeding()
    {
        $this->authorize('update', $this->baby);
        
        $this->validate([
            'newFeedingCategory' => 'required|in:breast,bottle',
            'newFeedingAmount' => 'required|int|min:1|max:180',
            'newFeedingUnit' => 'required_if:newFeedingCategory,bottle',
            'newFeedingSide' => 'required_if:newFeedingCategory,breast',
        ]);

        $this->baby->feedings()->create([
            'category' => $this->newFeedingCategory,
            'amount' => $this->newFeedingAmount,
            'unit' => $this->newFeedingUnit ?? 'min',
            'side' => $this->newFeedingSide,
            'date_time' => now(),
        ]);

        $this->newFeedingCategory = null;
        $this->newFeedingAmount = null;
        $this->newFeedingUnit = null;
        $this->newFeedingSide = null;
        $this->newFeedingDuration = null;

        Flux::modals()->close();

        Flux::toast(
            heading: 'Feeding Logged!',
            text: 'Bring on the food coma!',
            variant: 'success'
        );

        $this->dispatch('updated');
    }
    
}; ?>

<flux:container class="flex flex-col md:w-sm justify-center items-center min-h-[300px] h-full space-y-4 text-center">
    <flux:heading size="xl" class="text-blue-500">🍼 Feeding</flux:heading>
    <flux:subheading>Cheers!</flux:subheading>

    <form wire:submit.prevent="addFeeding">
        <flux:select wire:model.live="newFeedingCategory" variant="listbox" placeholder="Feeding Category" class="w-full mt-2">
            <flux:select.option value="breast">Breast</flux:select.option>
            <flux:select.option value="bottle">Bottle</flux:select.option>
        </flux:select>

        <!-- If the type is a bottle, have inputs for the number and measurement (ml, oz) -->
        @if ($this->newFeedingCategory === 'bottle')
            <flux:input.group class="w-full mt-4">
                <flux:input wire:model="newFeedingAmount" type="number" placeholder="Amount" />
                
                <flux:select placeholder="Measurement" inset="top bottom" wire:model="newFeedingUnit" variant="listbox">
                    <flux:select.option>ml</flux:select.option>
                    <flux:select.option>oz</flux:select.option>
                </flux:select>

            </flux:input.group>
            
        @elseif($this->newFeedingCategory === 'breast')
            <flux:radio.group wire:model="newFeedingSide" variant="segmented" class="mt-4">
                    <flux:radio value="left" label="Left" />
                    <flux:radio value="right" label="Right" />
            </flux:radio.group>

            <flux:input.group class="mt-4">
                <flux:input wire:model="newFeedingAmount" type="number" placeholder="Duration" />
                <flux:input.group.suffix>minutes</flux:input.group.suffix>
            </flux:input.group>

        @endif
        
        <flux:button type="submit" variant="primary" class="w-full mt-4">Log Feeding</flux:button>
    </form>
</flux:container>