<div id="group_products">
    <div id="group_products-modal" class="modal fade" tabindex="-1" role="dialog"
         aria-labelledby="group_products-modal-title" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            {!! Form::open([
                    'method' => 'POST',
                    'id' => 'update-group_product-form'
                ])
            !!}
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="group_products-modal">{{ __('ctic_admin.group_products') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('ctic_admin.close') }}">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @foreach($group->groupProducts as $groupProductProduct)
                        <span class="badge badge-pill badge-dark">
                            {{ $groupProductProduct->name }}:
                            {{ __('ctic_admin.is_modifiable') }}:
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" {{ ($groupProductProduct->pivot->group_modifiable)? 'checked' : '' }} id="products-to-group_products-selected-{{ $groupProductProduct->id }}" onchange="return updateGroupProduct({{ $groupProductProduct->id }})">
                            </div>
                            <button type="button" class="btn btn-outline-danger btn-sm" onclick="return deleteGroupProduct({{ $groupProductProduct->id }})">{{ __('ctic_admin.delete') }}</button>
                        </span>
                    @endforeach
                </div>
                <div class="modal-footer">
                    <button type="button" data-toggle="modal"
                            data-target="#create-group_product"
                            class="btn btn-outline-success btn-sm">{{ __('ctic_admin.add_group_product') }}</button>
                    <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('ctic_admin.close') }}</button>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    @include('admin.group_product._create_group_product', [
        'product' => $group,
        'productsElegibleAsGroupProduct' => $productsElegibleAsGroupProduct
    ])
</div>

@section('scripts')
@parent()
<script>
    function updateGroupProduct(productGroupProductId) {
        let selected = $('#products-to-group_products-selected-' + productGroupProductId).is(':checked')

        let formData = new FormData($('#update-group_product-form')[0])

        $.ajax({
            url: '/admin/group_product/{{ $group->id }}/' + productGroupProductId + '/' + ((selected) ? '1' : '0'),
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

    function deleteGroupProduct(productGroupProductId) {
        let formData = new FormData($('#update-group_product-form')[0])

        $.ajax({
            url: '/admin/group_product/{{ $group->id }}/' + productGroupProductId,
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
