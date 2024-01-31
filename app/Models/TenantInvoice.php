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
        'invoice_month',
        'invoice_type',
        'due_date',
        'payment_total',
        'tenant_invoice',
        'amount',
        'status',
        'tenant_address',
        'unit',
        'city',
        'state',
        'country',
        'zip_code'
    ];

    public function replacePlaceholders($htmlText, $invoice = null)
    {
        $userId = $this->id;

        return preg_replace_callback('/\{([^\}]+)\}/', function ($matches) use ($userId, $invoice) 
        {
            $attributeName = strtolower(trim($matches[1])); // Convertir en minuscules et supprimer les espaces autour

            $currentMonth = Carbon::now()->format('m');
            $currentYear = Carbon::now()->format('Y');
            
            if($invoice == null)
            {
                $query = TenantInvoice::whereRaw("MONTH(invoice_month) = ? and YEAR(invoice_month) = ? and `id` = ? and `invoice_type` = ?", [$currentMonth, $currentYear, $this->id, 'Loyer']);
                $tenantInvoice = $query->first();
                //dd($tenantInvoice);
            } 
            else $tenantInvoice = $invoice;

            // Vérifier si l'attribut existe dans le modèle User
            if ($this->getAttribute($attributeName)) 
            {
                if($attributeName == 'payment_total ') 
                {
                    return $tenantInvoice->getAttribute($attributeName) ?: '#NULL#';
                }
                else if($attributeName == 'due_date') 
                {
                    $attributeValue = $this->getAttribute($attributeName);
    
                    if ($attributeValue !== null) {
                        return date('d M Y', strtotime($attributeValue));
                    }
                    else return null; 
                }
                else
                {
                    return in_array($attributeName, ['first_name', 'last_name'])
                        ? ($this->getAttribute($attributeName) !== null ? $this->getAttribute($attributeName) : '')
                        : ($this->getAttribute($attributeName) !== null ? $this->getAttribute($attributeName) : '#NULL#');
                }
            }

            // Payment_due n'existe pas dans la vue
            else if($attributeName == 'payment_due') 
            {                           
                $invoice = Invoice::find($tenantInvoice->invoice_id);

                return $invoice->getDue() ?: '#NULL#';
            }
            else if($attributeName == 'received_amount') 
            {                        
                $invoice = Invoice::find($tenantInvoice->invoice_id);

                $remaining = $invoice->getDue() ?: 0;
                $totalToPay = $tenantInvoice->getAttribute('payment_total') ?: 0;

                return ($totalToPay - $remaining); 
            }
            else if($attributeName == 'current_month') return Carbon::now()->formatLocalized('%B');
            else if($attributeName == 'next_month') return Carbon::now()->addMonth()->formatLocalized('%B');
            else if($attributeName == 'current_year') return Carbon::now()->format('Y');
            else if($attributeName == 'last_name') return ($this->getAttribute($attributeName) !== null) ? $this->getAttribute($attributeName) : '';
            else if($attributeName == 'first_name') return ($this->getAttribute($attributeName) !== null) ? $this->getAttribute($attributeName) : '';

            return '#NULL#';

        }, $htmlText);
    }
}
