<div>
    <div class="row">
        <div class="col">
            <div class="d-none d-lg-block mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <livewire:components.bible-verse :month="$month" />
                    <div class="input-group input-group-lg w-auto">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-calendar-month"></i>
                        </span>
                        <select wire:model.live="month" class="form-select">
                            <option value="2026-01">Január 2026</option>
                            <option value="2026-02">Február 2026</option>
                            <option value="2026-03">Marec 2026</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">

            <!-- FORM -->
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
        </div>
        <div class="col-lg-4">
            <div class="bg-white p-4 mb-4">
                <div class="vstack gap-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary text-nowrap m-0">Dnes</h4>
                    </div>
                    @if($spends->isEmpty())
                    <div class="alert alert-light m-0" role="alert">
                        Zatiaľ žiadne výdavky
                    </div>
                    @endif
                    @if($spends->isNotEmpty())
                        @foreach($spends as $date => $itemsByDate)
                        <table class="table align-middle table-sm table-hover m-0">
                            <thead class="">
                                <tr>
                                    <th>{{ humanDate($date) }}</th>
                                    <th class="text-end text-nowrap">{{ formatCurrency($itemsByDate->sum('amount')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itemsByDate as $spend)
                                <tr>
                                    <td>
                                        <div class="d-flex gap-2">
                                            @if($spend->is_discretionary)
                                            <i class="bi bi-emoji-astonished-fill text-secondary"></i>
                                            @endif
                                            <span>{{ $spend->title }}</span>
                                        </div>
                                        <span class="text-muted text-sm">{{ $spend->category->title }}</span>
                                    </td>
                                    <td class="text-end text-nowrap">
                                        {{ formatCurrency($spend->amount) }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-lg-4">

            <!-- OVERVIEW -->
            <livewire:components.month-overview />

        </div>
    </div>
</div>
