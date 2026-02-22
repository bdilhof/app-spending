<div class="bg-white p-4 mb-4">
    <div class="vstack gap-4">
        <h4 class="text-primary m-0">Nový výdavok</h4>
        <form wire:submit="save" class="vstack gap-2" id="addSpendForm" x-data="{ isDiscretionary: @entangle('form.is_discretionary') }">
            <div class="input-group has-validation">
                <input type="number" inputmode="decimal" wire:model="form.amount" class="form-control form-control-lg {{ $errors->has('form.amount') ? 'is-invalid' : '' }}" step="0.01" placeholder="Suma" wire:loading.attr="disabled" wire:target="save">
                <span class="input-group-text" id="basic-addon1">EUR</span>
                @error('form.amount')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <select wire:model="form.category_id" class="form-select form-select-lg {{ $errors->has('form.category_id') ? 'is-invalid' : '' }}" wire:loading.attr="disabled" wire:target="save">
                    <option value="">Kategória</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->title }}</option>
                    @endforeach
                </select>
                @error('form.category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="text" wire:model="form.title" class="form-control form-control-lg {{ $errors->has('form.title') ? 'is-invalid' : '' }}" placeholder="Názov" wire:loading.attr="disabled" wire:target="save">
                @error('form.title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <input type="date" wire:model="form.date" class="form-control form-control-lg {{ $errors->has('form.date') ? 'is-invalid' : '' }}" wire:loading.attr="disabled" wire:target="save">
                @error('form.date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-check m-0">
                <input class="form-check-input" wire:model="form.is_discretionary" id="is_discretionary" type="checkbox" wire:loading.attr="disabled" wire:target="save">
                <label class="form-check-label" for="is_discretionary">Márnosť</label>
            </div>
            <template x-if="isDiscretionary">
                <p class="m-0">Bolo to naozaj potrebné?</p>
            </template>
        </form>
        <button type="submit" class="btn btn-success" form="addSpendForm" wire:loading.attr="disabled">
            <span wire:loading.remove wire:loading.target="save">Uložiť</span>
            <div class="spinner-border spinner-border-sm" role="status" wire:loading wire:loading.target="save">
                <span class="visually-hidden">Loading...</span>
            </div>
        </button>
    </div>
</div>
