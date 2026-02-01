<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Spend extends Model
{
    protected $table = 'app_spends';

    protected $fillable = [
        'title',
        'price',
        'category',
    ];
}
