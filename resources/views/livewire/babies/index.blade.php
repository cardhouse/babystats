<?php

use Livewire\Volt\Component;

new class extends Component {
    public function mount()
    {
        $this->babies = auth()->user()->babies;
    }
}; ?>

<div>
    @foreach ($this->babies as $baby)
        <flux:link :href="route('babies.show', $baby)" wire:key="baby-{{ $baby->id }}">
            <flux:card class="mb-4">
                <flux:heading>{{ $baby->name }}</flux:heading>
                <flux:subheading>{{ $baby->birth_date->diffForHumans() }}</flux:subheading>
            </flux:card>
        </flux:link>
    @endforeach
</div>
