<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    protected $fillable = [
        'subject',
        'assign_user',
        'priority',
        'status',
        'attachment',
        'created_id',
        'parent_id',
        'description',
    ];

    public static $priority = [
        'low' => 'Low',
        'medium' => 'Medium',
        'high' => 'High',
        'critical' => 'Critical',
    ];


    public static $status = [
        'pending' => 'Pending',
        'open' => 'Open',
        'close' => 'Close',
        'on_hold' => 'On Hold',
    ];

    public function createdUser()
    {
        return $this->hasOne('App\Models\user', 'id', 'created_id');
    }

    public function assignUser()
    {
        return $this->hasOne('App\Models\user', 'id', 'assign_user');
    }

    public function reply()
    {
        return $this->hasMany('App\Models\SupportReply', 'support_id', 'id');
    }
}
