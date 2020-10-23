@extends('layouts.app')

@section('title') {{ $product->ext_title }} @stop

@section('metas')
    <meta name="description" content="{!!  nl2br($product->meta_description) !!}" />
    <meta property="og:description" content="{!!  nl2br($product->meta_description) !!}" />
    <meta name="keywords" content="{!!  nl2br($product->meta_keywords) !!}" />
    <meta property="article:published_time" content="{{ $product->created_at }}" />
    <meta property="article:modified_time" content="{{ $product->updated_at }}" />
    <?php $img = $product->getMedia()->first() ? $product->getMedia()->first()->getUrl('medium') : url('/') . '/images/product-medium.jpg' ?>
    <meta property="og:image" content="{{ $img }}" />
    <meta property="og:image:width" content="540" />
    <meta property="og:image:height" content="406" />
@stop

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('ctic_shop.all_products') }}</a></li>
    @if ($product->taxons->count())
        @include('product._breadcrumbs', ['taxon' => $product->taxons->first()])
    @endif
    <li class="breadcrumb-item">{{ $product->name }}</li>
@stop

@section('content')
    <?php $archetype = ($product->archetype)? $product->archetype : 0 ?>
    @if (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'basic')
        @include('product.show.basic')
    @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'multiple')
        @include('product.show.multiple')
    @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'unique')
        @include('product.show.unique')
    @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'various')
        @include('product.show.various')
    @elseif (\App\Ctic\Product\Models\Product::ARCHETYPES[$archetype] === 'combined')
        @include('product.show.combined')
    @else
        <div class="container">
            {{ __('ctic_shop.product_type_not_found') }}
        </div>
    @endif
@endsection
