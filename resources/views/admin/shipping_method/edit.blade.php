@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.editing') }} {{ $shipping_method->name }}
@stop

@section('content')
{!! Form::model($shipping_method, [
        'route'  => ['admin.shipping_method.update', $shipping_method],
        'method' => 'PUT'
    ])
!!}

    <div class="card card-accent-secondary">
        <div class="card-header">
            {{ __('ctic_admin.details_shipping_method') }}
        </div>

        <div class="card-block">
            @include('admin.shipping_method._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('ctic_admin.save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('ctic_admin.cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
