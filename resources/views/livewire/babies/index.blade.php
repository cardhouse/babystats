<?php

use Livewire\Volt\Component;

new class extends Component {
    public $babies;

    public $newName;

    public $newSex;

    public $newBirthDate;

    public function mount()
    {
        $this->babies = auth()->user()->babies;
    }

    public function createBaby()
    {
        $this->validate([
            'newName' => 'required|string|max:255',
            'newSex' => 'required|in:m,f',
            'newBirthDate' => 'required|date',
        ]);

        auth()->user()->babies()->create([
            'name' => $this->newName,
            'sex' => $this->newSex,
            'birth_date' => $this->newBirthDate,
        ]);
        $this->babies = auth()->user()->babies;
        $this->newName = null;
        $this->newSex = null;
        $this->newBirthDate = null;
    }
}; ?>

<div>
    @forelse ($this->babies as $baby)
        <flux:card class="mb-4" wire:key="baby-{{ $baby->id }}" wire:navigate="{{ route('babies.show', $baby) }}">
            <flux:heading>{{ $baby->name }}</flux:heading>
            <flux:subheading>{{ $baby->birth_date->diffForHumans() }}</flux:subheading>
        </flux:card>
    @empty
    @endforelse
    <flux:card class="flex flex-col gap-4 max-w-2xl">
        <flux:heading>Declare the birth of a baby to start your journey.</flux:heading>
        <flux:input label="Baby's name" type="text" wire:model='newName'></flux:input>
        <flux:select wire:model='newSex' label="Sex">
            <flux:select.option label="Male" value="m">m</flux:select.option>
            <flux:select.option label="Female" value="f">f</flux:select.option>
        </flux:select>
        <flux:date-picker wire:model='newBirthDate' label="Baby's birth date" />
        <flux:button wire:click="createBaby" variant="primary" class="w-full">
            {{ __('Save') }}
        </flux:button>
    </flux:card>
</div>
