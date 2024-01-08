<?php

namespace App\Models;

use http\Env\Request;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'property_id',
        'unit_id',
        'invoice_month',
        'end_date',
        'status',
        'notes',
        'parent_id',
    ];

    public static $status = [
        'ouvert' => 'Ouvert',
        'complet' => 'Complet',
        'partiel' => 'Partiel',
    ];

    public function properties()
    {
        return $this->hasOne('App\Models\Property', 'id', 'property_id');
    }

    public function units()
    {
        return $this->hasOne('App\Models\PropertyUnit', 'id', 'unit_id');
    }

    public function types()
    {
        return $this->hasMany('App\Models\InvoiceItem', 'invoice_id', 'id');
    }

    public function payments()
    {
        return $this->hasMany('App\Models\InvoicePayment', 'invoice_id', 'id');
    }

    public function getSubTotal()
    {
        $subTotal = 0;
        foreach ($this->types as $type) {
            $subTotal += $type->amount;
        }

        return $subTotal;
    }

    public function getDue()
    {
        $due = 0;
        foreach ($this->payments as $payment) {
            $due += $payment->amount;
        }

        return $this->getSubTotal() - $due;
    }

    public static function statusChange($invoice_id, $status)
    {
        $invoice = Invoice::find($invoice_id);
        $invoice->status = $status;
        $invoice->save();
        return $invoice;
    }
}
