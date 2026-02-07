<div>

    <!-- New spend -->
    <form wire:submit="save">
        <div>
            <label>Dátum</label>
            <br>
            <input type="date" wire:model="date">
            @error('date') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Názov</label>
            <br>
            <input type="text" wire:model="title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Suma</label>
            <br>
            <input type="number" inputmode="decimal" step="0.01" min="0" placeholder="0.00" wire:model="amount">
            @error('amount') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Kategória</label>
            <br>
            <select wire:model="category_id">
                <option>Select</option>
                @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button type="submit">Uložiť</button>
    </form>

    <!-- Budget -->
    <div style="margin-top: 30px">
        @foreach($items as $category)
        <div>
            {{ $category->title }}: {{ $category->totalSpended }} - {{ $category->budget ?? 0 }} - {{ $category->remainingAmount }}
        </div>
        <hr>
        @endforeach
    </div>

    <!-- Spendings -->
    <table style="margin-top: 30px">
        <thead>
            <tr>
                <th>Dátum</th>
                <th>Názov</th>
                <th>Suma</th>
                <th>Kategória</th>
            </tr>
        </thead>
        <tbody>
        @foreach($spends as $spend)
            <tr>
                <td>{{ $spend->date->format('d.m.Y') }}</td>
                <td>{{ $spend->title }}</td>
                <td style="text-align: right">{{ formatCurrency($spend->amount) }}</td>
                <td>{{ $spend->category->title }}</td>
            </tr>
        @endforeach
        </tbody>
    </div>

</table>
