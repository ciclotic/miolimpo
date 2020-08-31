@extends('layouts.app')

@section('categories-menu')
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#categoriesMenu" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse @if(! $agent->isMobile()) show @endif" id="categoriesMenu">
            <div>
                @foreach($taxons as $currentTaxon)
                    <a href="{{ route('product.category', [$currentTaxon->taxonomy->slug, $currentTaxon]) }}">
                        {{ $currentTaxon->name }}
                    </a>
                @endforeach
            </div>
            @foreach($taxons as $currentTaxon)
                @if($taxon && $currentTaxon->isInTaxonTree($taxon))
                    @include('product.index._category_level', ['taxons' => $currentTaxon->children, 'requestedTaxon' => $taxon])
                @endif
            @endforeach
        </div>
    </nav>
@stop

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">All Products</a></li>
    @if($taxon)
        @include('product._breadcrumbs')
    @endif
@stop

@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-3">
                @include('product.index._filters', ['properties' => $properties, 'filters' => $filters])
            </div>

            <div class="col-md-9">
                @if($taxon && $products->isEmpty() && $taxon->children->count())
                    <div class="card card-default mb-4">
                        <div class="card-header">{{ $taxon->name }} Subcategories</div>

                        <div class="card-body">
                            <div class="row">
                            @foreach($taxon->children as $child)
                                <div class="col-12 col-sm-6 col-md-4 mb-4">
                                    @include('product.index._category', ['taxon' => $child])
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(!$products->isEmpty())
                <div class="card card-default">
                    <div class="card-header">{{ $taxon ?  'Products in ' . $taxon->name : 'All Products' }}</div>

                    <div class="card-body">
                        <div class="row">

                            @foreach($products as $product)
                                <div class="col-12 col-sm-6 col-md-4 mb-4">
                                    @include('product.index._product')
                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@endsection
