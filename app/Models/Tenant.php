<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable=[
        'user_id',
        'family_member',
        'profile',
        'address',
        'country',
        'state',
        'city',
        'zip_code',
        'property',
        'unit',
        'lease_start_date',
        'lease_end_date',
        'is_active',
    ];

    public function properties(){
        return $this->hasOne('App\Models\Property','id','property');
    }
    public function units(){
        return $this->hasOne('App\Models\PropertyUnit','id','unit');
    }

    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }
}
