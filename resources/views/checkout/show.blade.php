@extends('layouts.app')

@section('title'){{ __('ctic_shop.checkout') }}@stop

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('ctic_shop.all_products') }}</a></li>
    <li class="breadcrumb-item"><a href="{{ route('cart.show') }}">{{ __('ctic_shop.cart') }}</a></li>
    <li class="breadcrumb-item">{{ __('ctic_shop.checkout') }}</li>

@stop

@section('content')
    <style>
        .product-image {
            max-width: 100%;
            display: block;
            margin-bottom: 2em;
        }
    </style>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('ctic_shop.checkout') }}</div>

                    <div class="card-body">
                        @unless ($checkout)
                            <div class="alert alert-warning">
                                <p>{{ __('ctic_shop.nothing_checkout') }}</p>
                            </div>
                        @endunless

                        @if ($checkout)
                            @if (!empty($address_books[0]))
                                <div class="row mb-4">
                                    <div class="col-9">
                                        <select class="custom-select mr-sm-2" id="addresse_used">
                                            <option selected value="0">{{ $address_books[0]->name }}</option>
                                            @for ($i = 1; $i < count($address_books); $i++)
                                                <option value="{{ $i }}">{{ $address_books[$i]->name }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-3">
                                        <button type="submit" class="btn btn-primary btn-block" onclick="useAddressBook($('#addresse_used').val())">{{ __('ctic_shop.use') }}</button>
                                    </div>
                                </div>
                            @endif

                            <form id="checkout" action="{{ route('checkout.submit') }}" method="post">
                                {{ csrf_field() }}

                                @include('checkout._billpayer', ['billpayer' => $checkout->getBillPayer()])

                                <div class="mb-4">
                                    <input type="hidden" name="ship_to_billing_address" value="0" />
                                    <div class="form-check">
                                        <input class="form-check-input" id="chk_ship_to_billing_address" type="checkbox" name="ship_to_billing_address" value="1" v-model="shipToBillingAddress">
                                        <label class="form-check-label" for="chk_ship_to_billing_address">Ship to the same address</label>
                                    </div>
                                </div>

                                @include('checkout._shipping_address', ['address' => $checkout->getShippingAddress()])

                                <hr>

                                <div class="form-group">

                                    <label class="">{{ __('ctic_shop.payment_methods') }}</label>

                                    <?php $firstChecked = false; ?>
                                    @foreach ($payment_methods as $payment_method)
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="radio" name="payment_method_id" id="payment_method-{{ $payment_method->id }}" value="{{ $payment_method->id }}" @if (! $firstChecked) <?php $firstChecked = true; ?> checked @endif>
                                            <label class="form-check-label" for="payment_method-{{ $payment_method->id }}">
                                                <strong>{{ $payment_method->name }}</strong>
                                            </label>
                                        </div>
                                        <div>
                                            {{ $payment_method->observation }}
                                        </div>
                                    @endforeach
                                </div>

                                <hr>

                                <div class="form-group">

                                    <label class="">{{ __('ctic_shop.shipping_methods') }}</label>

                                    <?php $firstChecked = false; ?>
                                    @foreach ($shipping_methods as $key => $shipping_method)
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" onclick="selectShippingPrice({{ $key }})" type="radio" name="shipping_method_id" id="shipping_method-{{ $shipping_method->id }}" value="{{ $shipping_method->id }}"  @if (! $firstChecked) <?php $firstChecked = true; ?> checked @endif>
                                            <label class="form-check-label" for="shipping_method-{{ $shipping_method->id }}">
                                                <strong>{{ $shipping_method->name }}</strong>
                                            </label>
                                        </div>
                                        <div>
                                            {{ $shipping_method->observation }}
                                        </div>
                                    @endforeach
                                </div>

                                <hr>

                                <div class="form-group">

                                    <label class="">{{ __('ctic_shop.order_notes_phone') }}</label>
                                    {{ Form::textarea('notes', null, [
                                            'class' => 'form-control' . ($errors->has('notes') ? ' is-invalid' : ''),
                                            'rows' => 3
                                        ])
                                    }}
                                    @if ($errors->has('notes'))
                                        <div class="invalid-feedback">{{ $errors->first('notes') }}</div>
                                    @endif
                                </div>

                                <hr>

                                <div>
                                    <button class="btn btn-lg btn-primary btn-block">Submit Order</button>
                                </div>


                            </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card bg-white">
                    <div class="card-header">Summary</div>
                    <div class="card-body">
                        @include('cart._summary')
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @if ($checkout)
    <script>
        function useAddressBook(index) {
            $('input[name="billpayer[firstname]"]').val(window.addressBooks[index].addressee_name)
            $('input[name="billpayer[lastname]"]').val(window.addressBooks[index].addressee_surname)
            $('input[name="shippingAddress[name]"]').val(window.addressBooks[index].addressee_name + ' ' + window.addressBooks[index].addressee_surname)
            $('input[name="billpayer[address][address]"]').val(window.addressBooks[index].address + ' ' + window.addressBooks[index].address2)
            $('input[name="shippingAddress[address]"]').val(window.addressBooks[index].address + ' ' + window.addressBooks[index].address2)
            $('input[name="billpayer[address][postalcode]"]').val(window.addressBooks[index].postal_code)
            $('input[name="shippingAddress[postalcode]"]').val(window.addressBooks[index].postal_code)
            $('input[name="billpayer[address][city]"]').val(window.addressBooks[index].town)
            $('input[name="shippingAddress[city]"]').val(window.addressBooks[index].town)
        }
        @if (!empty($address_books[0]))
            window.addressBooks = []
            @for ($i = 0; $i < count($address_books); $i++)
                window.addressBooks[{{ $i }}] = {}
                window.addressBooks[{{ $i }}].addressee_name = '{{ $address_books[$i]->addressee_name }}'
                window.addressBooks[{{ $i }}].addressee_surname = '{{ $address_books[$i]->addressee_surname }}'
                window.addressBooks[{{ $i }}].address = '{{ $address_books[$i]->address }}'
                window.addressBooks[{{ $i }}].address2 = '{{ $address_books[$i]->address2 }}'
                window.addressBooks[{{ $i }}].postal_code = '{{ $address_books[$i]->postal_code }}'
                window.addressBooks[{{ $i }}].town = '{{ $address_books[$i]->town }}'
                window.addressBooks[{{ $i }}].phone = '{{ $address_books[$i]->phone }}'
            @endfor
            $( document ).ready(function() {
                useAddressBook(0)
            })
        @endif
        function selectShippingPrice(index) {
            $('#shipping_price').html(window.shippingMethods[index].price.toFixed(2) + ' €')
            $('#total_price').html((parseFloat($('#total_price').data('total-without-shipping').replace('.', '').replace(',', '.')) + window.shippingMethods[index].price).toFixed(2) + ' €')
        }
        @if (!empty($shipping_methods[0]))
            window.shippingMethods = []
            @for ($i = 0; $i < count($shipping_methods); $i++)
                window.shippingMethods[{{ $i }}] = {}
                window.shippingMethods[{{ $i }}].name = '{{ $shipping_methods[$i]->name }}'
                window.shippingMethods[{{ $i }}].id = '{{ $shipping_methods[$i]->id }}'
                window.shippingMethods[{{ $i }}].price = parseFloat({{ $shipping_methods[$i]->price }})
            @endfor
            $( document ).ready(function() {
                selectShippingPrice(0)
            })
        @endif
        document.addEventListener("DOMContentLoaded", function(event) {
            new Vue({
                el: '#checkout',
                data: {
                    isOrganization: {{ old('billpayer.is_organization') ?: 0 }},
                    shipToBillingAddress: {{ old('ship_to_billing_address') ?? 1 }}
                }
            });
        });
    </script>
    @endif
@stop

