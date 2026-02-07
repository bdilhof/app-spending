<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    protected $table = 'app_spend_categories';

    protected $fillable = [
        'title',
    ];

    /**
     * Attributes
     */
    public function getTotalSpendedAttribute()
    {
        return formatCurrency($this->spends->sum('amount'));
    }

    /**
     * Relationships
     */
    public function spends(): HasMany
    {
        return $this->hasMany(Spend::class, 'category_id');
    }
}
