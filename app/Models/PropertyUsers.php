<?php

// app/Models/PropertyUsers.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PropertyUsers extends Model
{
    protected $table = 'property_tenant_user_view';

    protected $primaryKey = 'id_property';

    protected $fillable = [
        'id_property',
        'name',
        'address',
        'parent_id',
        'id_tenant',
        'lease_start_date',
        'lease_end_date',
        'id_user',
        'email',
        'first_name',
        'last_name',
        'type',
    ];

    // Si vous n'utilisez pas les timestamps created_at et updated_at
    public $timestamps = false;
}

?>