<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JournalEmail extends Model
{
    use HasFactory;
    
    protected $table = 'journaux_email'; // Spécifiez explicitement le nom de la table.
    protected $primaryKey = 'id_journal'; // Spécifiez explicitement le nom de la clé primaire.
    public $timestamps = true;

    protected $fillable = [
        'id_modele',
        'id_destinataire',
        'email_destinataire',
        'sujet_journal',
        'corps_journal',
        'statut_journal',
        'raison_echec',
        'date_envoi',
    ];
}
