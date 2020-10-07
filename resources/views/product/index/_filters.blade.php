<div class="accordion" id="accordionFilters">
    <form class="card card-default mb-3" action="{{
        $taxon ?
        route('product.category', $taxon->slug)
        :
        route('product.index')
    }}">
        <div id="accordionFiltersTitle" class="card-header">
            <button class="btn text-left text-primary" type="button" data-toggle="collapse" data-target="#accordionFiltersBody" aria-expanded="true" aria-controls="accordionFiltersBody">
                {{ __('ctic_shop.filters') }}
            </button>
            <button class="btn btn-sm btn-primary float-right pt-0 pb-0">{{ __('ctic_shop.apply') }}</button>
        </div>
        <ul id="accordionFiltersBody" aria-labelledby="accordionFiltersTitle" data-parent="#accordionFilters" class="collapse list-group list-group-flush">
            @foreach($properties as $property)
                @include('product.index._property', ['property' => $property, 'filters' => $filters[$property->slug] ?? []])
            @endforeach
        </ul>
    </form>
</div>
