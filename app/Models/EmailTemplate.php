<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    use HasFactory;

    protected $table = 'modeles_email'; // Spécifiez explicitement le nom de la table.
    protected $primaryKey = 'id_modele'; // Spécifiez explicitement le nom de la clé primaire.
    public $timestamps = true;

    protected $fillable = [
        'id_modele',
        'categorie_modele',
        'nom_modele',
        'sujet',
        'corps',
        'parent_id',
        'is_deletable'
    ];

}
