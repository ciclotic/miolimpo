@extends('layouts.app')

@section('title'){{ __('ctic_shop.details_address_book') }}@stop

@section('content')

<div class="row">
    @include('account/account-menu')
    <div class="col-md-9">
        {!! Form::open(['route' => 'account.store-address-book', 'autocomplete' => 'off']) !!}
        <h1>
            {{ __('ctic_shop.details_address_book') }}
        </h1>

        @include('account.address_book._form')
        <div class="row">
            <div class="col-md-6 col-6">
                <button class="btn btn-success btn-block">{{ __('ctic_shop.create_address_book') }}</button>
            </div>
            <div class="col-md-6 col-6">
                <a href="#" onclick="history.back();" class="btn btn-link btn-block text-muted">{{ __('ctic_shop.cancel') }}</a>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@stop
