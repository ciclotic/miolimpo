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
                @foreach($product->complementProducts as $complementProduct)
                    @if($agent->isMobile())
                        <div class="row mt-2">
                            <div class="col-md-1 col-1 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected" value="{{ $complementProduct->id }}" onchange="changeComplement({{ $complementProduct->id }}, '{{ number_format($product->price, 2, ',', '.') }}', '{{ number_format($complementProduct->price, 2, ',', '.') }}')">
                                </div>
                            </div>
                            <div class="col-md-2 col-3">
                                <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
                            </div>
                            <div class="col-md-6 col-7 mt-2 complement-name">
                                {{ $complementProduct->name }}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3 col-12 font-weight-bold text-primary btn-lg complement-price text-center">{{ format_price(number_format($complementProduct->price, 2, ',', '.')) }}</div>
                        </div>
                    @else
                        <div class="row mt-2">
                            <div class="col-md-1 col-1 mt-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected" value="{{ $complementProduct->id }}" onchange="changeComplement({{ $complementProduct->id }}, '{{ number_format($product->price, 2, ',', '.') }}', '{{ number_format($complementProduct->price, 2, ',', '.') }}')">
                                </div>
                            </div>
                            <div class="col-md-2 col-3">
                                <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
                            </div>
                            <div class="col-md-6 col-4 mt-2 complement-name">
                                {{ $complementProduct->name }}
                            </div>
                            <div class="col-md-3 col-3 font-weight-bold text-primary btn-lg complement-price">{{ format_price(number_format($complementProduct->price, 2, ',', '.')) }}</div>
                        </div>
                    @endif
                @endforeach
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
        function changeComplement(productComplementId, productPrice, price) {
            let productPriceHTML = $('#product-price')
            let inputComplementId = $('input[name="products-to-complements-selected"]:checked').val()

            if (parseInt(inputComplementId) === parseInt(productComplementId)) {
                productPriceHTML.html(
                    (
                        parseFloat(productPrice.replace('.', '').replace(',', '.')) +
                        parseFloat(price.replace('.', '').replace(',', '.'))
                    ).toFixed(2).toString().replace('.', ',')
                )
            }
        }
        @foreach($product->complementProducts as $complementProduct)
            @if ($complementProduct->pivot->selected)
                changeComplement({{ $complementProduct->id }}, '{{ number_format($product->price, 2, ',', '.') }}', '{{ number_format($complementProduct->price, 2, ',', '.') }}')
            @endif
        @endforeach
    </script>
@endsection
