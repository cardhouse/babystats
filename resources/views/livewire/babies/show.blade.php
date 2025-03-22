<?php

use App\Models\Baby;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;

}; ?>

@push('header-items')
    <flux:text class="text-blue-500 font-bold text-2xl">{{ $this->baby->name ?? 'Select a Baby' }}</flux:text>
@endpush

<div class="container mx-auto p-6">
    <flux:tab.group class="max-w-md mx-auto">

        <div class="flex justify-center">
            <flux:tabs wire:model="tab" variant="segmented">
                <flux:tab name="feedings" class="text-center">Feedings</flux:tab>
                <flux:tab name="diapers" class="text-center">Diapers</flux:tab>
                <flux:tab name="sleep" class="text-center">Sleep</flux:tab>
                <flux:tab name="history" class="text-center">History</flux:tab>
            </flux:tabs>
        </div>

        <flux:tab.panel name="feedings">
            <livewire:feedings.add :baby="$baby" @updated="$refresh" />
        </flux:tab.panel>

        <flux:tab.panel name="diapers">
            <livewire:diapers.add :baby="$baby" @updated="$refresh" />
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

        <flux:tab.panel name="history">
        
            <flux:table>
                <flux:table.columns>
                    <flux:table.column>Type</flux:table.column>
                    <flux:table.column>Amount</flux:table.column>
                    <flux:table.column>Unit</flux:table.column>
                    <flux:table.column>DateTime</flux:table.column>
                </flux:table.columns>
        
                <flux:table.rows>
                    @foreach ($this->baby->history as $item)
                        <flux:table.row :key="$item->id">
                            <flux:table.cell class="flex items-center gap-3">
                                {{ $item->type }}
                                @if ($item->category === 'breast')
                                    <flux:badge color="{{ $item->side == 'left' ? 'green' : 'fuchsia' }}">{{ $item->side }}</flux:badge>
                                @endif  
                            </flux:table.cell>
        
                            <flux:table.cell class="whitespace-nowrap">{{ $item->amount ?? $item->category }}</flux:table.cell>
        
                            <flux:table.cell>
                                {{ $item->unit }}
                            </flux:table.cell>
        
                            <flux:table.cell variant="strong">{{ $item->date_time->timezone('America/New_York')->toDayDateTimeString() }}</flux:table.cell>
        
                        </flux:table.row>
                    @endforeach
                </flux:table.rows>
            </flux:table>
        </flux:tab.panel>
    </flux:tab.group>

    

</div>
