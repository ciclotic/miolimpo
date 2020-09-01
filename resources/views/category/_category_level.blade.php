<div class="row background-grey-scale @if(!empty($taxons[0])) background-grey-scale-{{ $taxons[0]->level }} @endif w-100">
    @foreach($taxons as $taxon)
        <a
                href="{{ route('product.category', [$taxon->slug]) }}"
                class="col-md-2 col-6"
        >
            {{ $taxon->name }}
        </a>
    @endforeach
</div>
@foreach($taxons as $taxon)
    @if($taxon->isInTaxonTree($requestedTaxon) && $taxon->children->count())
        @include('category._category_level', ['taxons' => $taxon->children, 'requestedTaxon' => $requestedTaxon])
    @endif
@endforeach
