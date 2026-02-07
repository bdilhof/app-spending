<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    protected $table = 'app_spends';

    protected $fillable = [
        'title',
        'amount',
        'date',
        'category_id',
        'is_discretionary',
    ];

    protected $casts = [
        'date' => 'date',
        'is_discretionary' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
