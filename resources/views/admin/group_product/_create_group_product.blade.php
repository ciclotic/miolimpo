{{--This feature is unfinished and is currently disabled--}}
<div id="create-group_product" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="create-group_product-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'method' => 'POST',
                    'id' => 'create-group_product-form'
                ])
            !!}
            <div class="modal-header">
                <h5 class="modal-title" id="create-group_product-title" v-html="'{{ __('ctic_admin.add_group_product') }}'"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('ctic_admin.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12">
                            <select id="products-to-group_products" class="form-control">
                                @foreach($productsElegibleAsGroupProduct as $optionGroupProductProduct)
                                    <option value="{{ $optionGroupProductProduct->id }}">{{ $optionGroupProductProduct->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12 pt-4">
                            <input class="form-group form-control" type="text" value="" placeholder="{{ __('ctic_admin.order') }}" id="products-to-group_products-order">
                        </div>
                        <div class="col-md-12 pt-2">
                            <input class="form-group form-control" type="text" value="" placeholder="{{ __('ctic_admin.price') }}" id="products-to-group_products-price">
                        </div>
                        <div class="col-md-12 pt-2 pl-5">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="products-to-group_products-group_modifiable">
                                <label class="form-check-label" for="products-to-group_products-group_modifiable">
                                    {{ __('ctic_admin.group_product_group_modifiable') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('ctic_admin.close') }}</button>
                <button class="btn btn-primary" onclick="return saveGroupProduct()">{{ __('ctic_admin.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('scripts')
    @parent()
    <script>
        function saveGroupProduct() {
            let group_product_product = $('#products-to-group_products').val()
            let order = $('#products-to-group_products-order').val()
            let price = $('#products-to-group_products-price').val().replace(',', '.')
            let group_modifiable = $('#products-to-group_products-group_modifiable').is(':checked')

            let formData = new FormData($('#create-group_product-form')[0])

            $.ajax({
                url: '/admin/group_product/{{ $group->id }}/' + group_product_product + '/' + (order? order : 0) + '/' + (price? price : 0) + '/' + ((group_modifiable) ? '1' : '0'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(response) {
                if (response === 'product of group added') {
                    $('#create-group_product').modal('toggle');
                }
            })

            return false
        }
    </script>
@endsection
