<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Property;
use App\Models\Type;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    public function index()
    {
        if (\Auth::user()->can('manage expense')) {
            $expenses = Expense::where('parent_id', \Auth::user()->parentId())->get();
            return view('expense.index', compact('expenses'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create expense')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), '');
            $types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'expense')->get()->pluck('title', 'id');
            $types->prepend(__('Select Property'), '');

            $billNumber = $this->expenseNumber();
            return view('expense.create', compact('types', 'property', 'billNumber'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create expense')) {
            $validator = \Validator::make(
                $request->all(), [
                'title' => 'required|regex:/^[\s\w-]*$/',
                'property_id' => 'required',
                'unit_id' => 'required',
                'expense_type' => 'required',
                'amount' => 'required',
                'date' => 'required',
            ], [
                    'regex' => __('The Title format is invalid, Contains letter, number and only alphanum'),
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

            $expense = new Expense();
            $expense->title = $request->title;
            $expense->expense_id = $request->expense_id;
            $expense->property_id = $request->property_id;
            $expense->unit_id = $request->unit_id;
            $expense->expense_type = $request->expense_type;
            $expense->amount = $request->amount;
            $expense->date = $request->date;
            $expense->receipt = !empty($request->receipt) ? $receiptFileName : '';
            $expense->notes = $request->notes;
            $expense->parent_id = \Auth::user()->parentId();
            $expense->save();

            return redirect()->back()->with('success', __('Expense successfully created.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function show(Expense $expense)
    {
        if (\Auth::user()->can('show expense')) {
            return view('expense.show', compact('expense'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function edit(Expense $expense)
    {
        if (\Auth::user()->can('edit expense')) {
            $property = Property::where('parent_id', \Auth::user()->parentId())->get()->pluck('name', 'id');
            $property->prepend(__('Select Property'), '');
            $types = Type::where('parent_id', \Auth::user()->parentId())->where('type', 'expense')->get()->pluck('title', 'id');
            $types->prepend(__('Select Property'), '');

            $billNumber = $expense->expense_id;
            return view('expense.edit', compact('types', 'property', 'billNumber', 'expense'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function update(Request $request, Expense $expense)
    {
        if (\Auth::user()->can('edit expense')) {
            $validator = \Validator::make(
                $request->all(), [
                'title' => 'required|regex:/^[\s\w-]*$/',
                'property_id' => 'required',
                'unit_id' => 'required',
                'expense_type' => 'required',
                'amount' => 'required',
                'date' => 'required',
            ], [
                    'regex' => __('The Title format is invalid, Contains letter, number and only alphanum'),
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
                $expense->receipt = !empty($request->receipt) ? $receiptFileName : '';
            }

            $expense->title = $request->title;
            $expense->expense_id = $request->expense_id;
            $expense->property_id = $request->property_id;
            $expense->unit_id = $request->unit_id;
            $expense->expense_type = $request->expense_type;
            $expense->amount = $request->amount;
            $expense->date = $request->date;
            $expense->notes = $request->notes;
            $expense->save();

            return redirect()->back()->with('success', __('Expense successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function destroy(Expense $expense)
    {
        if (\Auth::user()->can('delete expense')) {
            $expense->delete();
            return redirect()->back()->with('success', __('Expense successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function expenseNumber()
    {
        $latest = Expense::where('parent_id', \Auth::user()->parentId())->latest()->first();
        if ($latest == null) {
            return 1;
        } else {
            return $latest->expense_id + 1;
        }
    }
}
