<?php

use App\Models\Baby;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public Baby $baby;

    public ?string $newDiaperCategory = null;

    public function mount(Baby $baby)
    {
        $this->authorize('update', $baby);
        $this->baby = $baby;
    }

    public function addDiaper()
    {
        $this->authorize('update', $this->baby);
        
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

<flux:container class="flex flex-col md:w-sm justify-center items-center h-full space-y-4 text-center">
    <flux:heading size="xl" class="text-yellow-500">💩 Diapers</flux:heading>
    <flux:subheading class="text-gray-600 dark:text-gray-300">Everybody poops.</flux:subheading>

    <form wire:submit.prevent="addDiaper" class="space-y-4 w-full">
        <flux:select wire:model="newDiaperCategory" variant="listbox" placeholder="How bad was it?" class="w-full">
            <flux:select.option value="wet">Wet</flux:select.option>
            <flux:select.option value="dirty">Dirty</flux:select.option>
            <flux:select.option value="full">Both</flux:select.option>
        </flux:select>
        <flux:button type="submit" variant="primary" class="w-full">Log Diaper</flux:button>
    </form>
</flux:container>
