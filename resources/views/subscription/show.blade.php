@extends('layouts.app')
@section('page-title')
    {{__('Subscription')}}
@endsection

@push('script-page')
    <script src="https://js.stripe.com/v3/"></script>

    <script type="text/javascript">
        @if($subscription->price > 0.0 && env('STRIPE_PAYMENT') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET')))
        var stripe = Stripe('{{ env('STRIPE_KEY') }}');
        var elements = stripe.elements();
        var style = {
            base: {
                fontSize: '14px',
                color: '#32325d',
            },
        };

        var card = elements.create('card', {style: style});
        card.mount('#card-element');

        var form = document.getElementById('stripe-payment');
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            stripe.createToken(card).then(function (result) {
                if (result.error) {
                    $("#card-errors").html(result.error.message);
                    $.NotificationApp.send("Error", result.error.message, "top-right", "rgba(0,0,0,0.2)", "error");
                } else {
                    stripeTokenHandler(result.token);
                }
            });
        });

        function stripeTokenHandler(token) {
            var form = document.getElementById('stripe-payment');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            form.submit();
        }

        @endif


    </script>
@endpush
@section('breadcrumb')
    <ul class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{route('dashboard')}}"><h1>{{__('Dashboard')}}</h1></a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{route('subscriptions.index')}}">{{__('Subscription')}}</a>
        </li>
        <li class="breadcrumb-item active">
            <a href="#">{{__('Details')}}</a>
        </li>
    </ul>
@endsection
@section('content')
    <div class="row pricing-grid">
        <div class="col-xxl-3 cdx-xl-50 col-sm-6">
            <div class="codex-pricingtbl">
                <div class="price-header">
                    <h2>{{$subscription->name}}</h2>
                    <div class="price-value">{{env('CURRENCY_SYMBOL').$subscription->price}}
                        <span>/ {{$subscription->duration}}</span></div>
                </div>
                <ul class="cdxprice-list">
                    <li><span>{{$subscription->total_user}}</span>{{__('Users Limit')}}</li>
                    <li><span>{{$subscription->total_property}}</span>{{__('Property Limit')}}</li>
                    <li><span>{{$subscription->total_tenant}}</span>{{__('Tenant Limit')}}</li>
                </ul>
            </div>
        </div>
        <div class="col-lg-9">
            @if(env('STRIPE_PAYMENT') == 'on' && !empty(env('STRIPE_KEY')) && !empty(env('STRIPE_SECRET')))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body profile-user-box">
                                <form
                                    action="{{ route('subscription.stripe.payment',\Illuminate\Support\Facades\Crypt::encrypt($subscription->id)) }}"
                                    method="post" class="require-validation" id="stripe-payment">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="card-name-on"
                                                       class="form-label text-dark">{{__('Card Name')}}</label>
                                                <input type="text" name="name" id="card-name-on"
                                                       class="form-control required" placeholder="{{__('Card Holder Name')}}">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div id="card-element">
                                            </div>
                                            <div id="card-errors" role="alert"></div>
                                        </div>
                                        <div class="col-sm-12 mt-15">
                                            <input type="submit" value="{{__('Pay')}}" class="btn btn-primary">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

