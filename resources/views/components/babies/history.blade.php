@props(['baby'])

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
                    <!-- Edit dropdown -->
                </flux:table.cell>
                
                <flux:table.cell class="whitespace-nowrap">{{ $item->amount ?? $item->category }}</flux:table.cell>
                <flux:table.cell>{{ $item->unit }}</flux:table.cell>
                <flux:table.cell variant="strong">{{ $item->date_time->timezone('America/New_York')->format("D g:i a") }}</flux:table.cell>
            </flux:table.row>
        @endforeach
    </flux:table.rows>
</flux:table>
