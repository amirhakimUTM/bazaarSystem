<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Duty extends Model
{
    protected $fillable = [
        'dutyName',
        'bazaarName',
        'dutyRemarks',
        'dutyLocation',
    ];

    public function bazaar()
    {
        return $this->belongsTo(Bazaar::class, 'bazaarName', 'bazaarName');
    }
}
