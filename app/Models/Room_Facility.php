<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room_Facility extends Model
{
    public $timestamps=false;
    protected $table='room_facilities';
   use HasFactory;
}
