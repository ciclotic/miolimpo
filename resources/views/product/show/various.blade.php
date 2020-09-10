<div class="container">
    <div class="row">
        @include('product.show._photo')

        <div class="col-md-6">
            <form action="{{ route('cart.add', $product) }}" method="post" class="mb-4">
                {{ csrf_field() }}

                @include('product.show._buy_various')
                @include('product.show._complements_various')
            </form>

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
        function changeComplement() {
            let productPrice = $('#product-price')
            let productQuantity = $('#quantity-field')
            let quantity = 0

            productPrice.html('0')

            let inputComplements = $('.complement-product')

            inputComplements.each(function (index, element) {
                element = $(element)
                let price = element.find('.complement-price-to-use').eq(0).html()
                let units = element.find('.complement-quantity').eq(0).val()
                quantity = parseInt(quantity) + parseInt(units)
                // SUM
                productPrice.html(
                    (
                        parseFloat(productPrice.html().replace('.', '').replace(',', '.')) +
                        (units * parseFloat(price.replace('.', '').replace(',', '.')))
                    ).toFixed(2).toString().replace('.', ',')
                )
            })

            productQuantity.html(quantity)
        }

        changeComplement()
    </script>
@endsection
