<article class="card shadow-sm">
    <a href="{{ route('product.show', [($product->taxons->first()) ? $product->taxons->first()->slug : $taxons->first()->slug, $product]) }}">
        <img class="card-img-top"
        @if($product->hasImage())
            src="{{ $product->getThumbnailUrl() }}"
        @else
            src="/images/product.jpg"
        @endif
        alt="{{ $product->name }}" />
    </a>

    <div class="card-body">
        <h5><a href="{{ route('product.show', [($product->taxons->first()) ? $product->taxons->first()->slug : $taxons->first()->slug, $product]) }}">{{ $product->name }}</a></h5>
        @if (\App\Ctic\Product\Models\Product::ARCHETYPES[$product->archetype] === 'unique' && count($product->complementProducts) > 0)
            <?php $minProductPrice = $product->complementProducts[0]->price ?>
            @foreach ($product->complementProducts as $complementProduct)
                @if ($complementProduct->price < $minProductPrice)
                    <?php $minProductPrice = $complementProduct->price ?>
                @endif
            @endforeach
            <?php $productPrice = $product->price + $minProductPrice ?>
            <p class="card-text">{{ __('ctic_shop.from') }} {{ format_price(number_format($productPrice, 2, ',', '.')) }}</p>
        @else
            <p class="card-text">{{ format_price(number_format($product->price, 2, ',', '.')) }}</p>
        @endif
    </div>
</article>
