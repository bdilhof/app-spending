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
