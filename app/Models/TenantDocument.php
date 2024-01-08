<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TenantDocument extends Model
{
    protected $fillable=[
        'document',
        'property_id',
        'tenant_id',
        'parent_id',
    ];
    use HasFactory;
}
