<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FoodWeight extends Model
{
    protected $fillable = [
        'bazaarName',
        'year',
        'day',
        'weight',
    ];

    public function bazaar()
    {
        return $this->belongsTo(Bazaar::class, 'bazaarName', 'bazaarName');
    }
}
