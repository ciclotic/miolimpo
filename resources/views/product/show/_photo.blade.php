<style>
    .thumbnail-container {
        overflow-x: auto;
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
<div class="col-md-6">
    <div class="mb-2">
        <?php $img = $product->getMedia()->first() ? $product->getMedia()->first()->getUrl('medium') : '/images/product-medium.jpg' ?>
        <img src="{{ $img  }}" class="w-100" id="product-image" />
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
