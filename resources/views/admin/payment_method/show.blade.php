@extends('appshell::layouts.default')

@section('title')
    {{ $payment_method->name }} {{ __('ctic_admin.payment_method') }}
@stop

@section('content')

    <div class="card">
        <div class="card-block">
            @can('edit payment_methods')
                <a href="{{ route('admin.payment_method.edit', $payment_method) }}" class="btn btn-outline-primary">{{ __('ctic_admin.edit_payment_method') }}</a>
            @endcan

            @can('delete payment_methods')
                {!! Form::open([
                        'route' => ['admin.payment_method.destroy', $payment_method],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('ctic_admin.delete_this_payment_method', ['name' => $payment_method->name])
                    ])
                !!}
                <button class="btn btn-outline-danger">
                    {{ __('ctic_admin.delete') }}
                </button>
                {!! Form::close() !!}
            @endcan
        </div>
    </div>

@stop
