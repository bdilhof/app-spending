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

        <!-- Filter -->
        <div class="d-flex">
            <input wire:model.live='search' class="form-control" placeholder="Hľadaj výdavok" />
            <select class="form-select" wire:model.live="category">
                <option>Vyber kategóriu</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->title }}</option>
                @endforeach
            </select>
        </div>

        <!-- Empty -->
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
