<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /** @use HasFactory<\Database\Factories\CountryFactory> */
    use HasFactory;

    #add fillable property
    protected $fillable = [
        'name',
    ];
    #add has many relationship
    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
