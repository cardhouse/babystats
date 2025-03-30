@props(['history'])

@php
    $peeCount = $history->whereIn('category', ['wet', 'full'])->count();
    $poopCount = $history->whereIn('category', ['dirty', 'full'])->count();
    $breastfeedingTime = $history->where('category', 'breast')->sum('amount');
    $bottleFeedings = $history->where('category', 'bottle');
    $bottleConsumptions = $bottleFeedings->groupBy('unit')->map(function($group) {
        return $group->sum('amount');
    })->filter()->all();
@endphp

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 divide-y divide-gray-200 sm:divide-y-0 bg-gray-50">
    <div class="px-6 py-5 text-center sm:border-r border-gray-200">
        <span class="block text-gray-900 text-lg font-semibold">{{ $peeCount }}</span>
        <span class="block text-gray-600 text-sm">{{ Str::of('wet diaper')->plural($peeCount) }}</span>
    </div>
    <div class="px-6 py-5 text-center sm:border-r border-gray-200">
        <span class="block text-gray-900 text-lg font-semibold">{{ $poopCount }}</span>
        <span class="block text-gray-600 text-sm">{{ Str::of('dirty diaper')->plural($poopCount) }}</span>
    </div>
    @foreach($bottleConsumptions as $unit => $total)
        <div class="px-6 py-5 text-center sm:border-r border-gray-200">
            <span class="block text-gray-900 text-lg font-semibold">{{ $total }}{{ $unit }}</span>
            <span class="block text-gray-600 text-sm">Bottle</span>
        </div>
    @endforeach
    <div class="px-6 py-5 text-center">
        <span class="block text-gray-900 text-lg font-semibold">{{ $breastfeedingTime }} {{ Str::of('minute')->plural($breastfeedingTime) }}</span>
        <span class="block text-gray-600 text-sm">Breastfeeding</span>
    </div>
</div>
