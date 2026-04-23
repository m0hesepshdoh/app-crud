<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class part extends Model
{

    use HasFactory;

    protected $fillable = ['name', 'part_number', 'description', 'keywords', 'car_logo'];

    public function vehicles()
    {
        return $this->belongsToMany(Vehicle::class)
                    ->withPivot('part_number_specific', 'reference_number')
                    ->withTimestamps();
    }
    
}
