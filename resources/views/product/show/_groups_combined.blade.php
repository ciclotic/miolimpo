<style>
    .group-product {
        font-size: 14px;
        font-weight: bold;
    }
    .product-group-price {
        font-size: 18px;
        text-align: right;
    }
    .btn-group-products-elected {
        cursor: default !important;
    }
    .group-product-remove {
        cursor: pointer;
    }
</style>
<form action="{{ route('cart.add', $product) }}" id="product-combined-form" method="post" class="mb-4">
    {{ csrf_field() }}
    @foreach($product->groups as $key => $group)
        <div class="row mt-2">
            <div class="col-md-12 mt-2">
                <span class="btn btn-block btn-light btn-group-products-elected">{{ $group->name }} {{ __('ctic_shop.elected') }}</span>
            </div>
            <div class="col-md-12" id="elected-group-products-{{ $key }}">
                &nbsp;
            </div>
        </div>
    @endforeach
</form>
@foreach($product->groups as $key => $group)
    <div class="row mt-2">
        <div class="col-md-12 mt-2">
            <button class="btn btn-block btn-primary" type="button" data-toggle="collapse" data-target="#multiCollapse{{ $key }}" aria-expanded="false" aria-controls="multiCollapse{{ $key }}">{{ $group->name }}</button>
        </div>
    </div>
    <div class="row">
        <div class="col">
            <div class="collapse multi-collapse @if (empty($group->collapsed)) show @endif" id="multiCollapse{{ $key }}">
                <div class="card card-body">
                    <?php $firstGroupProduct = true ?>
                    @foreach($group->groupProducts as $keyGroupProduct => $groupProduct)
                        @if ($firstGroupProduct)
                            <?php $firstGroupProduct = false ?>
                        @else
                            <hr>
                        @endif
                        <div class="row group-product">
                            <div class="col-md-2 col-2">
                                <img class="mw-100" src="{{ $groupProduct->getMedia()->first() ? $groupProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
                            </div>
                            <div class="col-md-6 col-6">
                                {{ $groupProduct->name }}
                            </div>
                            <div class="col-md-4 col-3 mt-2 product-group-price text-primary">
                                @if ($groupProduct->pivot->price > 0)
                                    <span id="product-price-{{ $groupProduct->id }}">{{ number_format($groupProduct->pivot->price, 2, ',', '.') }}</span> {{ config('vanilo.framework.currency.sign') }}
                                @else
                                    <span id="product-price-{{ $groupProduct->id }}">&nbsp;</span>
                                @endif
                            </div>
                        </div>
                        <?php $archetype = ($groupProduct->archetype)? $groupProduct->archetype : 0 ?>
                        @if (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'multiple')
                            @include('product.show._group_complements_multiple', ['product' => $groupProduct])
                        @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'unique')
                            @include('product.show._group_complements_unique', ['product' => $groupProduct])
                        @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'various')
                            @include('product.show._group_complements_various', ['product' => $groupProduct])
                        @endif
                        <button class="btn btn-block btn-light" type="button" onclick="addGroupProduct({{ $key }}, {{ $groupProduct->id }}, '{{ $groupProduct->name }}')">{{ __('ctic_shop.add') }}</button>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endforeach

@section('scripts')
    @parent()
    <script>
        function addGroupProduct(productGroupKey, groupProductId, groupProductName) {
            let groupLayer = $('#elected-group-products-' + productGroupKey)

            let newHTML = groupLayer.html()

            newHTML = newHTML + '<div class="row"><input type="hidden" name="products-to-complements-selected[' + groupProductId + ']" value="1"><div class="col-md-10 col-9">' + groupProductName + '</div><div class="col-md-2 col-2 group-product-remove" onclick="$(this).parent().remove()">X</div>'

            let groupProductComplementsLayer = $('.group-product-complement-' + groupProductId + ' .form-check-input:checked')

            for (let i = 0; i < groupProductComplementsLayer.length; i++) {
                let newInputTypeHidden = groupProductComplementsLayer.eq(i)
                let newNameLayer = groupProductComplementsLayer.eq(i).closest('.group-product-complement-' + groupProductId).find('.complement-name').eq(0).html()

                if (newInputTypeHidden.attr('name')[newInputTypeHidden.attr('name').length - 1] === ']')
                {
                    newHTML = newHTML + '<input type="hidden" name="' + newInputTypeHidden.attr('name') + '" value="1">'
                } else {
                    newHTML = newHTML + '<input type="hidden" name="' + newInputTypeHidden.attr('name') + '[' + newInputTypeHidden.attr('value') + ']" value="1">'
                }

                newHTML = newHTML + '<div class="col-md-1 col-1">&nbsp;</div><div class="col-md-11 col-10">' + newNameLayer + '</div>'
            }

            newHTML = newHTML + '</div>'

            groupLayer.html(newHTML)
        }
        function changeComplementFromGroupProduct(groupProductId, productComplementId, price) {
            let productPrice = $('#product-price-' + groupProductId)
            let inputComplementId = $('input[name="products-to-complements-selected[' + productComplementId + ']"]').is(':checked')

            if (inputComplementId) {
                // SUM
                productPrice.html(
                    (
                        parseFloat(productPrice.html().replace('.', '').replace(',', '.')) +
                        parseFloat(price.replace('.', '').replace(',', '.'))
                    ).toFixed(2).toString().replace('.', ',')
                )
            } else {
                // SUBSTRACT
                productPrice.html(
                    (
                        parseFloat(productPrice.html().replace('.', '').replace(',', '.')) -
                        parseFloat(price.replace('.', '').replace(',', '.'))
                    ).toFixed(2).toString().replace('.', ',')
                )
            }
        }
        @foreach($group->groupProducts as $keyGroupProduct => $groupProduct)
            @foreach($groupProduct->complementProducts as $complementProduct)
                @if ($complementProduct->pivot->selected)
                    @if ($groupProduct->pivot->price > 0)
                        changeComplementFromGroupProduct({{ $groupProduct->id }}, {{ $complementProduct->id }}, '{{ number_format($complementProduct->price, 2, ',', '.') }}')
                    @endif
                @endif
            @endforeach
        @endforeach
    </script>
@endsection
