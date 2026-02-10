<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'app_spend_categories';

    protected $fillable = [
        'title',
        'icon',
        'budget',
    ];

    protected $casts = [
        'budget' => 'decimal:2',
    ];

    protected $appends = [
        'remaining_amount',
    ];

    public function spends(): HasMany
    {
        return $this->hasMany(Spend::class, 'category_id');
    }

    public function getRemainingAmountAttribute(): float
    {
        $spent = $this->total_spended ?? 0;

        return max(0, (float) $this->budget - (float) $spent);
    }
}
