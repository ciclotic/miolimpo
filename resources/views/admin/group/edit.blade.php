@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.editing') }} {{ $group->name }}
@stop

@section('content')
{!! Form::model($group, [
        'route'  => ['admin.group.update', $group],
        'method' => 'PUT'
    ])
!!}

    <div class="card card-accent-secondary">
        <div class="card-header">
            {{ __('ctic_admin.details_group') }}
        </div>

        <div class="card-block">
            @include('admin.group._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('ctic_admin.save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('ctic_admin.cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
