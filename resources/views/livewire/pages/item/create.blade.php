<div>
    <form wire:submit="save">
        <div>
            <label>Dátum</label>
            <input type="date" wire:model="date">
        </div>
        <div>
            <label>Názov</label>
            <input type="text" wire:model="title">
        </div>
        <div>
            <label>Suma</label>
            <input type="number" wire:model="amount">
        </div>
        <div>
            <label>Kategória</label>
            <input type="text" wire:model="category_id">
        </div>
        <button type="submit">Save</button>
    </form>

</div>
