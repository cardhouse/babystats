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
            </flux:tabs>
        </div>

        <flux:tab.panel name="feedings">
            <livewire:feedings.add :baby="$baby" @updated="$refresh" />
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

    <div class="mx-auto max-w-lg max-sm:px-2">
        {{-- Loop: questions... --}}

        <div class="p-3 sm:p-4 rounded-lg">
            <div class="flex flex-row sm:items-center gap-2">
                <flux:avatar src="https://randomuser.me/api/portraits/men/1.jpg" size="xs" class="shrink-0" />

                <div class="flex flex-col gap-0.5 sm:gap-2 sm:flex-row sm:items-center">
                    <div class="flex items-center gap-2">
                        <flux:heading>John Doe</flux:heading>

                        <flux:badge color="lime" size="sm" icon="check-badge" inset="top bottom">Moderator</flux:badge>
                    </div>

                    <flux:text class="text-sm">2 days ago</flux:text>
                </div>
            </div>
        </div>
    </div>

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
                    </flux:table.cell>

                    <flux:table.cell class="whitespace-nowrap">{{ $item->amount }}</flux:table.cell>

                    <flux:table.cell>
                        {{ $item->unit }}
                    </flux:table.cell>

                    <flux:table.cell variant="strong">{{ $item->date_time }}</flux:table.cell>

                </flux:table.row>
            @endforeach
        </flux:table.rows>
    </flux:table>

</div>
