<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintainer extends Model
{
    use HasFactory;
    public $fillable=[
        'user_id',
        'property_id',
        'type_id',
        'profile',
        'parent_id',
    ];

    public function properties(){
        $property=[];
        if(!empty($this->property_id)){
            foreach (explode(',',$this->property_id) as $id){
                $pro=Property::find($id);
                $property[]=$pro;
            }
        }

       return $property;
    }

    public function types(){
        return $this->hasOne('App\Models\Type','id','type_id');
    }
    public function user(){
        return $this->hasOne('App\Models\User','id','user_id');
    }


}
