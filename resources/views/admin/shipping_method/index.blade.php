@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.shipping_methods') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create shipping_methods')
                    <a href="{{ route('admin.shipping_method.create') }}" class="btn btn-sm btn-outline-success float-right">
                        <i class="zmdi zmdi-plus"></i>
                        {{ __('ctic_admin.new_shipping_method') }}
                    </a>
                @endcan
            </div>

        </div>

        <div class="card-block">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('ctic_admin.name') }}</th>
                    <th style="width: 10%">&nbsp;</th>
                </tr>
                </thead>

                <tbody>
                @foreach($shipping_methods as $shipping_method)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view shipping_methods')
                                <a href="{{ route('admin.shipping_method.show', $shipping_method) }}">{{ $shipping_method->name }}</a>
                            @else
                                {{ $shipping_method->name }}
                            @endcan
                            </span>
                        </td>
                        <td>
                            @can('edit shipping_methods')
                                <a href="{{ route('admin.shipping_method.edit', $shipping_method) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('ctic_admin.edit') }}</a>
                            @endcan

                            @can('delete shipping_methods')
                                {{ Form::open([
                                    'url' => route('admin.shipping_method.destroy', $shipping_method),
                                    'data-confirmation-text' => __('ctic_admin.delete_this_shipping_method', ['name' => $shipping_method->name]),
                                    'method' => 'DELETE'
                                ])}}
                                    <button class="btn btn-xs btn-outline-danger btn-show-on-tr-hover float-right">{{ __('ctic_admin.delete') }}</button>
                                {{ Form::close() }}
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

        </div>
    </div>

@stop
