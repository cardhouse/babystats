<div class="md:flex md:space-x-4">
    <flux:card class="flex-1">
        @php
            $peeCount = $history->whereIn('category', ['wet', 'full'])->count();
            $poopCount = $history->whereIn('category', ['dirty', 'full'])->count();
        @endphp
        <div>{{ $peeCount }} {{ Str::of('wet diaper')->plural($peeCount) }}</div>
        <div>{{ $poopCount }} {{ Str::of('dirty diaper')->plural($poopCount) }}</div>
    </flux:card>

    <flux:card class="flex-1">
        @php
            $bottleFeedings = $history->where('category', 'bottle');
            $bottleConsumptions = $bottleFeedings->groupBy('unit')->map(function($group) {
                return $group->sum('amount');
            })->all();
            $breastfeedingTime = $history->where('category', 'breast')->sum('amount');
        @endphp
        @foreach($bottleConsumptions as $unit => $total)
            <div>Bottles: {{ $total }} {{ $unit }}</div>
        @endforeach
        <div>Breast: {{ $breastfeedingTime }} minutes</div>
    </flux:card>
</div>