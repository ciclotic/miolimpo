@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.product_groups') }}
@stop

@section('content')

    <div class="card card-accent-secondary">

        <div class="card-header">
            @yield('title')

            <div class="card-actionbar">
                @can('create groups')
                    <a href="{{ route('admin.group.create') }}" class="btn btn-sm btn-outline-success float-right">
                        <i class="zmdi zmdi-plus"></i>
                        {{ __('ctic_admin.new_group') }}
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
                @foreach($groups as $group)
                    <tr>
                        <td>
                            <span class="font-lg mb-3 font-weight-bold">
                            @can('view groups')
                                <a href="{{ route('admin.group.show', $group) }}">{{ $group->name }}</a>
                            @else
                                {{ $group->name }}
                            @endcan
                            </span>
                        </td>
                        <td>
                            @can('edit groups')
                                <a href="{{ route('admin.group.edit', $group) }}"
                                   class="btn btn-xs btn-outline-primary btn-show-on-tr-hover float-right">{{ __('ctic_admin.edit') }}</a>
                            @endcan

                            @can('delete groups')
                                {{ Form::open([
                                    'url' => route('admin.group.destroy', $group),
                                    'data-confirmation-text' => __('ctic_admin.delete_this_group', ['name' => $group->name]),
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
