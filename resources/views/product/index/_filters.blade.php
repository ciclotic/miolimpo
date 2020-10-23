<div class="accordion" id="accordionFilters">
    <form id="filtersForm" class="card card-default mb-3" action="{{
        $taxon ?
        route('product.category', $taxon->slug)
        :
        route('product.index')
    }}">
        <div id="accordionFiltersTitle" class="card-header">
            <button class="btn text-left text-primary" type="button" data-toggle="collapse" data-target="#accordionFiltersBody" aria-expanded="true" aria-controls="accordionFiltersBody">
                {{ __('ctic_shop.filters') }}
            </button>
        </div>
        <ul id="accordionFiltersBody" aria-labelledby="accordionFiltersTitle" data-parent="#accordionFilters" class="list-group list-group-flush collapse @if(! $agent->isMobile()) show @endif">
            @foreach($properties as $property)
                @include('product.index._property', ['property' => $property, 'filters' => $filters[$property->slug] ?? []])
            @endforeach
        </ul>
    </form>
</div>
