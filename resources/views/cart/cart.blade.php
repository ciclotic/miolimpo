<style>
    .product-image {
        height: 25px;
    }
</style>

<h1>{{ __('ctic_shop.shopping_cart') }}</h1>
<hr>

@if(Cart::isEmpty())
    <div class="alert alert-info">
        {{ __('ctic_shop.empty_cart') }}
    </div>
@else
    <div class="row">
        <div class="col-md-12">
            <div class="card bg-light">
                <div class="card-header">{{ __('ctic_shop.items') }}</div>

                <div class="card-body bg-white">
                    <div class="rounded ">
                        <table class="table table-borderless">
                            @if(! $agent->isMobile())
                                <thead>
                                    <tr>
                                        <th colspan="2">{{ __('ctic_shop.name') }}</th>
                                        <th>{{ __('ctic_shop.qty') }}</th>
                                        <th>{{ __('ctic_shop.total') }}</th>
                                        <th></th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>
                            @if($agent->isMobile())

                                @foreach(Cart::getItems() as $item)
                                    <div class="row">
                                        <div class="col-3"><img src="{{ $item->product->getThumbnailUrl() ?: '/images/product.jpg' }}" class="product-image"/></div>
                                        <div class="col-9">
                                            <a href="{{ route('product.show', [($item->product->taxons->first()) ? $item->product->taxons->first()->slug : $taxons->first()->slug, $item->product]) }}">
                                                {{ $item->product->getName() }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-6">
                                            {{ $item->quantity }}
                                        </div>
                                        <div class="col-3">{{ format_price(number_format($item->total, 2, ',', '.')) }}</div>
                                        <div class="col-3">
                                            <form action="{{ route('cart.remove', $item) }}"
                                                  style="display: inline-block" method="post">
                                                {{ csrf_field() }}
                                                <button dusk="cart-delete-{{ $item->getBuyable()->id }}" class="btn btn-link btn-sm"><span class="text-danger">&xotime;</span></button>
                                            </form>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="row">
                                    <div class="col-6">&nbsp;</div>
                                    <div class="col-6">
                                        {{ format_price(number_format(Cart::total(), 2, ',', '.')) }}
                                    </div>
                                </div>
                            @else
                                <?php $lastGroup = null ?>
                                @foreach (Cart::getItems() as $item)
                                    @if ($item->group && (empty($lastGroup) || $lastGroup->id !== $item->group->id))
                                        <?php $lastGroup = $item->group ?>
                                        <tr>
                                            <td colspan="6">
                                                {{ $item->group->name }}
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td width="5%"><img src="{{ $item->product->getThumbnailUrl() ?: '/images/product.jpg' }}" class="product-image"/></td>
                                        <td width="55%">
                                            <a href="{{ route('product.show', [($item->product->taxons->first()) ? $item->product->taxons->first()->slug : $taxons->first()->slug, $item->product]) }}">
                                                @if ($item->parent && \App\Ctic\Product\Models\Product::ARCHETYPES[$item->parent->product->archetype] === 'combined')
                                                    -
                                                @elseif ($item->parent && \App\Ctic\Product\Models\Product::ARCHETYPES[$item->parent->product->archetype] === 'multiple')
                                                    >
                                                @elseif ($item->parent && \App\Ctic\Product\Models\Product::ARCHETYPES[$item->parent->product->archetype] === 'unique')
                                                    |
                                                @elseif ($item->parent && \App\Ctic\Product\Models\Product::ARCHETYPES[$item->parent->product->archetype] === 'various')
                                                    /
                                                @endif
                                                {{ $item->product->getName() }}
                                            </a></td>
                                        <td width="7%">
                                            {{ $item->quantity }}
                                        </td>
                                        <td width="26%">{{ format_price(number_format($item->total, 2, ',', '.')) }}</td>
                                        <td width="2%">
                                            <form action="{{ route('cart.remove', $item) }}"
                                                  style="display: inline-block" method="post">
                                                {{ csrf_field() }}
                                                <button dusk="cart-delete-{{ $item->getBuyable()->id }}" class="btn btn-link btn-sm"><span class="text-danger">&xotime;</span></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th colspan="3"></th>
                                        <th>
                                            {{ format_price(number_format(Cart::total(), 2, ',', '.')) }}
                                        </th>
                                        <th></th>
                                    </tr>
                                </tfoot>
                            @endif

                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 mt-3">
            <div class="card bg-white">
                <div class="card-header">{{ __('ctic_shop.summary') }}</div>
                <div class="card-body">
                    @include('cart._summary')
                    <a href="{{ route('checkout.show') }}" class="btn btn-block btn-primary">{{ __('ctic_shop.proceed_to_checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
@endif
