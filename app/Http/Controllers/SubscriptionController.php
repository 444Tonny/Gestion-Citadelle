<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Stripe;

class SubscriptionController extends Controller
{

    public function index()
    {
        if (\Auth::user()->type == 'super admin' || \Auth::user()->type == 'admin') {
            $subscriptions = Subscription::get();

            return view('subscription.index', compact('subscriptions'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function create()
    {
        $durations = Subscription::$duration;

        return view('subscription.create', compact('durations'));
    }


    public function store(Request $request)
    {
        if (\Auth::user()->type == 'super admin' ) {
            $validator = \Validator::make(
                $request->all(), [
                'name' => 'required|regex:/^[\s\w-]*$/',
                'price' => 'required',
                'duration' => 'required',
                'total_user' => 'required',
                'total_property' => 'required',
                'total_tenant' => 'required',
            ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $subscription = new Subscription();
            $subscription->name = $request->name;
            $subscription->price = $request->price;
            $subscription->duration = $request->duration;
            $subscription->total_property = $request->total_property;
            $subscription->total_user = $request->total_user;
            $subscription->total_tenant = $request->total_tenant;
            $subscription->description = $request->description;
            $subscription->save();

            return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully created!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function show($ids)
    {
        if (\Auth::user()->type == 'admin') {
            $id = Crypt::decrypt($ids);
            $subscription = Subscription::find($id);

            return view('subscription.show', compact('subscription'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function edit(subscription $subscription)
    {
        $durations = Subscription::$duration;

        return view('subscription.edit', compact('durations', 'subscription'));
    }


    public function update(Request $request, subscription $subscription)
    {
        if (\Auth::user()->type == 'super admin') {
            $validator = \Validator::make(
                $request->all(), [
                'name' => 'required|regex:/^[\s\w-]*$/',
                'price' => 'required',
                'duration' => 'required',
                'total_user' => 'required',
                'total_property' => 'required',
                'total_tenant' => 'required',
            ], [
                    'regex' => __('The Name format is invalid, Contains letter, number and only alphanum'),
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $subscription->name = $request->name;
            $subscription->price = $request->price;
            $subscription->duration = $request->duration;
            $subscription->total_property = $request->total_property;
            $subscription->total_user = $request->total_user;
            $subscription->total_tenant = $request->total_tenant;
            $subscription->description = $request->description;
            $subscription->save();

            return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully updated!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }


    public function destroy(subscription $subscription)
    {
        if (\Auth::user()->type == 'super admin') {
            $subscription->delete();

            return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function transaction()
    {
        if (\Auth::user()->type == 'admin' || \Auth::user()->type == 'super admin') {
            $transactions = Order::select(
                [
                    'orders.*',
                ]
            )->join('users', 'orders.user_id', '=', 'users.id')->orderBy('orders.created_at', 'DESC')->get();

            return view('subscription.transaction', compact('transactions'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied!'));
        }
    }

    public function stripePayment(Request $request, $ids)
    {
        if (\Auth::user()->type == 'admin') {
            $authUser = \Auth::user();
            $id = \Illuminate\Support\Facades\Crypt::decrypt($ids);
            $subscription = Subscription::find($id);
            if ($subscription) {
                try {
                    $price = $subscription->price;
                    $orderID = uniqid('', true);
                    if ($price > 0.0) {

                        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
                        $data = Stripe\Charge::create(
                            [
                                "amount" => 100 * $price,
                                "currency" => !empty(env('CURRENCY')) ? env('CURRENCY') : 'USD',
                                "source" => $request->stripeToken,
                                "description" => " Subscription - " . $subscription->name,
                                "metadata" => ["order_id" => $orderID],
                            ]
                        );
                    } else {
                        $data['amount_refunded'] = 0;
                        $data['failure_code'] = '';
                        $data['paid'] = 1;
                        $data['captured'] = 1;
                        $data['status'] = 'succeeded';
                    }


                    if ($data['amount_refunded'] == 0 && empty($data['failure_code']) && $data['paid'] == 1 && $data['captured'] == 1) {

                        $orders = Order::create(
                            [
                                'order_id' => $orderID,
                                'name' => $request->name,
                                'card_number' => isset($data['payment_method_details']['card']['last4']) ? $data['payment_method_details']['card']['last4'] : '',
                                'card_exp_month' => isset($data['payment_method_details']['card']['exp_month']) ? $data['payment_method_details']['card']['exp_month'] : '',
                                'card_exp_year' => isset($data['payment_method_details']['card']['exp_year']) ? $data['payment_method_details']['card']['exp_year'] : '',
                                'subscription' => $subscription->name,
                                'subscription_id' => $subscription->id,
                                'price' => $price,
                                'price_currency' => isset($data['currency']) ? $data['currency'] : '',
                                'txn_id' => isset($data['balance_transaction']) ? $data['balance_transaction'] : '',
                                'payment_status' => isset($data['status']) ? $data['status'] : 'succeeded',
                                'payment_type' => __('STRIPE'),
                                'receipt' => isset($data['receipt_url']) ? $data['receipt_url'] : '',
                                'user_id' => $authUser->id,
                            ]
                        );

                        if ($data['status'] == 'succeeded') {
                            $assignPlan = $authUser->assignSubscription($subscription->id);
                            if ($assignPlan['is_success']) {
                                return redirect()->route('subscriptions.index')->with('success', __('Subscription successfully activated.'));
                            } else {
                                return redirect()->route('subscriptions.index')->with('error', __($assignPlan['error']));
                            }
                        } else {
                            return redirect()->route('subscriptions.index')->with('error', __('Your payment has failed.'));
                        }
                    } else {
                        return redirect()->route('subscriptions.index')->with('error', __('Transaction has been failed.'));
                    }
                } catch (\Exception $e) {
                    return redirect()->route('subscriptions.index')->with('error', __($e->getMessage()));
                }
            } else {
                return redirect()->route('subscriptions.index')->with('error', __('Subscription is deleted.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }


}
