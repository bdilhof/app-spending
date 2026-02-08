<div class="container-fluid p-4">

    <div class="w-auto" style="width: 140px">
        <select wire:model.live="month" class="form-control mb-4">
            <option value="2026-01">Január</option>
            <option value="2026-02">Február</option>
        </select>
    </div>

    <div class="row mb-4">
        <div class="col">
            <div class="bg-light p-4">
                <figure class="text-center mb-0">
                    <blockquote class="blockquote m-0">
                        <p>{{ $verse['verse'] }}</p>
                    </blockquote>
                    <figcaption class="blockquote-footer m-0">
                        <cite>{{ $verse['reference'] }}</cite>
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- FORM -->
        <div class="col-lg-2">
            <div class="bg-light p-4 mb-4">
                <div class="vstack gap-3">
                    <h5 class="text-primary">Nový výdavok</h5>
                    <form wire:submit="save" class="vstack gap-2" id="brekeke">
                        <input type="number" wire:model="form.amount" class="form-control" step="0.01" placeholder="Suma">
                        <select wire:model="form.category_id" class="form-control">
                            <option value="">Kategória</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        <input type="text" wire:model="form.title" class="form-control" placeholder="Názov">
                        <input type="date" wire:model="form.date" class="form-control">
                        <div class="form-check">
                            <input class="form-check-input" wire:model="form.is_discretionary" type="checkbox">
                            <label class="form-check-label">Márnosť</label>
                        </div>
                    </form>
                    <button type="submit" class="btn btn-primary btn-sm mt-2" form="brekeke">
                        Uložiť
                    </button>
                </div>
            </div>
        </div>

        <!-- ROZPOČET -->
        <div class="col-lg-6">
            <div class="bg-light p-4 mb-4">
                <div class="vstack gap-3">
                    <h5 class="text-primary">Rozpočet</h5>
                    <table class="table align-middle m-0">
                        <thead class="table-primary">
                            <tr>
                                <th>Kategória</th>
                                <th>Rozpočet</th>
                                <th>Čerpané</th>
                                <th>Zostatok</th>
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
                                    <td>{{ $category->title }}</td>
                                    <td>{{ $budget ? formatCurrency($budget) : '—' }}</td>
                                    <td>{{ formatCurrency($spend) }}</td>
                                    <td>{{ $budget ? formatCurrency($budget - $spend) : '—' }}</td>
                                    <td>
                                        <div class="progress" style="height: 8px; width: 200px">
                                            <div class="progress-bar" style="width: {{ $percentage }}%"></div>
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
            <div class="bg-light p-4">
                <div class="vstack gap-3">
                    <h5 class="text-primary">Výdavky</h5>
                    <table class="table table-hover m-0">
                        <thead class="table-primary">
                            <tr class="border-b text-left text-sm text-gray-600">
                                <th class="">Dátum</th>
                                <th></th>
                                <th class="">Názov</th>
                                <th class="">Kategória</th>
                                <th class="text-right">Suma</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($spends as $spend)
                                <tr>
                                    <td>{{ $spend->date->format('d.m.Y') }}</td>
                                    <td>{{ $spend->is_discretionary ? '!' : '' }}</td>
                                    <td>{{ $spend->title }}</td>
                                    <td>{{ $spend->category->title }}</td>
                                    <td class="text-end">{{ formatCurrency($spend->amount) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
