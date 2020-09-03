<div id="complements">
    <div id="complements-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="complements-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {!! Form::open([
                    'method' => 'POST',
                    'id' => 'update-complement-form'
                ])
            !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="complements-modal">{{ __('ctic_admin.complements') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('ctic_admin.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($product->complementProducts as $complementProduct)
                        <span class="badge badge-pill badge-dark">
                            {{ $complementProduct->name }}:
                            {{ __('ctic_admin.is_selected') }}:
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" {{ ($complementProduct->pivot->selected)? 'checked' : '' }} id="products-to-complements-selected-{{ $complementProduct->id }}" onchange="return updateComplement({{ $complementProduct->id }})">
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="return deleteComplement({{ $complementProduct->id }})">{{ __('ctic_admin.delete') }}</button>
                        </span>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" data-toggle="modal"
                            data-target="#create-complement"
                            class="btn btn-outline-success btn-sm">{{ __('ctic_admin.add_complement') }}</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('ctic_admin.close') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('vanilo::complement._create_complement', [
        'product' => $product,
        'productsElegibleAsComplement' => $productsElegibleAsComplement
    ])
</div>

@section('scripts')
@parent()
<script>
    function updateComplement(productComplementId) {
        let selected = $('#products-to-complements-selected-' + productComplementId).is(':checked')

        let formData = new FormData($('#update-complement-form')[0])

        $.ajax({
            url: '/admin/complement/{{ $product->id }}/' + productComplementId + '/' + ((selected) ? '1' : '0'),
            method: 'PUT',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })

        return false
    }

    function deleteComplement(productComplementId) {
        let formData = new FormData($('#update-complement-form')[0])

        $.ajax({
            url: '/admin/complement/{{ $product->id }}/' + productComplementId,
            method: 'DELETE',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
        })

        return false
    }
</script>
@endsection
