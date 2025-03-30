@props(['history'])

<div class="space-y-3">
    @foreach ($history as $item)
        <div class="bg-white rounded-lg border border-pink-100 hover:border-pink-200 transition-colors">
            <div class="p-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="flex items-center gap-2 min-w-0">
                        @if($item->type === 'feeding')
                            <div class="bg-pink-50 p-1.5 rounded-lg shrink-0">
                                <flux:icon name="heart" class="w-4 h-4 text-pink-400" />
                            </div>
                        @elseif($item->type === 'diaper')
                            <div class="bg-yellow-50 p-1.5 rounded-lg shrink-0">
                                <flux:icon name="star" class="w-4 h-4 text-yellow-400" />
                            </div>
                        @else
                            <div class="bg-blue-50 p-1.5 rounded-lg shrink-0">
                                <flux:icon name="moon" class="w-4 h-4 text-blue-400" />
                            </div>
                        @endif
                        <div class="min-w-0">
                            <div class="flex items-center gap-1.5 flex-wrap">
                                <span class="font-medium text-gray-900 text-sm">{{ ucfirst($item->type) }}</span>
                                @if ($item->category)
                                    <flux:badge class="text-xs bg-pink-100 text-pink-700">{{ $item->category }}</flux:badge>
                                @endif
                                @if ($item->category === 'breast')
                                    <flux:badge color="{{ $item->side == 'left' ? 'green' : 'fuchsia' }}" class="text-xs bg-opacity-20">{{ $item->side }}</flux:badge>
                                @endif
                            </div>
                            @if($item->amount || $item->unit)
                                <div class="text-sm text-gray-600 mt-0.5">
                                    @if($item->amount)
                                        <span class="font-medium">{{ $item->amount }}</span>
                                    @endif
                                    @if($item->unit)
                                        <span>{{ $item->unit }}</span>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="text-xs text-gray-500 shrink-0">
                        {{ \Carbon\Carbon::parse($item->date_time)->timezone('America/New_York')->format("g:i a") }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    @if($history->isEmpty())
        <div class="text-center py-8">
            <p class="text-gray-500">No items recorded for this date</p>
        </div>
    @endif
</div>
