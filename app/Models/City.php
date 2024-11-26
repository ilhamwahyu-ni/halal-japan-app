<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    /** @use HasFactory<\Database\Factories\CityFactory> */
    use HasFactory;
    #add fillable
    protected $fillable = ['name', 'country_id'];

    #add belongs to relationship
    public function country()
    {
        return $this->belongsTo(Country::class);
    }
    #add has many relationship
    public function restaurants()
    {
        return $this->hasMany(Restaurant::class);
    }
}
