<div class="container-fluid p-4">

    <div class="row">
        <div class="col">
            <div class="d-none d-lg-block bg-white mb-4 p-4">
                <div class="d-flex justify-content-between align-items-center">
                    <figure class="mb-0">
                        <blockquote class="blockquote m-0">
                            <p>{{ $verse['verse'] }}</p>
                        </blockquote>
                        <figcaption class="blockquote-footer m-0">
                            <cite>{{ $verse['reference'] }}</cite>
                        </figcaption>
                    </figure>
                    <select wire:model.live="month" class="form-select w-auto">
                        <option value="2026-01">Január 2026</option>
                        <option value="2026-02">Február 2026</option>
                    </select>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <!-- ROZPOČET -->
        <div class="col-lg-5">
            <div class="bg-white p-4 mb-4 d-none d-lg-block">
                <div class="vstack gap-4">
                    <h4 class="text-primary m-0">Plán</h4>
                    <table class="table table-hover align-middle m-0">
                        <thead class="">
                            <tr>
                                <th>Kategória</th>
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
                                    <td title="Minuté {{ formatCurrency($spend) }} z mesačného rozpočtu {{ $budget ? formatCurrency($budget) : '—' }}">{{ $category->title }}</td>
                                    <td class="text-right">{{ $budget ? formatCurrency($budget - $spend) : '—' }}</td>
                                    <td style="width: 350px">
                                        <div class="progress" style="height: 5px; width: 100%">
                                            <div class="progress-bar {{ $percentage <= 50 ? 'bg-danger' : '' }}" style="width: {{ $percentage }}%"></div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- VÝDAVKY -->
        <div class="col-lg-4">
            <div class="bg-white p-4">
                <div class="vstack gap-4">
                    <h4 class="text-primary m-0">Skutočné výdavky</h4>
                    <table class="table align-middle table-hover m-0">
                        @foreach($spends as $date => $itemsByDate)
                        <thead>
                            <tr>
                                <th colspan="2">{{ $date }}</th>
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
                        @endforeach
                    </table>
                </div>
            </div>
        </div>

        <!-- FORM -->
        <div class="col-lg-3">
            <div class="bg-white p-4 mb-4">
                <div class="vstack gap-4">
                    <h4 class="text-primary m-0">Nový výdavok</h4>
                    <form wire:submit="save" class="vstack gap-2" id="brekeke">
                        <input type="date" wire:model="form.date" class="form-control">
                        <input type="number" wire:model="form.amount" class="form-control" step="0.01" placeholder="Suma">
                        <select wire:model="form.category_id" class="form-select">
                            <option value="">Kategória</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <input type="text" wire:model="form.title" class="form-control" placeholder="Názov">
                        <div class="form-check m-0">
                            <input class="form-check-input" wire:model="form.is_discretionary" id="is_discretionary" type="checkbox">
                            <label class="form-check-label" for="is_discretionary">Márnosť</label>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-success btn-sm" form="brekeke">
                        Uložiť
                    </button>
                </div>
            </div>
        </div>

    </div>
</div>
