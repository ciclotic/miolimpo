@extends('appshell::layouts.default')

@section('title')
    {{ $shipping_method->name }} {{ __('ctic_admin.shipping_method') }}
@stop

@section('content')

    <div class="card">
        <div class="card-block">
            @can('edit shipping_methods')
                <a href="{{ route('admin.shipping_method.edit', $shipping_method) }}" class="btn btn-outline-primary">{{ __('ctic_admin.edit_shipping_method') }}</a>
            @endcan

            @can('delete shipping_methods')
                {!! Form::open([
                        'route' => ['admin.shipping_method.destroy', $shipping_method],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('ctic_admin.delete_this_shipping_method', ['name' => $shipping_method->name])
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
