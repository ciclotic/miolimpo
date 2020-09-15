<style>
    .product-price {
        font-size: 24px;
        text-align: right;
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
    <div class="col-md-4">
        <select name="quantity" class="form-control mt-1">
            @for($i = 1; $i <= 100; $i++)
                <option value="{{ $i }}">{{ $i }}</option>
            @endfor
        </select>
    </div>
    <div class="col-md-8">
        <button type="submit" class="btn btn-primary btn-lg w-100">{{ __('ctic_shop.add_cart') }}</button>
    </div>
</div>
