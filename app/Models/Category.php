<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'app_spend_categories';

    protected $fillable = [
        'title',
        'budget',
    ];

    /**
     * Attributes
     */
    public function getTotalSpendedAttribute()
    {
        return $this->spends->sum('amount');
    }

    public function getRemainingAmountAttribute()
    {
        $remains = $this->budget - $this->totalSpended;

        return $remains;
    }

    /**
     * Relationships
     */
    public function spends(): HasMany
    {
        return $this->hasMany(Spend::class, 'category_id');
    }
}
