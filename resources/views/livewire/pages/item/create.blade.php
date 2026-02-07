<div class="container-fluid">
    <div class="row">
        <div class="col-2">
            <h5>Nový výdavok</h5>
            <form wire:submit="save" class="bg-light p-3 vstack gap-2">
                <div>
                    <label class="form-label">Suma</label>
                    <input type="number" class="form-control" inputmode="decimal" step="0.01" min="0" placeholder="0.00" wire:model="amount">
                    @error('amount') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Kategória</label>
                    <select wire:model="category_id" class="form-control">
                        <option>Select</option>
                        @foreach($items as $item)
                        <option value="{{ $item->id }}">{{ $item->title }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Názov</label>
                    <input type="text" wire:model="title" class="form-control">
                    @error('title') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="form-label">Dátum</label>
                    <input type="date" wire:model="date" class="form-control">
                    @error('date') <span class="error">{{ $message }}</span> @enderror
                </div>
                <div class="form-check">
                    <input class="form-check-input" wire:model="is_discretionary" type="checkbox" value="1" id="is_discretionary">
                    <label class="form-check-label" for="is_discretionary">
                        Nerozumný výdavok
                    </label>
                </div>
                <button type="submit" class="btn btn-sm btn-success">
                    Uložiť
                </button>
            </form>
        </div>
        <div class="col-6">
            <h5>Rozpočet</h5>
            <table class="table">
                <thead>
                    <tr>
                        <th>Kategória</th>
                        <th>Rozpočet</th>
                        <th>Minuté</th>
                        <th>Ostáva</th>
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
                        <td class="{{ $category->budget ? '': 'text-warning' }}">
                            @if ($category->budget)
                                {{ formatCurrency($category->budget) }}
                            @else
                                (nie je nastavený)
                            @endif
                        </td>
                        <td>{{ formatCurrency($category->totalSpended) }}</td>
                        <td>{{ formatCurrency($category->remainingAmount) }}</td>
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
        <div class="col-4">
            <h5>Výdavky</h5>
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>Dátum</th>
                        <th>Názov</th>
                        <th>Suma</th>
                        <th>Kategória</th>
                        <th>N.</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($spends as $spend)
                    <tr>
                        <td>{{ $spend->date->format('d.m.Y') }}</td>
                        <td>{{ $spend->title }}</td>
                        <td style="text-align: right">{{ formatCurrency($spend->amount) }}</td>
                        <td>{{ $spend->category->title }}</td>
                        <td>{{ $spend->is_discretionary }}</td>
                    </tr>
                @endforeach
                </tbody>
            </div>
        </div>
    </div>
</table>
