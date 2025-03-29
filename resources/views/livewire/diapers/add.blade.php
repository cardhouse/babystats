<?php

use App\Models\Baby;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

    public ?string $newDiaperCategory = null;

    public function mount(Baby $baby)
    {
        $this->baby = $baby;
    }

    public function addDiaper()
    {
        $this->validate([
            'newDiaperCategory' => 'required|in:wet,dirty,full',
        ]);

        $this->baby->diapers()->create([
            'category' => $this->newDiaperCategory,
            'date_time' => now(),
        ]);

        $this->newDiaperCategory = null;

        Flux::modals()->close();

        Flux::toast(heading: 'Diaper Logged!', text: 'How many more could there possibly be?', variant: 'success');

        $this->dispatch('updated');
    }
}; ?>

<div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl flex flex-col justify-between h-full">
    <flux:heading size="xl" class="text-yellow-500">💩 Diapers</flux:heading>
    <flux:subheading>Everybody poops.</flux:subheading>

    <form wire:submit.prevent="addDiaper">
        <flux:select wire:model="newDiaperCategory" variant="listbox" placeholder="How bad was it?" class="mt-2">
            <flux:select.option value="wet">Wet</flux:select.option>
            <flux:select.option value="dirty">Dirty</flux:select.option>
            <flux:select.option value="full">Both</flux:select.option>
        </flux:select>
        <flux:button type="submit" variant="primary" class="mt-4">Log Diaper</flux:button>
    </form>
</div>
