<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'contact_number',
        'subject',
        'message',
        'parent_id',
    ];
}
