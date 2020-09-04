
<style>
    .thumbnail-container {
        overflow-x: scroll;
    }

    .thumbnail {
        width: 64px;
        height: auto;
        display: block;
        float: left;
    }

    .thumbnail img {
        cursor: pointer;
    }
</style>
<div class="container">
    <h1>{{ $product->name }}</h1>
    <hr>

    <div class="row">
        <div class="col-md-6">
            <div class="mb-2">
                <?php $img = $product->getMedia()->first() ? $product->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' ?>
                <img src="{{ $img  }}" id="product-image" />
            </div>

            <div class="thumbnail-container">
                @foreach($product->getMedia() as $media)
                    <div class="thumbnail mr-1">
                        <img class="mw-100" src="{{ $media->getUrl('thumbnail') }}"
                             onclick="document.getElementById('product-image').setAttribute('src', '{{ $media->getUrl("medium") }}')"
                        />
                    </div>
                @endforeach
            </div>
        </div>

        <div class="col-md-6">
            <form action="{{ route('cart.add', $product) }}" method="post" class="mb-4">
                {{ csrf_field() }}
                @foreach($product->complementProducts as $complementProduct)
                    <div class="row mt-2">
                        <div class="col-md-2 mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} name="products-to-complements-selected[{{ $complementProduct->id }}]">
                            </div>
                        </div>
                        <div class="col-md-2">
                            <img class="mw-100" src="{{ $complementProduct->getMedia()->first() ? $complementProduct->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' }}" />
                        </div>
                        <div class="col-md-6 mt-2">
                            {{ $complementProduct->name }}
                        </div>
                        <class class="col-md-2 font-weight-bold text-primary btn-lg mt-2">{{ format_price($complementProduct->price) }}</class>
                    </div>
                @endforeach
                <span class="mr-2 font-weight-bold text-primary btn-lg mt-2">{{ format_price($product->price) }}</span>
                <button type="submit" class="btn btn-success btn-lg mt-2" @if(!$product->price) disabled @endif>Add to cart</button>
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
