<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = ['brand', 'model', 'year'];

    public function parts()
    {
        return $this->belongsToMany(Part::class)
                    ->withPivot('part_number_specific', 'reference_number')
                    ->withTimestamps();
    }
}


