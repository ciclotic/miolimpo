@extends('layouts.app')

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

            <hr>

            <div class="card">
                <div class="card-block">
                    <h6 class="card-title">{{ __('ctic_admin.group_products') }}</h6>

                    <table class="table">
                        <tr>
                            <td>
                                @foreach($group->groupProducts as $groupProduct)
                                    <span class="badge badge-pill badge-dark">
                            {{ $groupProduct->name }}:
                            {{ __('ctic_admin.is_modifiable') }}: {{ ($groupProduct->pivot->group_modifiable) ? __('ctic_admin.yes') : __('ctic_admin.no') }}
                        </span>
                                @endforeach
                            </td>
                            <td class="text-right">
                                <button type="button" data-toggle="modal"
                                        data-target="#group_products-modal"
                                        class="btn btn-outline-success btn-sm">{{ __('ctic_admin.edit') }}</button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>

            @include('admin.group_product._form', [
                'group' => $group,
                'productsElegibleAsGroupProduct' => $productsElegibleAsGroupProduct
            ])
        </div>

        <div class="card-footer">
            <button class="btn btn-primary">{{ __('ctic_admin.save') }}</button>
            <a href="#" onclick="history.back();" class="btn btn-link text-muted">{{ __('ctic_admin.cancel') }}</a>
        </div>
    </div>

{!! Form::close() !!}
@stop
