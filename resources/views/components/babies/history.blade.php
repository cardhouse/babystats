@props(['history'])

<ul role="list" class="divide-y divide-gray-100">
    @foreach ($history as $item)
        <li class="flex items-center justify-between gap-x-6 py-5">
            <div class="min-w-0">
                <div class="flex items-start gap-x-3">
                    @if($item->type === 'feeding')
                        <p class="text-sm/6 font-semibold text-gray-900">Feeding</p>
                        <p @class([
                            'mt-0.5 rounded-md px-1.5 py-0.5 text-xs font-medium whitespace-nowrap ring-1 ring-inset',
                            'bg-pink-50 text-pink-700 ring-pink-600/20' => $item->category === 'breast',
                            'bg-blue-50 text-blue-700 ring-blue-600/20' => $item->category === 'bottle',
                        ])>{{ ucfirst($item->category) }}</p>
                        @if($item->category === 'breast')
                            <p @class([
                                'mt-0.5 rounded-md px-1.5 py-0.5 text-xs font-medium whitespace-nowrap ring-1 ring-inset',
                                'bg-green-50 text-green-700 ring-green-600/20' => $item->side === 'left',
                                'bg-fuchsia-50 text-fuchsia-700 ring-fuchsia-600/20' => $item->side === 'right',
                                'bg-purple-50 text-purple-700 ring-purple-600/20' => $item->side === 'both',
                            ])>{{ ucfirst($item->side) }}</p>
                        @endif
                    @elseif($item->type === 'diaper')
                        <p class="text-sm/6 font-semibold text-gray-900">Diaper</p>
                        <p @class([
                            'mt-0.5 rounded-md px-1.5 py-0.5 text-xs font-medium whitespace-nowrap ring-1 ring-inset',
                            'bg-blue-50 text-blue-700 ring-blue-600/20' => $item->category === 'wet',
                            'bg-amber-50 text-amber-700 ring-amber-600/20' => $item->category === 'dirty',
                            'bg-orange-50 text-orange-700 ring-orange-600/20' => $item->category === 'full',
                        ])>{{ ucfirst($item->category) }}</p>
                    @endif
                </div>
                <div class="mt-1 flex items-center gap-x-2 text-xs/5 text-gray-500">
                    <p class="whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($item->date_time)->timezone('America/New_York')->format("g:i a") }}
                    </p>
                    @if($item->amount)
                        <svg viewBox="0 0 2 2" class="size-0.5 fill-current">
                            <circle cx="1" cy="1" r="1" />
                        </svg>
                        <p class="truncate">{{ $item->amount }} {{ $item->unit }}</p>
                    @endif
                </div>
            </div>
            <div class="flex flex-none items-center gap-x-4">
                <div class="relative flex-none">
                    <button type="button" class="-m-2.5 block p-2.5 text-gray-500 hover:text-gray-900" id="options-menu-{{ $loop->index }}-button" aria-expanded="false" aria-haspopup="true">
                        <span class="sr-only">Open options</span>
                        <svg class="size-5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path d="M10 3a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM10 8.5a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM11.5 15.5a1.5 1.5 0 1 0-3 0 1.5 1.5 0 0 0 3 0Z" />
                        </svg>
                    </button>

                    <div x-data="{ open: false }" x-show="open" @click.away="open = false" class="absolute right-0 z-10 mt-2 w-32 origin-top-right rounded-md bg-white py-2 ring-1 shadow-lg ring-gray-900/5 focus:outline-hidden" role="menu" aria-orientation="vertical" aria-labelledby="options-menu-{{ $loop->index }}-button" tabindex="-1">
                        <a href="#" class="block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="options-menu-{{ $loop->index }}-item-0">Edit</a>
                        <a href="#" class="block px-3 py-1 text-sm/6 text-gray-900" role="menuitem" tabindex="-1" id="options-menu-{{ $loop->index }}-item-1">Delete</a>
                    </div>
                </div>
            </div>
        </li>
    @endforeach

    @if($history->isEmpty())
        <li class="py-8">
            <p class="text-center text-sm text-gray-500">No items recorded for this date</p>
        </li>
    @endif
</ul>
