<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AutomationTrigger extends Model
{
    protected $table = 'automation_triggers';
    
    protected $primaryKey = 'id_trigger';

    protected $fillable = [
        'type',
        'scheduling_expression',
        'frequence',
        'id_modele',
        'recipients',
        'is_active',
        'timezone'
    ];
}
