@extends('layouts.app')

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
