@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('ctic_shop.all_products') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">{{ __('ctic_shop.cart') }}</a></li>
    <li class="breadcrumb-item">{{ __('ctic_shop.checkout') }}</li>
    <li class="breadcrumb-item">{{ __('ctic_shop.order_complete') }}</li>

@stop

@section('content')
    <div class="container">
        <h1>{{ __('ctic_shop.wonderful') }} {{ $order->getBillpayer()->firstname }}!</h1>
        <hr>

        <div class="alert alert-success">
            {{ __('ctic_shop.order_registered') }}<strong>{{ $order->getNumber() }}</strong>.
        </div>

        <h3>{{ __('ctic_shop.next_steps') }}</h3>

        {{ setting('ctic.general.defaults.thankyou_next_steps') }}

        <div>
            @if (empty($redsysVersion) && empty($paypalBussinessEmail) && empty($stripeSessionId))
                <a href="{{ route('product.index') }}" class="btn btn-primary">{{ __('ctic_shop.all_right') }}</a>
            @endif
            @if (! empty($redsysVersion))
                @if (setting('ctic.payment.redsys.sandbox'))
                    <form id="form_pago_sermepa" name="pago_sermepa" action="https://sis-t.redsys.es:25443/sis/realizarPago" method="post" target="_self">
                @else
                    <form id="form_pago_sermepa" name="pago_sermepa" action="https://sis.redsys.es/sis/realizarPago" method="post" target="_self">
                @endif
                    <input type="hidden" name="Ds_SignatureVersion" value="{{ $redsysVersion }}"/><br>
                    <input type="hidden" name="Ds_MerchantParameters" value="{{ $redsysParams }}"/><br>
                    <input type="hidden" name="Ds_Signature" value="{{ $redsysSignature }}"/><br>
                    <input type="submit" class="btn btn-primary" value="{{ __('ctic_shop.pay') }}">
                </form>
            @endif
            @if (! empty($stripeSessionId))
                <input type="button" id="stripePayButton" class="btn btn-primary" value="{{ __('ctic_shop.pay') }}" />
                <script type="text/javascript">
                    // Create an instance of the Stripe object with your publishable API key
                    var stripe = Stripe("{{ $stripePublicKey }}");
                    var checkoutButton = document.getElementById("stripePayButton");
                    checkoutButton.addEventListener("click", function () {
                        return stripe.redirectToCheckout({ sessionId: '{{ $stripeSessionId }}' });
                    })
                </script>
            @endif
            @if (! empty($paypalBussinessEmail))
                @if (setting('ctic.payment.paypal.sandbox'))
                    <form id="form_pago_paypal" name="pago_paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                @else
                    <form id="form_pago_paypal" name="pago_paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                @endif
                    <input type="hidden" name="cmd" value="_cart">
                    <input type="hidden" name="upload" value="1">
                    <input type="hidden" name="invoice" value="{{ $order->id }}">
                    <input type="hidden" name="item_name_1" value="Importe total del pedido {{ $order->total() }}">
                    <input type="hidden" name="quantity_1" value="1">
                    <input type="hidden" name="amount_1" value="{{ number_format($order->total(),2,".","") }}">
                    <input type="hidden" name="business" value="{{ setting('ctic.payment.paypal.business_email') }}">
                    <input type="hidden" name="no_shipping" value="1">
                    <input type="hidden" name="no_note" value="0">
                    <input type="hidden" name="currency_code" value="EUR">
                    <input type="hidden" name="lc" value="ES">
                    <input type="hidden" name="notify_url" value="{{ route('checkout.pay-paypal') }}">
                    <input type="hidden" name="bn" value="{{ setting('ctic.payment.paypal.business_number') }}">
                    <input type="hidden" name="return" value="{{ route('product.index') }}">

                    <input type="submit" class="btn btn-primary" value="{{ __('ctic_shop.pay') }}">

                </form>
            @endif
        </div>

    </div>
@endsection
