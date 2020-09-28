@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.create_shipping_method') }}
@stop

@section('content')
{!! Form::open(['route' => 'admin.shipping_method.store', 'autocomplete' => 'off']) !!}

    <div class="card card-accent-success">

        <div class="card-header">
            {{ __('ctic_admin.details_shipping_method') }}
        </div>

        <div class="card-block">
            @include('admin.shipping_method._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('ctic_admin.create_shipping_method') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('ctic_admin.cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
