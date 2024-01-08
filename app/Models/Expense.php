<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;
    public $fillable=[
        'title',
        'property_id',
        'unit_id',
        'expense_type',
        'amount',
        'receipt',
        'notes',
        'parent_id',
        'expense_id',
    ];

    public function properties(){
        return $this->hasOne('App\Models\Property','id','property_id');
    }
    public function units(){
        return $this->hasOne('App\Models\PropertyUnit','id','unit_id');
    }
    public function types(){
        return $this->hasOne('App\Models\Type','id','expense_type');
    }
}
