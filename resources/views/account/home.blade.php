@extends('layouts.app')

@section('title'){{ __('ctic_shop.my_orders') }}@stop

@section('content')
<div class="container">
    <div class="row">
        @include('account/account-menu')
        <div class="col-md-9 mt-3">
            <h4>{{ __('ctic_shop.my_orders') }}</h4>

            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>{{ __('ctic_shop.number') }}</th>
                    <th>{{ __('ctic_shop.ordered') }}</th>
                    <th>{{ __('ctic_shop.ship_to') }}</th>
                    <th>{{ __('ctic_shop.status') }}</th>
                </tr>
                </thead>

                <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td>
                    <span class="font-lg mb-3 font-weight-bold">
                    @can('view orders')
                            <a href="{{ route('account.show-order', $order) }}">{{ $order->number }}</a>
                        @else
                            {{ $order->number }}
                        @endcan
                    </span>
                            <div class="text-muted">
                                {{ $order->billpayer->getName() }}
                            </div>
                        </td>
                        <td>
                    <span class="mb-3" title="{{ $order->created_at }}">
                        {{ $order->created_at->diffForHumans() }}
                    </span>
                            <div class="text-muted" title="{{ __('Order Total') }}">
                                {{ format_price($order->total()) }}
                            </div>
                        </td>
                        <td>
                            <?php $shippingAddress = $order->getShippingAddress(); ?>
                            @if($shippingAddress)
                                <span class="mb-3">
                         {{ $shippingAddress->getCity() }}
                        </span>
                                <div class="text-muted">{{ $shippingAddress->country->name }}</div>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <div class="mt-2">
                        <span class="badge badge-pill badge-{{$order->status->is_completed ? 'success' : 'secondary'}}">
                            {{ $order->status->label() }}
                        </span>
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>

            </table>

            @if($orders->hasPages())
                <hr>
                <nav>
                    {{ $orders->links() }}
                </nav>
            @endif
        </div>
    </div>
</div>
@endsection
