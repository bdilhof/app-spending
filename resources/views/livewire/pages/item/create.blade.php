<div>
    <form wire:submit="save">
        <div>
            <label>Dátum</label>
            <input type="date" wire:model="date">
            @error('date') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Názov</label>
            <input type="text" wire:model="title">
            @error('title') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Suma</label>
            <input type="number" inputmode="decimal" step="0.01" min="0" placeholder="0.00" wire:model="amount">
            @error('amount') <span class="error">{{ $message }}</span> @enderror
        </div>
        <div>
            <label>Kategória</label>
            <select wire:model="category_id">
                <option>Select</option>
                @foreach($items as $item)
                <option value="{{ $item->id }}">{{ $item->title }}</option>
                @endforeach
            </select>
            @error('category_id') <span class="error">{{ $message }}</span> @enderror
        </div>
        <button type="submit">Save</button>
    </form>

</div>
