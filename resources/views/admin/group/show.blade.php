@extends('appshell::layouts.default')

@section('title')
    {{ $group->name }} {{ __('ctic_admin.group') }}
@stop

@section('content')

    <div class="card">
        <div class="card-block">
            @can('edit groups')
                <a href="{{ route('admin.group.edit', $group) }}" class="btn btn-outline-primary">{{ __('ctic_admin.edit_group') }}</a>
            @endcan

            @can('delete groups')
                {!! Form::open([
                        'route' => ['admin.group.destroy', $group],
                        'method' => 'DELETE',
                        'class' => 'float-right',
                        'data-confirmation-text' => __('ctic_admin.delete_this_group', ['name' => $group->name])
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
