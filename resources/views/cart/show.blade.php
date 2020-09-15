@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('ctic_shop.all_products') }}</a></li>
    <li class="breadcrumb-item">{{ __('ctic_shop.cart') }}</li>
@stop

@section('content')
    <div class="container">
        @include('cart.cart')
    </div>
@endsection
