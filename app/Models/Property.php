<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'price',
        'address',
        'type',
        'status',
        'bedrooms',
        'bathrooms',
        'area',
    ];

    public function images(): HasMany
    {
        return $this->hasMany(PropertyImage::class);
    }
}
