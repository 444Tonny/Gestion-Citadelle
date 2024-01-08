<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable =[
        'title',
        'type',
        'parent_id',
    ];

    public static $types=[
        'invoice'=>'Invoice',
        'expense'=>'Expense',
        'issue'=>'Maintenance Issue',
        'maintainer_type'=>'Maintainer Type',
    ];
}
