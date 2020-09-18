@extends('appshell::layouts.default')

@section('title')
    {{ __('ctic_admin.create_group') }}
@stop

@section('content')
{!! Form::open(['route' => 'admin.group.store', 'autocomplete' => 'off']) !!}

    <div class="card card-accent-success">

        <div class="card-header">
            {{ __('ctic_admin.details_group') }}
        </div>

        <div class="card-block">
            @include('admin.group._form')
        </div>

        <div class="card-footer">
            <button class="btn btn-success">{{ __('ctic_admin.create_group') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('ctic_admin.cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
