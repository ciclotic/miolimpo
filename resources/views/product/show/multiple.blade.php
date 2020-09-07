<style>
    .complement-name {
        font-size: 14px;
    }
    .complement-price {
        font-size: 14px;
        text-align: right;
    }
</style>
<div class="container">
    <div class="row">
        @include('product.show._photo')

        <div class="col-md-6">
            <form action="{{ route('cart.add', $product) }}" method="post" class="mb-4">
                {{ csrf_field() }}

                @include('product.show._buy')
                @include('product.show._complements_multiple')
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
        function changeComplement(productComplementId, price) {
            let productPrice = $('#product-price')
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
        @foreach($product->complementProducts as $complementProduct)
            @if ($complementProduct->pivot->selected)
                changeComplement({{ $complementProduct->id }}, '{{ number_format($complementProduct->price, 2, ',', '.') }}')
            @endif
        @endforeach
    </script>
@endsection
