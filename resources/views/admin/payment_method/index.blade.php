@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.payment_methods') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create payment_methods')
                    <a href="{{ route('admin.payment_method.create') }}" class="btn btn-sm btn-outline-success float-right">
                        <i class="zmdi zmdi-plus"></i>
                        {{ __('ctic_admin.new_payment_method') }}
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
                @foreach($payment_methods as $payment_method)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view payment_methods')
                                <a href="{{ route('admin.payment_method.show', $payment_method) }}">{{ $payment_method->name }}</a>
                            @else
                                {{ $payment_method->name }}
                            @endcan
                            </span>
                        </td>
                        <td>
                            @can('edit payment_methods')
                                <a href="{{ route('admin.payment_method.edit', $payment_method) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('ctic_admin.edit') }}</a>
                            @endcan

                            @can('delete payment_methods')
                                {{ Form::open([
                                    'url' => route('admin.payment_method.destroy', $payment_method),
                                    'data-confirmation-text' => __('ctic_admin.delete_this_payment_method', ['name' => $payment_method->name]),
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
