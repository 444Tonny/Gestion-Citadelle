<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    use HasFactory;
    protected $fillable=[
        'property_id',
        'unit_id',
        'issue_type',
        'maintainer_id',
        'status',
        'amount',
        'issue_attachment',
        'invoice',
        'notes',
        'parent_id',
        'request_date',
        'fixed_date',
        'parent_id',
    ];

    public static  $status= [
        'pending'=>'Pending',
        'in_progress'=>'In Progress',
        'completed'=>'Completed',
        ];

    public function properties(){
        return $this->hasOne('App\Models\Property','id','property_id');
    }
    public function units(){
        return $this->hasOne('App\Models\PropertyUnit','id','unit_id');
    }
    public function types(){
        return $this->hasOne('App\Models\Type','id','issue_type');
    }

    public function maintainers(){
        return $this->hasOne('App\Models\User','id','maintainer_id');
    }
}
