<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'app_spend_categories';

    protected $fillable = [
        'title',
    ];
}
