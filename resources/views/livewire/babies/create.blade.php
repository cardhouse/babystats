<?php

use Livewire\Volt\Component;

new class extends Component {
    public $newName;

    public $newSex;

    public $newBirthDate;

    public function createBaby()
    {
        $this->validate([
            'newName' => 'required|string|max:255',
            'newBirthDate' => 'required|date',
        ]);

        auth()->user()->babies()->create([
            'name' => $this->newName,
            'birth_date' => $this->newBirthDate,
        ]);

        // Redirect to the babies index page
        return $this->redirect(route('dashboard'), navigate: true);
    }
}; ?>

<div>
    <flux:card class="flex flex-col gap-4 max-w-2xl">
        <flux:heading>Declare the birth of a baby to start your journey.</flux:heading>
        <flux:input label="Baby's name" type="text" wire:model='newName'></flux:input>
        <flux:date-picker wire:model='newBirthDate' label="Baby's birth date" />
        <flux:button wire:click="createBaby" variant="primary" class="w-full">
            {{ __('Save') }}
        </flux:button>
    </flux:card>
</div>
