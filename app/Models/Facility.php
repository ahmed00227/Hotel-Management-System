<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Facility extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected function facilityName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }
    public function rooms():belongsToMany
    {
        return $this->belongsToMany(Room::class,'room_facilities')->withPivot('facility_condition');
    }
}
