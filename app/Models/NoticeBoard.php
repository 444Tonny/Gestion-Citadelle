<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    protected $fillable = [
        'title',
        'description',
        'attachment',
        'parent_id',
    ];
}
