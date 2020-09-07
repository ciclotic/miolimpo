@foreach($product->complementProducts as $complementProduct)
    @if($agent->isMobile())
        <div class="row mt-2">
            <div class="col-md-1 col-1 mt-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected[{{ $complementProduct->id }}]" onchange="changeComplement({{ $complementProduct->id }}, '{{ number_format($complementProduct->price, 2, ',', '.') }}')">
                </div>
            </div>
            <div class="col-md-2 col-3">
                <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
            </div>
            <div class="col-md-6 col-7 mt-2 complement-name">
                {{ $complementProduct->name }}
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-3 col-12 font-weight-bold text-primary btn-lg complement-price text-center">{{ format_price(number_format($complementProduct->price, 2, ',', '.')) }}</div>
        </div>
    @else
        <div class="row mt-2">
            <div class="col-md-1 col-1 mt-2">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected[{{ $complementProduct->id }}]" onchange="changeComplement({{ $complementProduct->id }}, '{{ number_format($complementProduct->price, 2, ',', '.') }}')">
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
