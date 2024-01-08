<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    protected $fillable=[
        'property_id',
        'image',
        'type',
    ];
    use HasFactory;
}
