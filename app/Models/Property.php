<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'type',
        'country',
        'state',
        'city',
        'zip_code',
        'address',
        'parent_id',
        'is_active',
    ];

    public static $Type=[
        'own_property'=> 'Own Property',
        'lease_property'=>'Lease Property',
    ];

    public function thumbnail(){
        return $this->hasOne('App\Models\PropertyImage','property_id','id')->where('type','thumbnail');
    }

    public function propertyImages(){
        return $this->hasMany('App\Models\PropertyImage','property_id','id')->where('type','extra');
    }

    public function totalUnit(){
        return $this->hasMany('App\Models\PropertyUnit','property_id','id')->count();
    }
    public function totalUnits(){
        return $this->hasMany('App\Models\PropertyUnit','property_id','id');
    }
    public function totalRoom(){
        $units= $this->totalUnits;

        $totalUnit=0;
        foreach($units as $unit){
            $totalUnit+=$unit->bedroom;

        }
        return $totalUnit;
    }
}
