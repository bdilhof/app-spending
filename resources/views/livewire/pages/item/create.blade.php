<div class="container-fluid p-4">
    <div class="row">
        <div class="col">
            <div class="d-none d-lg-block mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <figure class="mb-0">
                        <blockquote class="blockquote m-0">
                            <p>{{ $verse['verse'] }}</p>
                        </blockquote>
                        <figcaption class="blockquote-footer m-0">
                            <cite>{{ $verse['reference'] }}</cite>
                        </figcaption>
                    </figure>
                    <div class="input-group w-auto">
                        <span class="input-group-text" id="basic-addon1">
                            <i class="bi bi-calendar-month"></i>
                        </span>
                        <select wire:model.live="month" class="form-select">
                            <option value="2026-01">Január 2026</option>
                            <option value="2026-02">Február 2026</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-lg-3 order-lg-3">

            <!-- FORM -->
            <div class="bg-white p-4 mb-4">
                <div class="vstack gap-4">
                    <h4 class="text-primary m-0">Nový výdavok</h4>
                    <form wire:submit="save" class="vstack gap-2" id="addSpendForm">
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
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->title }}</option>
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
                    </form>
                    <button type="submit" class="btn btn-success" form="addSpendForm" wire:loading.attr="disabled">
                        <span wire:loading.remove>Uložiť</span>
                        <div class="spinner-border spinner-border-sm" role="status" wire:loading>
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- OVERVIEW -->
            <div class="bg-white p-4 mb-4">
                <div class="vstack gap-4">
                    <h4 class="text-primary m-0">Tento mesiac</h4>
                    <div>
                        <p class="m-0">Výdavky celkom: <b>{{ formatCurrency($this->spends->flatten()->sum('amount')) }}</b></p>
                        <p class="m-0">Márnosti: <b>{{ formatCurrency($this->spends->flatten()->where('is_discretionary', true)->sum('amount')) }}</b></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- VÝDAVKY -->
        <div class="col-lg-4 order-lg-2">
            <div class="bg-white p-4 mb-4">
                <div class="vstack gap-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="text-primary text-nowrap m-0">Skutočné výdavky</h4>
                        @if($spends->isNotEmpty())
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" wire:model.live="is_discretionary" id="checkDefault">
                            <label class="form-check-label" for="checkDefault">
                                Márnosti
                            </label>
                        </div>
                        @endif
                    </div>
                    @if($spends->isEmpty())
                    <div class="alert alert-light m-0" role="alert">
                        Zatiaľ žiadne výdavky
                    </div>
                    @endif
                    @if($spends->isNotEmpty())
                        @foreach($spends as $date => $itemsByDate)
                        <table class="table align-middle table-sm table-hover">
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
                                        {{ $spend->title }} {{ $spend->is_discretionary ? '- márnosť' : '' }}
                                        <br>
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

        <!-- ROZPOČET -->
        <div class="col-lg-5 order-lg-1">
            <div class="bg-white p-4 mb-4 d-none d-lg-block">
                <div class="vstack gap-4">
                    <h4 class="text-primary m-0">Plán</h4>
                    @if($items->isEmpty())
                    <div class="alert alert-light m-0" role="alert">
                        Žiaden plán
                    </div>
                    @endif
                    @if($items->isNotEmpty())
                    <table class="table table-hover align-middle m-0">
                        <thead class="">
                            <tr>
                                <th style="width: 30px" colspan="2">Kategória</th>
                                <th class="text-right">Zostatok</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($items as $category)
                                @php
                                $budget = (float) $category->budget;
                                $spend = (float) $category->total_spended;

                                if ($budget > 0) {
                                    $remaining = max(0, $budget - $spend);
                                    $percentage = ($remaining / $budget) * 100;
                                } else {
                                    $percentage = 0;
                                }
                                @endphp
                                <tr>
                                    <td class="text-muted" style="width: 25px">
                                        <i class="bi bi-{{ $category->icon }}"></i>
                                    </td>
                                    <td>{{ $category->title }}</td>
                                    <td class="text-right">
                                        <span
                                            data-bs-toggle="tooltip"
                                            data-bs-placement="right"
                                            data-bs-custom-class="custom-tooltip"
                                            data-bs-html="true"
                                            data-bs-title="Minuté <b>{{ formatCurrency($spend) }}</b> z mesačného rozpočtu <b>{{ $budget ? formatCurrency($budget) : '—' }}</b>">
                                            {{ $budget ? formatCurrency($budget - $spend) : '—' }}
                                        </span>
                                    </td>
                                    <td style="width: 350px">
                                        <div class="progress" style="height: 5px; width: 100%">
                                            <div class="progress-bar bg-secondary {{ $percentage <= 50 ? 'bg-danger' : '' }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
