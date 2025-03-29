<?php

use App\Models\Baby;
use Livewire\Attributes\Reactive;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

    // Listen for the updated event to refresh the component
    protected $listeners = ['updated' => '$refresh'];
}; ?>

@push('header-items')
    <flux:text class="text-blue-500 font-bold text-2xl">{{ $this->baby->name ?? 'Select a Baby' }}</flux:text>
@endpush

<div class="container mx-auto">

    <flux:modal.trigger name="edit-profile">
        <flux:button>Edit profile</flux:button>
    </flux:modal.trigger>

    <flux:modal name="edit-profile" variant="flyout">
        <flux:tab.group class="max-w-md mx-auto">

            <div class="flex justify-center">
                <flux:tabs wire:model="tab" variant="segmented">
                    <flux:tab name="feedings" class="text-center">Feedings</flux:tab>
                    <flux:tab name="diapers" class="text-center">Diapers</flux:tab>
                </flux:tabs>
            </div>

            <flux:tab.panel name="feedings">
                <livewire:feedings.add :baby="$this->baby" @updated="$refresh" />
            </flux:tab.panel>

            <flux:tab.panel name="diapers">
                <livewire:diapers.add :baby="$this->baby" @updated="$refresh" />
            </flux:tab.panel>
        </flux:tab.group>
    </flux:modal>

    <x-babies.history :baby="$this->baby" />


</div>
