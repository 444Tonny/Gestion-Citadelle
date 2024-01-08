<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupportReply extends Model
{
    protected $fillable = [
        'support_id',
        'user_id',
        'description',
        'parent_id',
    ];

    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'user_id');
    }
}
