<?php

namespace App\Http\Controllers;


use App\Models\Applicant;
use App\Models\AppliedJob;
use App\Models\Contact;
use App\Models\Custom;
use App\Models\Expense;
use App\Models\InterviewSchedule;
use App\Models\Invoice;
use App\Models\InvoicePayment;
use App\Models\Maintainer;
use App\Models\MaintenanceRequest;
use App\Models\NoticeBoard;
use App\Models\Order;
use App\Models\Property;
use App\Models\PropertyUnit;
use App\Models\Subscription;
use App\Models\Support;
use App\Models\Tenant;
use App\Models\User;


class HomeController extends Controller
{
    public function index()
    {
        if (\Auth::check()) {
            if (\Auth::user()->type == 'super admin') {
                $data['totalOrganization'] = User::where('type', 'admin')->count();
                $data['totalSubscription'] = Subscription::count();
                $data['totalTransaction'] = Order::count();
                $data['totalIncome'] = Order::sum('price');
                $data['totalNote'] = NoticeBoard::where('parent_id', \Auth::user()->id)->count();
                $data['totalContact'] = Contact::where('parent_id', \Auth::user()->id)->count();
                $data['totalSupport'] = Support::where('created_id', \Auth::user()->id)->orWhere('assign_user', \Auth::user()->id)->count();
                $data['todaySupport'] = Support::whereDate('created_at', '=', date('Y-m-d'))->where('created_id', \Auth::user()->id)->orWhere('assign_user', \Auth::user()->id)->count();

                $data['organizationByMonth'] = $this->organizationByMonth();
                $data['paymentByMonth'] = $this->paymentByMonth();

                return view('dashboard.super_admin', compact('data'));
            } else {

                $data['totalNote'] = NoticeBoard::where('parent_id', \Auth::user()->id)->count();
                $data['totalContact'] = Contact::where('parent_id', \Auth::user()->id)->count();
                $data['totalSupport'] = Support::where('created_id', \Auth::user()->id)->orWhere('assign_user', \Auth::user()->id)->count();
                $data['todaySupport'] = Support::whereDate('created_at', '=', date('Y-m-d'))->where('created_id', \Auth::user()->id)->orWhere('assign_user', \Auth::user()->id)->count();

                if (\Auth::user()->type == 'tenant') {
                    $tenant=Tenant::where('user_id',\Auth::user()->id)->first();
                    $data['totalInvoice']=Invoice::where('property_id',$tenant->property)->where('unit_id',$tenant->unit)->count();
                    $data['unit']=PropertyUnit::find($tenant->unit);

                    return view('dashboard.tenant', compact('data','tenant'));
                }

                if (\Auth::user()->type == 'maintainer') {
                    $maintainer=Maintainer::where('user_id',\Auth::user()->id)->first();
                    $data['totalRequest']=MaintenanceRequest::where('maintainer_id',\Auth::user()->id)->count();
                    $data['todayRequest']=MaintenanceRequest::whereDate('request_date', '=', date('Y-m-d'))->where('maintainer_id',\Auth::user()->id)->count();

                    return view('dashboard.maintainer', compact('data','maintainer'));
                }

                $data['totalProperty'] = Property::where('parent_id', \Auth::user()->parentId())->count();
                $data['totalUnit'] = PropertyUnit::where('parent_id', \Auth::user()->parentId())->count();
                $data['totalIncome'] = InvoicePayment::where('parent_id', \Auth::user()->parentId())->sum('amount');
                $data['totalExpense'] = Expense::where('parent_id', \Auth::user()->parentId())->sum('amount');
                $data['recentProperty'] = Property::where('parent_id', \Auth::user()->parentId())->orderby('id', 'desc')->limit(5)->get();
                $data['recentTenant'] = Tenant::where('parent_id', \Auth::user()->parentId())->orderby('id', 'desc')->limit(5)->get();
                $data['incomeExpenseByMonth'] = $this->incomeByMonth();
                $data['settings'] = Custom::settings();

                return view('dashboard.index', compact('data'));
            }
        } else {
            if (!file_exists(storage_path() . "/installed")) {
                header('location:install');
                die;
            } else {
                return view('layouts.landing');

            }

        }

    }

    public function organizationByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $organization = [];
        while ($currentdate <= $end) {
            $organization['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $organization['data'][] = User::where('type', 'admin')->whereMonth('created_at', $month)->whereYear('created_at', $year)->count();
            $currentdate = strtotime('+1 month', $currentdate);
        }


        return $organization;

    }

    public function paymentByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['data'][] = Order::whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('price');
            $currentdate = strtotime('+1 month', $currentdate);
        }


        return $payment;

    }

    public function incomeByMonth()
    {
        $start = strtotime(date('Y-01'));
        $end = strtotime(date('Y-12'));

        $currentdate = $start;

        $payment = [];
        while ($currentdate <= $end) {
            $payment['label'][] = date('M-Y', $currentdate);

            $month = date('m', $currentdate);
            $year = date('Y', $currentdate);
            $payment['income'][] = InvoicePayment::where('parent_id', \Auth::user()->parentId())->whereMonth('payment_date', $month)->whereYear('payment_date', $year)->sum('amount');
            $payment['expense'][] = Expense::where('parent_id', \Auth::user()->parentId())->whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
            $currentdate = strtotime('+1 month', $currentdate);
        }

        return $payment;

    }
}
