@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        @include('account/account-menu')
        <div class="col-md-7 mt-3">
            <h4>{{ __('ctic_shop.my_orders') }}</h4>
        </div>
    </div>
</div>
@endsection
