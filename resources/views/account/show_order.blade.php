@extends('layouts.app')

@section('title'){{ __('ctic_shop.my_orders') }}@stop

@section('content')
    <div class="container">
        <div class="row">
            @include('account/account-menu')
            <div class="col-md-9 mt-3">
                <div class="row">
                    <div class="col-md-12">
                        @include('account.order_show._cards')
                    </div>
                    <div class="col-md-12 mt-3">
                        @include('account.order_show._addresses')
                    </div>
                    <div class="col-md-12 mt-3">
                        @include('account.order_show._items')
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
