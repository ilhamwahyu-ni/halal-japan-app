<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Restaurant extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'address',
        'city',
        'country',
        'latitude',
        'longitude',
        'status',
        'website',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'id' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function menus(): HasMany
    {
        return $this->hasMany(Menu::class);
    }
    #add belong to city relationship
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
