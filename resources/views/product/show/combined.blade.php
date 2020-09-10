<div class="container">
    <div class="row">
        @include('product.show._photo')

        <div class="col-md-6">
            @include('product.show._buy_combined')
            @include('product.show._groups_combined')

            @unless(empty($product->propertyValues))
                <table class="table table-sm">
                    <tbody>
                    @foreach($product->propertyValues as $propertyValue)
                        <tr>
                            <th>{{ $propertyValue->property->name }}</th>
                            <td>{{ $propertyValue->title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <hr>
            @endunless

            @unless(empty($product->description))
                <hr>
                <p class="text-secondary">{!!  nl2br($product->description) !!}</p>
                <hr>
            @endunless

        </div>
    </div>
</div>

@section('scripts')
    @parent()
    <script>
        function changeCombined() {
            let productQuantity = $('#quantity-field')
            let productPrice = $('#product-price')
            let unitCombinedPrice = parseFloat($('#unit-product-price').html().replace('.', '').replace(',', '.'))
            let maxProductQuantity = 1

            let groupProducts = $('.group-products')

            groupProducts.each(function (index, groupProduct) {
                groupProduct = $(groupProduct)
                let elementsGroup = groupProduct.find('.group-element')
                let quantityElementsGroup = elementsGroup.length

                if (quantityElementsGroup > maxProductQuantity) {
                    maxProductQuantity = quantityElementsGroup
                }
            })

            productPrice.html(
                (
                    parseFloat(unitCombinedPrice) +
                    ((maxProductQuantity - 1) * unitCombinedPrice)
                ).toFixed(2).toString().replace('.', ',')
            )

            // Sum complements with price
            let productsASComplementsSelected = $('.products-to-complements-selected')

            productsASComplementsSelected.each(function (index, productASComplementsSelected) {
                let productASComplementsSelectedId = $(productASComplementsSelected).data('group-product-id')

                let priceGroupProduct = $('#unit-product-price-' + productASComplementsSelectedId)

                // get generic product price
                if (priceGroupProduct.length > 0 && parseFloat(priceGroupProduct.html().replace('.', '').replace(',', '.')) > 0) {
                    productPrice.html(
                        (
                            parseFloat(productPrice.html().replace('.', '').replace(',', '.')) +
                            parseFloat(priceGroupProduct.html().replace('.', '').replace(',', '.'))
                        ).toFixed(2).toString().replace('.', ',')
                    )
                }

                // get complements product price
                let productComplementsSelected = $(productASComplementsSelected).parent().find('.complement-product')
                productComplementsSelected.each(function (index, productComplementSelected) {
                    let productComplementSelectedId = $(productComplementSelected).data('complement-id')

                    let priceComplement = $('#product-complement-price-' + productComplementSelectedId)

                    if (priceComplement.length > 0 && parseFloat(priceComplement.html().replace('.', '').replace(',', '.')) > 0) {
                        productPrice.html(
                            (
                                parseFloat(productPrice.html().replace('.', '').replace(',', '.')) +
                                parseFloat(priceComplement.html().replace('.', '').replace(',', '.'))
                            ).toFixed(2).toString().replace('.', ',')
                        )
                    }
                })
            })

            // Print price
            productQuantity.html(maxProductQuantity)
        }

        changeCombined()
    </script>
@endsection
