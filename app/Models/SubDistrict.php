<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class SubDistrict extends Model
{
    protected $fillable = ['name', 'url'];


    protected static function booted()
    {
        static::saving(function($subDistrict) {
            $subDistrict->search_name = Str::slug($subDistrict->name, ' ');
        });
    }


    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
