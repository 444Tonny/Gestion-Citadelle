<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Invoice;
use Carbon\Carbon;

class TenantInvoice extends Model
{
    use HasFactory;

    // Si votre modèle correspond à une table spécifique
    protected $table = 'v_tenants_invoices';

    protected $primaryKey = 'id'; // Spécifiez explicitement le nom de la clé primaire. // ne pas changer

    // Définissez les colonnes de la table si nécessaire
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'email',
        'invoice_id',
        'payment_total',
        'amount',
        'status'
    ];

    public function replacePlaceholders($htmlText)
    {
        $userId = $this->id;

        return preg_replace_callback('/\{([^\}]+)\}/', function ($matches) use ($userId) 
        {
            $attributeName = strtolower(trim($matches[1])); // Convertir en minuscules et supprimer les espaces autour

            // Vérifier si l'attribut existe dans le modèle User
            if ($this->getAttribute($attributeName)) {

                if($attributeName == 'invoice_month') return Carbon::createFromFormat('Y-m-d', $this->getAttribute($attributeName))->format('F Y');

                return $this->getAttribute($attributeName) ?: '#NULL#';
            }

            else if($attributeName == 'payment_due') 
            {
                $invoice = Invoice::find($this->invoice_id);

                return $invoice->getDue() ?: '#NULL#';
            }

            // Si l'attribut n'existe pas, vous pouvez également récupérer des valeurs à partir de relations ou d'autres sources.
            // Par exemple, si vous avez une relation 'profile' sur le modèle User, vous pouvez accéder aux attributs de la relation :
            // if ($this->profile && $this->profile->getAttribute($attributeName)) {
            //     return $this->profile->getAttribute($attributeName);
            // }

            // Si l'attribut n'existe pas, retournez une chaîne vide ou la balise non modifiée

            return '';

        }, $htmlText);
    }
}
