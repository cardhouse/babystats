<?php

use App\Models\Baby;
use Livewire\Volt\Component;

new class extends Component {
    public Baby $baby;
    public int $diaperCount;
    public int $feedingCount;
    public int $sleepCount;

    public function mount(Baby $baby)
    {
        $this->baby = $baby;

        $this->diaperCount = $baby->diapers()->today()->count();

        $this->feedingCount = $baby->feedings()->count();
        $this->sleepCount = $baby->sleeps()->count();
    }
    
}; ?>

@push('header-items')
    <flux:text>{{ $this->baby->name }}</flux:text>
@endpush

<div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
    <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <flux:heading>{{ $this->diaperCount }}</flux:heading>
            <flux:subheading>Dirty diapers today</flux:subheading>
            <flux:modal.trigger name="add-diaper">
                <flux:button iconLeading="plus">New Diaper</flux:button>
            </flux:modal.trigger>

            <flux:modal name="add-diaper" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Dirty Diaper</flux:heading>
                        <flux:subheading>Add record of a dirty diaper</flux:subheading>
                    </div>
                    
                    <flux:select>
                        <flux:select.option checked value="wet">Wet</flux:select.option>
                        <flux:select.option value="dirty">Dirty</flux:select.option>
                        <flux:select.option value="full">Full</flux:select.option>
                    </flux:select>

                    <input type="hidden" id="timezone" name="timezone" value="-04:00" />

                    <flux:input label="Time" type="datetime-local" :value="now()" />

                    <div class="flex">
                        <flux:spacer />

                        <flux:button type="submit" variant="primary">Save changes</flux:button>
                    </div>
                </div>
            </flux:modal>
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
        <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
    <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
    </div>
</div>
