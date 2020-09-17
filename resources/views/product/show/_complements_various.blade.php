@foreach($product->complementProducts as $complementProduct)
    <input type="hidden" name="products-to-complements-selected[{{ $complementProduct->id }}]" >
    @if($agent->isMobile())
        <div class="complement-product">
            <div class="row mt-2">
                <div class="col-4 mt-2">
                    <select name="quantity-complement[{{ $complementProduct->id }}]" class="form-control complement-quantity" onchange="changeComplement()">
                        @for($i = 0; $i <= 100; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-3">
                    <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
                </div>
                <div class="col-4 mt-2 complement-name">
                    {{ $complementProduct->name }}
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-3 col-12 font-weight-bold text-primary btn-lg complement-price text-center">
                    <span class="complement-price-to-use">{{ number_format($complementProduct->price, 2, ',', '.') }}</span> {{ config('vanilo.framework.currency.sign') }}
                </div>
            </div>
        </div>
    @else
        <div class="row mt-2 complement-product">
            <div class="col-md-2 col-2 mt-2">
                <select name="quantity-complement[{{ $complementProduct->id }}]" class="form-control complement-quantity" onchange="changeComplement()">
                    @for($i = 0; $i <= 100; $i++)
                        <option value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2 col-3">
                <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
            </div>
            <div class="col-md-5 col-3 mt-2 complement-name">
                {{ $complementProduct->name }}
            </div>
            <div class="col-md-3 col-3 font-weight-bold text-primary btn-lg complement-price">
                <span class="complement-price-to-use">{{ number_format($complementProduct->price, 2, ',', '.') }}</span> {{ config('vanilo.framework.currency.sign') }}
            </div>
        </div>
    @endif
@endforeach
