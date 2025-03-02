@foreach($product->complementProducts as $complementProduct)
    @if($agent->isMobile())
        <div class="row mt-2 group-product-complement-{{ $groupProduct->id }}">
            <div class="col-md-1 col-1 mt-2">
                <div class="form-check">
                    @if ($groupProduct->pivot->price > 0)
                        <input class="form-check-input" type="radio" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected" value="{{ $complementProduct->id }}" onchange="changeComplementFromGroupProduct({{ $groupProduct->id }}, {{ $complementProduct->id }}, '{{ number_format($product->price, 2, ',', '.') }}', '{{ number_format($complementProduct->price, 2, ',', '.') }}')">
                    @else
                        <input class="form-check-input" type="radio" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected" value="{{ $complementProduct->id }}">
                    @endif
                </div>
            </div>
            <div class="col-md-2 col-3">
                <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
            </div>
            <div class="col-md-6 col-7 mt-2 complement-name" data-complement-id="{{ $complementProduct->id }}">
                {{ $complementProduct->name }}
            </div>
        </div>
        @if ($groupProduct->pivot->price > 0)
            <span class="hide-price" id="product-complement-price-{{ $complementProduct->id }}">{{ number_format($complementProduct->price, 2, ',', '.') }}</span>
            <div class="row">
                <div class="col-md-3 col-12 font-weight-bold text-primary btn-lg complement-price text-center">{{ format_price(number_format($complementProduct->price, 2, ',', '.')) }}</div>
            </div>
        @endif
    @else
        <div class="row mt-2 group-product-complement-{{ $groupProduct->id }}">
            <div class="col-md-1 col-1 mt-2">
                <div class="form-check">
                    @if ($groupProduct->pivot->price > 0)
                        <input class="form-check-input" type="radio" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected" value="{{ $complementProduct->id }}" onchange="changeComplementFromGroupProduct({{ $groupProduct->id }}, {{ $complementProduct->id }}, '{{ number_format($product->price, 2, ',', '.') }}', '{{ number_format($complementProduct->price, 2, ',', '.') }}')">
                    @else
                        <input class="form-check-input" type="radio" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected" value="{{ $complementProduct->id }}">
                    @endif
                </div>
            </div>
            <div class="col-md-2 col-3">
                <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
            </div>
            <div class="col-md-6 col-4 mt-2 complement-name" data-complement-id="{{ $complementProduct->id }}">
                {{ $complementProduct->name }}
            </div>
            @if ($groupProduct->pivot->price > 0)
                <span class="hide-price" id="product-complement-price-{{ $complementProduct->id }}">{{ number_format($complementProduct->price, 2, ',', '.') }}</span>
                <div class="col-md-3 col-3 font-weight-bold text-primary btn-lg complement-price">{{ format_price(number_format($complementProduct->price, 2, ',', '.')) }}</div>
            @endif
        </div>
    @endif
@endforeach
