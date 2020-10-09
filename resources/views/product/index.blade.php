@extends('layouts.app')

@section('breadcrumbs')
    <li class="breadcrumb-item"><a href="{{ route('product.index') }}">{{ __('ctic_shop.all_products') }}</a></li>
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
                @if($taxon && $taxon->children->count())
                    <div class="card card-default mb-3">
                        <div class="card-body">
                            <div class="row">
                            @foreach($taxon->children as $child)
                                <div class="col-12 col-sm-6 col-md-4 mb-2 mt-2">
                                    @include('product.index._category', ['taxon' => $child])
                                </div>
                            @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                @if(!$products->isEmpty())
                    @if($taxon)
                        <div class="card card-default">
                            <div class="card-header">{{ $taxon->name }}</div>
                        </div>
                    @endif

                    <div class="row mt-1">

                        @foreach($products as $product)
                            <div class="col-12 col-sm-4 col-md-4 col-lg-3 mb-2 mt-2">
                                @include('product.index._product')
                            </div>
                        @endforeach

                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
