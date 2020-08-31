<div>
    @foreach($taxons as $taxon)
        <a href="{{ route('product.category', [$taxon->taxonomy->slug, $taxon]) }}">
            {{ $taxon->name }}
        </a>
    @endforeach
</div>
@foreach($taxons as $taxon)
    @if($taxon->isInTaxonTree($requestedTaxon) && $taxon->children->count())
        @include('product.index._category_level', ['taxons' => $taxon->children, 'requestedTaxon' => $requestedTaxon])
    @endif
@endforeach
