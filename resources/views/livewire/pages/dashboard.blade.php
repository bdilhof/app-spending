<div>
    <div class="row">
        <div class="col">
            <div class="d-none d-lg-block mb-4">
                <div class="d-flex justify-content-between align-items-center">
                    <livewire:components.bible-verse :$month />
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

                    <!-- Empty -->
                    @if($spends->isEmpty())
                    <div class="alert alert-light m-0" role="alert">
                        Zatiaľ žiadne výdavky
                    </div>
                    @endif

                    <!-- Table -->
                    @if($spends->isNotEmpty())
                        @foreach($spends as $date => $itemsByDate)
                        <table class="table align-middle table-sm table-hover m-0">
                            <thead>
                                <tr>
                                    <th>{{ humanDate($date) }}</th>
                                    <th class="text-end text-nowrap">{{ formatCurrency($itemsByDate->sum('amount')) }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($itemsByDate as $spend)
                                <livewire:components.expense-table-row :$spend />
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
