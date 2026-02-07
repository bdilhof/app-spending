<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    protected $table = 'app_spends';

    protected $casts = [
        'date' => 'date',
    ];

    protected $fillable = [
        'title',
        'amount',
        'date',
        'category_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
