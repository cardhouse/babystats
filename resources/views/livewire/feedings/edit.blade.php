<?php

use App\Models\Feeding;
use Livewire\Volt\Component;

new class extends Component {
    public Feeding $feeding;

    public ?string $editFeedingCategory = null;
    public ?int $editFeedingAmount = null;
    public ?string $editFeedingUnit = null;
    public ?string $editFeedingSide = null;
    public ?string $editFeedingDateTime = null;

    public function mount(Feeding $feeding)
    {
        $this->authorize('update', $feeding->baby);
        $this->feeding = $feeding;
        $this->editFeedingCategory = $feeding->category;
        $this->editFeedingAmount = $feeding->amount;
        $this->editFeedingUnit = $feeding->unit;
        $this->editFeedingSide = $feeding->side;
        $this->editFeedingDateTime = $feeding->date_time->format('Y-m-d\TH:i');
    }

    public function updateFeeding()
    {
        $this->authorize('update', $this->feeding->baby);
        
        $this->validate([
            'editFeedingCategory' => 'required|in:breast,bottle',
            'editFeedingAmount' => 'required|int|min:1|max:180',
            'editFeedingUnit' => 'required_if:editFeedingCategory,bottle',
            'editFeedingSide' => 'required_if:editFeedingCategory,breast',
            'editFeedingDateTime' => 'required|date',
        ]);

        $this->feeding->update([
            'category' => $this->editFeedingCategory,
            'amount' => $this->editFeedingAmount,
            'unit' => $this->editFeedingUnit ?? 'min',
            'side' => $this->editFeedingSide,
            'date_time' => $this->editFeedingDateTime,
        ]);

        Flux::modals()->close();

        Flux::toast(
            heading: 'Feeding Updated!',
            text: 'Changes saved successfully.',
            variant: 'success'
        );

        $this->dispatch('updated');
    }
}; ?>

<flux:container class="flex flex-col md:w-sm justify-center items-center h-full space-y-4 text-center">
    <flux:heading size="xl" class="text-blue-500">🍼 Edit Feeding</flux:heading>

    <form wire:submit.prevent="updateFeeding" class="w-full">
        <flux:select wire:model.live="editFeedingCategory" variant="listbox" placeholder="Feeding Category" class="w-full mt-2">
            <flux:select.option value="breast">Breast</flux:select.option>
            <flux:select.option value="bottle">Bottle</flux:select.option>
        </flux:select>

        <!-- If the type is a bottle, have inputs for the number and measurement (ml, oz) -->
        @if ($this->editFeedingCategory === 'bottle')
            <flux:input.group class="w-full mt-4">
                <flux:input wire:model="editFeedingAmount" type="number" placeholder="Amount" />
                
                <flux:select placeholder="Measurement" inset="top bottom" wire:model="editFeedingUnit" variant="listbox">
                    <flux:select.option>ml</flux:select.option>
                    <flux:select.option>oz</flux:select.option>
                </flux:select>
            </flux:input.group>
            
        @elseif($this->editFeedingCategory === 'breast')
            <flux:radio.group wire:model="editFeedingSide" variant="segmented" class="mt-4">
                <flux:radio value="left" label="Left" />
                <flux:radio value="right" label="Right" />
            </flux:radio.group>

            <flux:input.group class="mt-4">
                <flux:input wire:model="editFeedingAmount" type="number" placeholder="Duration" />
                <flux:input.group.suffix>minutes</flux:input.group.suffix>
            </flux:input.group>
        @endif

        <flux:input type="datetime-local" wire:model="editFeedingDateTime" class="w-full mt-4" />
        
        <flux:button type="submit" variant="primary" class="w-full mt-4">Update Feeding</flux:button>
    </form>
</flux:container> 