<?php

use App\Models\Baby;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

    public ?string $newFeedingType = null;
    public ?string $newFeedingAmount = null;
    public ?string $newFeedingUnit = null;
    public ?string $newFeedingSide = null;
    public ?string $newFeedingDuration = null;
    
}; ?>

@push('header-items')
    <flux:text class="text-blue-500 font-bold text-2xl">{{ $this->baby->name ?? 'Select a Baby' }}</flux:text>
@endpush

<div class="container mx-auto p-6">
    <h1 class="text-rose-400 font-bold text-2xl text-center mb-6">Baby Name - Stats</h1>

    <flux:tab.group class="max-w-md mx-auto">
        <flux:tabs wire:model="tab" class="flex justify-center">
            <flux:tab name="feedings" class="text-center">Feedings</flux:tab>
            <flux:tab name="diapers" class="text-center">Diapers</flux:tab>
            <flux:tab name="sleep" class="text-center">Sleep</flux:tab>
        </flux:tabs>

        <flux:tab.panel name="feedings">

            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between h-full">
        
                <flux:heading size="xl" class="text-blue-500">🍼 Feeding</flux:heading>
                <flux:subheading>Input feeding info for the little one.</flux:subheading>
        
                <flux:select wire:model.live="newFeedingType" variant="listbox" placeholder="Feeding type" class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600">
                    <flux:select.option>Breast</flux:select.option>
                    <flux:select.option>Bottle</flux:select.option>
                </flux:select>
        
                <!-- If the type is a bottle, have inputs for the number and measurement (ml, oz) -->
                @if ($this->newFeedingType === 'Bottle')
                    <div class="grid grid-cols-2 gap-4">
                        <flux:input wire:model="newFeedingAmount" type="number" placeholder="Amount" class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                        
                        <flux:select inset="top bottom" wire:model="newFeedingUnit" variant="listbox" class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600">
                            <flux:select.option selected>ml</flux:select.option>
                            <flux:select.option>oz</flux:select.option>
                        </flux:select>
                    </div>
                    
                @elseif($this->newFeedingType === 'Breast')
                    <flux:radio.group wire:model.live="newFeedingSide" class="mt-2">
                        <div class="grid grid-cols-2 gap-4">
                            <flux:radio label="Left" />
                            <flux:radio label="Right" />
                        </div>
                    </flux:radio.group>
                    <flux:input.group class="mt-4">
                        <flux:input wire:model="newFeedingDuration" type="number" placeholder="Duration" />
                        <flux:input.group.suffix>minutes</flux:input.group.suffix>
                    </flux:input.group>
                    
                @endif
                
                <button class="mt-4 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">Log Feeding</button>
            </div>
        </flux:tab.panel>
        <flux:tab.panel name="diapers">

            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between h-full">
                <h3 class="text-yellow-500 font-semibold text-xl">🚼 Diapers</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Track diaper changes and trends.</p>
                <select class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600">
                    <option>Wet</option>
                    <option>Dirty</option>
                    <option>Both</option>
                </select>
                <input id="diaper-time" type="datetime-local" class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                <button onclick="toggleAccordion('diaper-accordion')" class="mt-2 text-yellow-500">Change Time</button>
                <div id="diaper-accordion" class="hidden mt-2">
                    <input type="datetime-local" class="w-full p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                </div>
                <button class="mt-4 bg-yellow-500 text-white py-2 px-4 rounded-lg hover:bg-yellow-600">Log Diaper Change</button>
            </div>
        </flux:tab.panel>
        <flux:tab.panel name="sleep">
            <div class="bg-white dark:bg-gray-800 p-6 shadow-lg rounded-xl flex flex-col justify-between h-full">
                <h3 class="text-green-500 font-semibold text-xl">💤 Sleep</h3>
                <p class="mt-2 text-gray-600 dark:text-gray-300">Monitor and analyze sleep patterns.</p>
                <input id="sleep-start-time" type="datetime-local" class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                <input id="sleep-end-time" type="datetime-local" class="w-full mt-2 p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                <button onclick="toggleAccordion('sleep-accordion')" class="mt-2 text-green-500">Change Time</button>
                <div id="sleep-accordion" class="hidden mt-2">
                    <input type="datetime-local" class="w-full p-2 border rounded-md bg-gray-100 dark:bg-gray-700 dark:text-white border-gray-300 dark:border-gray-600" />
                </div>
                <button class="mt-4 bg-green-500 text-white py-2 px-4 rounded-lg hover:bg-green-600">Log Sleep</button>
            </div>
        </flux:tab.panel>
    </flux:tab.group>
    
    <!-- Back to Babies Button -->
    <div class="flex justify-center mt-6">
        <a href="/babies" class="bg-gray-500 text-white py-3 px-6 rounded-lg text-lg shadow-md hover:bg-gray-600">Back to My Babies</a>
    </div>
</div>
