<?php

use App\Models\Diaper;
use Livewire\Volt\Component;

new class extends Component {
    public Diaper $diaper;

    public ?string $editDiaperCategory = null;
    public ?string $editDiaperDateTime = null;

    public function mount(Diaper $diaper)
    {
        $this->authorize('update', $diaper->baby);
        $this->diaper = $diaper;
        $this->editDiaperCategory = $diaper->category;
        $this->editDiaperDateTime = $diaper->date_time->format('Y-m-d\TH:i');
    }

    public function updateDiaper()
    {
        $this->authorize('update', $this->diaper->baby);
        
        $this->validate([
            'editDiaperCategory' => 'required|in:wet,dirty,full',
            'editDiaperDateTime' => 'required|date',
        ]);

        $this->diaper->update([
            'category' => $this->editDiaperCategory,
            'date_time' => $this->editDiaperDateTime,
        ]);

        Flux::modals()->close();

        Flux::toast(
            heading: 'Diaper Updated!',
            text: 'Changes saved successfully.',
            variant: 'success'
        );

        $this->dispatch('updated');
    }
}; ?>

<flux:container class="flex flex-col md:w-sm justify-center items-center h-full space-y-4 text-center">
    <flux:heading size="xl" class="text-yellow-500">💩 Edit Diaper</flux:heading>

    <form wire:submit.prevent="updateDiaper" class="w-full">
        <flux:select wire:model="editDiaperCategory" variant="listbox" placeholder="How bad was it?" class="w-full">
            <flux:select.option value="wet">Wet</flux:select.option>
            <flux:select.option value="dirty">Dirty</flux:select.option>
            <flux:select.option value="full">Both</flux:select.option>
        </flux:select>

        <flux:input type="datetime-local" wire:model="editDiaperDateTime" class="w-full mt-4" />
        
        <flux:button type="submit" variant="primary" class="w-full mt-4">Update Diaper</flux:button>
    </form>
</flux:container> 