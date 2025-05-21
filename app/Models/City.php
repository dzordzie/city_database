<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class City extends Model
{
    protected $fillable = [
        'name',
        'mayor_name',
        'city_hall_address',
        'phone',
        'fax',
        'email',
        'web',
        'coat_of_arms_image',
        'latitude',
        'longitude',
        'url',
        'sub_district_id'
    ];

    protected static function booted()
    {
        static::saving(function($city) {
            $city->search_name = Str::slug($city->name, ' ');
        });
    }

    public function subDistrict(): BelongsTo
    {
        return $this->belongsTo(SubDistrict::class);
    }
}
