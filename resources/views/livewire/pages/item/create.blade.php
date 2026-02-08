<div class="container-fluid p-4">
    <div class="row">

        <!-- Form section -->
        <div class="col-2">
            <div class="bg-light p-4 vstack gap-4">
                <h5 class="text-primary">Nový výdavok</h5>
                <form wire:submit="save" class="vstack gap-2">
                    <div>
                        <label class="form-label" for="amount">Suma</label>
                        <input type="number" class="form-control" inputmode="decimal" step="0.01" min="0" placeholder="0.00" id="amount" wire:model="form.amount">
                        @error('amount') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="category_id">Kategória</label>
                        <select wire:model="form.category_id" id="category_id" class="form-control">
                            <option>Select</option>
                            @foreach($items as $item)
                                <option value="{{ $item->id }}">{{ $item->title }}</option>
                            @endforeach
                        </select>
                        @error('category_id') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="title">Názov</label>
                        <input type="text" wire:model="form.title" id="title" class="form-control">
                        @error('title') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="form-label" for="date">Dátum</label>
                        <input type="date" wire:model="form.date" id="date" class="form-control">
                        @error('date') <span class="error">{{ $message }}</span> @enderror
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" wire:model="form.is_discretionary" type="checkbox" id="is_discretionary">
                        <label class="form-check-label" for="is_discretionary">
                            Nerozumný výdavok
                        </label>
                    </div>
                    <button type="submit" class="btn btn-sm btn-primary mt-3">Uložiť</button>
                </form>
            </div>
        </div>

        <!-- Budget table -->
        <div class="col-6">
            <div class="bg-light p-4 vstack gap-4">
                <h5 class="text-primary">Rozpočet</h5>
                <table class="table m-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Kategória</th>
                            <th>Rozpočet</th>
                            <th class="text-right">Minuté</th>
                            <th class="text-right">Ostáva</th>
                            <th style="width: 300px"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $category)
                            @php
                                if ($category->budget) {
                                    $budget = (float) $category->budget;
                                    $spend = $category->totalSpended;
                                    $percentage = ($spend / $budget) * 100;
                                } else {
                                    $percentage = 0;
                                }
                            @endphp
                            <tr>
                                <td>{{ $category->title }}</td>
                                <td class="{{ $category->budget ? '' : 'text-warning' }}">
                                    @if ($category->budget)
                                        {{ formatCurrency($category->budget) }}
                                    @else
                                        <span class="text-muted">(nie je nastavený)</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    {{ formatCurrency($category->totalSpended) }}
                                </td>
                                <td class="text-right">
                                    @if($category->budget)
                                    {{ formatCurrency($category->remainingAmount) }}
                                    @endif
                                </td>
                                <td>
                                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                        <div class="progress-bar" style="width: {{ $percentage }}%"></div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Spends table -->
        <div class="col-4">
            <div class="bg-light p-4 vstack gap-4">
                <h5 class="text-primary">Výdavky</h5>
                <table class="table table-hover m-0">
                    <thead class="table-primary">
                        <tr>
                            <th>Dátum</th>
                            <th></th>
                            <th>Názov</th>
                            <th>Kategória</th>
                            <th class="text-right">Suma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($spends as $spend)
                            <tr>
                                <td>{{ $spend->date->format('d.m.Y') }}</td>
                                <td>
                                    @if($spend->is_discretionary)
                                        <span>!</span>
                                    @endif
                                </td>
                                <td>{{ $spend->title }}</td>
                                <td>{{ $spend->category->title }}</td>
                                <td style="text-align: right">
                                    {{ formatCurrency($spend->amount) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
