<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bazaar extends Model
{
    use HasFactory;

    protected $fillable = ['bazaarName', 'bazaarAddress', 'volunteerLimit'];

    protected $table = 'bazaars';

    public function foodWeights()
    {
        return $this->hasMany(FoodWeight::class, 'bazaarName', 'bazaarName');
    }

    public function users()
    {
        return $this->hasMany(User::class, 'bazaarName', 'bazaarName');
    }

    public function duties()
    {
        return $this->hasMany(Duty::class, 'bazaarName', 'name');
    }
}