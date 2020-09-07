<style>
    .product-price {
        font-size: 24px;
        text-align: right;
    }
    .product-quantity {
        font-size: 24px;
    }
</style>

@if($agent->isMobile())
    <div class="row">
        <div class="col-md-8 col-12">
            <h1>{{ $product->name }}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-12 product-price text-center font-weight-bold text-primary mt-1">
            <span id="product-price">{{ number_format($product->price, 2, ',', '.') }}</span> {{ config('vanilo.framework.currency.sign') }}
        </div>
    </div>
@else
    <div class="row">
        <div class="col-md-8 col-6">
            <h1>{{ $product->name }}</h1>
        </div>
        <div class="col-md-4 col-5 product-price font-weight-bold text-primary mt-1">
            <span id="product-price">{{ number_format($product->price, 2, ',', '.') }}</span> {{ config('vanilo.framework.currency.sign') }}
        </div>
    </div>
@endif
<div class="row">
    <div class="col-md-4 product-quantity text-primary pt-1">
        {{ __('ctic_shop.qty') }}: <span id="quantity-field">1</span>
    </div>
    <div class="col-md-8">
        <button type="submit" class="btn btn-primary btn-lg w-100" @if(!$product->price) disabled @endif onclick="$('#product-combined-form').submit()">{{ __('ctic_shop.add_cart') }}</button>
    </div>
</div>
