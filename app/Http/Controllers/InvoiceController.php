<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\InvoicePayment;
use App\Models\Property;
use App\Models\Tenant;
use App\Models\Type;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage invoice')) {
            if(\Auth::user()->type=='tenant'){
                $tenant=Tenant::where('user_id',\Auth::user()->id)->first();
                $invoices = Invoice::where('property_id',$tenant->property)->where('unit_id',$tenant->unit)->where('parent_id', \Auth::user()->parentId())->get();
            }else{
                $invoices = Invoice::where('parent_id', \Auth::user()->parentId())->get();
            }

            return view('invoice.index', compact('invoices'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        //dd(\Auth::user()->parentId());
        if (\Auth::user()->can('create invoice')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), '');
            
            //$types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'invoice')->get()->pluck('title', 'id');
            $types = Type::all()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');

            $invoiceNumber = $this->invoiceNumber();
            return view('invoice.create', compact('types', 'property', 'invoiceNumber'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('create invoice')) {
            $validator = \Validator::make(
                $request->all(), [
                    'property_id' => 'required',
                    'unit_id' => 'required',
                    'invoice_month' => 'required',
                    'end_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoice = new Invoice();
            $invoice->invoice_id = $request->invoice_id;
            $invoice->property_id = $request->property_id;
            $invoice->unit_id = $request->unit_id;
            $invoice->invoice_month = $request->invoice_month;
            $invoice->end_date = $request->end_date;
            $invoice->notes = $request->notes;
            $invoice->status = 'ouvert';
            $invoice->parent_id = \Auth::user()->parentId();
            $invoice->save();
            $types = $request->types;

            for ($i = 0; $i < count($types); $i++) {
                $invoiceItem = new InvoiceItem();
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->invoice_type = $types[$i]['invoice_type'];
                $invoiceItem->amount = $types[$i]['amount'];
                $invoiceItem->description = $types[$i]['description'];
                $invoiceItem->save();
            }
            return redirect()->route('invoice.index')->with('success', __('Invoice successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show(Invoice $invoice)
    {
        if (\Auth::user()->can('show invoice')) {
            $invoiceNumber = $invoice->invoice_id;
            $tenant = Tenant::where('property', $invoice->property_id)->where('unit', $invoice->unit_id)->first();
            return view('invoice.show', compact('invoiceNumber', 'invoice', 'tenant'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function edit(Invoice $invoice)
    {
        if (\Auth::user()->can('edit invoice')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), '');

            //$types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'invoice')->get()->pluck('title', 'id');
            $types = Type::all()->pluck('title', 'id');
            $types->prepend(__('Select Type'), '');

            $invoiceNumber = $invoice->invoice_id;
            return view('invoice.edit', compact('types', 'property', 'invoiceNumber', 'invoice'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function update(Request $request, Invoice $invoice)
    {
        if (\Auth::user()->can('edit invoice')) {
            $validator = \Validator::make(
                $request->all(), [
                    'property_id' => 'required',
                    'unit_id' => 'required',
                    'invoice_month' => 'required',
                    'end_date' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoice->property_id = $request->property_id;
            $invoice->unit_id = $request->unit_id;
            $invoice->invoice_month = $request->invoice_month;
            $invoice->end_date = $request->end_date;
            $invoice->notes = $request->notes;
            $invoice->save();
            $types = $request->types;

            for ($i = 0; $i < count($types); $i++) {
                $invoiceItem = InvoiceItem::find($types[$i]['id']);
                if ($invoiceItem == null) {
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $invoice->id;
                }

                $invoiceItem->invoice_type = $types[$i]['invoice_type'];
                $invoiceItem->amount = $types[$i]['amount'];
                $invoiceItem->description = $types[$i]['description'];
                $invoiceItem->save();
            }
            return redirect()->route('invoice.index')->with('success', __('Invoice successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(Invoice $invoice)
    {
        if (\Auth::user()->can('delete invoice')) {
            InvoiceItem::where('invoice_id', $invoice->id)->delete();
            InvoicePayment::where('invoice_id', $invoice->id)->delete();
            $invoice->delete();
            return redirect()->route('invoice.index')->with('success', __('Invoice successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function invoiceNumber()
    {
        $latest = Invoice::where('parent_id', \Auth::user()->parentId())->latest()->first();
        if ($latest == null) {
            return 1;
        } else {
            return $latest->invoice_id + 1;
        }
    }

    public function invoiceTypeDestroy(Request $request)
    {
        if (\Auth::user()->can('delete invoice type')) {
            $invoiceType = InvoiceItem::find($request->id);
            $invoiceType->delete();

            return response()->json([
                'status' => 'success',
                'msg' => __('Property successfully updated.'),
            ]);
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function invoicePaymentCreate($invoice_id)
    {
        $invoice = Invoice::find($invoice_id);

        return view('invoice.payment', compact('invoice_id','invoice'));
    }

    public function invoicePaymentStore(Request $request, $invoice_id)
    {
        if (\Auth::user()->can('create invoice payment')) {
            $validator = \Validator::make(
                $request->all(), [
                    'payment_date' => 'required',
                    'amount' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            if (!empty($request->receipt)) {
                $receiptFilenameWithExt = $request->file('receipt')->getClientOriginalName();
                $receiptFilename = pathinfo($receiptFilenameWithExt, PATHINFO_FILENAME);
                $receiptExtension = $request->file('receipt')->getClientOriginalExtension();
                $receiptFileName = $receiptFilename . '_' . time() . '.' . $receiptExtension;
                $dir = storage_path('upload/receipt');
                if (!file_exists($dir)) {
                    mkdir($dir, 0777, true);
                }
                $request->file('receipt')->storeAs('upload/receipt/', $receiptFileName);

            }

            $payment = new InvoicePayment();
            $payment->invoice_id = $invoice_id;
            $payment->transaction_id = md5(time());
            $payment->payment_type = __('Manually');
            $payment->amount = $request->amount;
            $payment->payment_date = $request->payment_date;
            $payment->receipt = !empty($request->receipt) ? $receiptFileName : '';
            $payment->notes = $request->notes;
            $payment->parent_id = \Auth::user()->parentId();
            $payment->save();
            $invoice = Invoice::find($invoice_id);
            if ($invoice->getDue() <= 0) {
                $status = 'complet';
            } else {
                $status = 'partiel';
            }
            Invoice::statusChange($invoice->id, $status);
            return redirect()->back()->with('success', __('Invoice payment successfully added.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }

    }

    public function invoicePaymentDestroy($invoice_id, $id)
    {
        if (\Auth::user()->can('delete invoice payment')) {
            $payment = InvoicePayment::find($id);
            $payment->delete();

            $invoice = Invoice::find($invoice_id);
            if ($invoice->getDue() <= 0) {
                $status = 'complet';
            } elseif ($invoice->getDue()==$invoice->getSubTotal()) {
                $status = 'ouvert';
            } else {
                $status = 'partiel';
            }
            Invoice::statusChange($invoice->id, $status);
            return redirect()->back()->with('success', __('Invoice payment successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

}
