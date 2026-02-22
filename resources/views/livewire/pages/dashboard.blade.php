<div>
    <div class="row">
        <div class="col">
            <div class="d-none d-lg-block mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <livewire:components.bible-verse :month="$month" />
                    <livewire:components.month-selector />
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <livewire:components.create-expense />
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
            <livewire:components.month-overview />
        </div>
    </div>
</div>
