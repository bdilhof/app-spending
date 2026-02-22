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

                        @php
                        $budgetOverflow = false;

                        if ($budget && ($budget - $spend) < 0) {
                            $budgetOverflow = true;
                        }
                        @endphp

                        <td class="{{ $budgetOverflow ? 'text-danger fw-bold' : '' }}">
                            {{ $category->title }}
                        </td>
                        <td class="text-right {{ $budgetOverflow ? 'text-danger fw-bold' : '' }}">
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
                                <div class="progress-bar bg-primary {{ $percentage <= 50 ? 'bg-danger' : '' }}" style="width: {{ $percentage }}%"></div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</div>
