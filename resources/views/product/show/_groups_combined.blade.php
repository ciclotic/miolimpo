<style>
    .group-product {
        font-size: 14px;
        font-weight: bold;
    }
    .product-group-price {
        font-size: 18px;
        text-align: right;
    }
</style>
@foreach($product->groups as $key => $group)
    @if($agent->isMobile())

    @else
        <div class="row mt-2">
            <div class="col-md-12 mt-2">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapse{{ $key }}" aria-expanded="false" aria-controls="multiCollapse{{ $key }}">{{ $group->name }}</button>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="collapse multi-collapse" id="multiCollapse{{ $key }}">
                    <div class="card card-body">
                        @foreach($group->groupProducts as $keyGroupProduct => $groupProduct)
                            <div class="row group-product">
                                <div class="col-md-8">
                                    {{ $groupProduct->name }}
                                </div>
                                <div class="col-md-4 mt-2 product-group-price text-primary">
                                    <span id="product-price-{{ $key }}-{{ $keyGroupProduct }}">{{ number_format($groupProduct->price, 2, ',', '.') }}</span> {{ config('vanilo.framework.currency.sign') }}
                                </div>
                            </div>
                            @if (\App\Ctic\Product\Models\Product::ARCHETYPES[$groupProduct->archetype] === 'multiple')
                                @include('product.show._group_complements_multiple', ['product' => $groupProduct])
                            @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$groupProduct->archetype] === 'unique')
                                @include('product.show._group_complements_unique', ['product' => $groupProduct])
                            @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$groupProduct->archetype] === 'various')
                                @include('product.show._group_complements_various', ['product' => $groupProduct])
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
@endforeach
