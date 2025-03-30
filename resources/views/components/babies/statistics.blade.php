@props(['history'])

<div class="grid grid-cols-1 gap-4">
    <div class="bg-gradient-to-br from-pink-50 to-pink-100 rounded-lg p-4">
        <h3 class="text-base font-semibold text-pink-600 mb-3">Diaper Stats</h3>
        @php
            $peeCount = $history->whereIn('category', ['wet', 'full'])->count();
            $poopCount = $history->whereIn('category', ['dirty', 'full'])->count();
        @endphp
        <div class="grid grid-cols-2 gap-3">
            <div class="bg-white/50 rounded-lg p-3">
                <span class="text-sm text-gray-600">Wet Diapers</span>
                <div class="text-2xl font-bold text-pink-500 mt-1">{{ $peeCount }}</div>
            </div>
            <div class="bg-white/50 rounded-lg p-3">
                <span class="text-sm text-gray-600">Dirty Diapers</span>
                <div class="text-2xl font-bold text-pink-500 mt-1">{{ $poopCount }}</div>
            </div>
        </div>
    </div>

    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-4">
        <h3 class="text-base font-semibold text-blue-600 mb-3">Feeding Stats</h3>
        @php
            $bottleFeedings = $history->where('category', 'bottle');
            $bottleConsumptions = $bottleFeedings->groupBy('unit')->map(function($group) {
                return $group->sum('amount');
            })->all();
            $breastfeedingTime = $history->where('category', 'breast')->sum('amount');
        @endphp
        <div class="grid gap-3">
            @foreach($bottleConsumptions as $unit => $total)
                <div class="bg-white/50 rounded-lg p-3">
                    <span class="text-sm text-gray-600">Bottles ({{ $unit }})</span>
                    <div class="text-2xl font-bold text-blue-500 mt-1">{{ $total }}</div>
                </div>
            @endforeach
            <div class="bg-white/50 rounded-lg p-3">
                <span class="text-sm text-gray-600">Breastfeeding</span>
                <div class="text-2xl font-bold text-blue-500 mt-1">{{ $breastfeedingTime }} min</div>
            </div>
        </div>
    </div>
</div>