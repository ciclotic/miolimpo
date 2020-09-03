{{--This feature is unfinished and is currently disabled--}}
<div id="create-complement" class="modal fade" tabindex="-1" role="dialog"
     aria-labelledby="create-complement-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            {!! Form::open([
                    'method' => 'POST',
                    'id' => 'create-complement-form'
                ])
            !!}
            <div class="modal-header">
                <h5 class="modal-title" id="create-complement-title" v-html="'{{ __('ctic_admin.add_complement') }}'"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{ __('ctic_admin.close') }}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <select id="products-to-complements" class="form-control">
                    @foreach($productsElegibleAsComplement as $optionComplementProduct)
                        <option value="{{ $optionComplementProduct->id }}">{{ $optionComplementProduct->name }}</option>
                    @endforeach
                </select>
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 pt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="products-to-complements-selected">
                                <label class="form-check-label" for="products-to-complements-selected">
                                    {{ __('ctic_admin.complement_selected') }}
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-link" data-dismiss="modal">{{ __('ctic_admin.close') }}</button>
                <button class="btn btn-primary" onclick="return saveComplement()">{{ __('ctic_admin.save') }}</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>

@section('scripts')
    @parent()
    <script>
        function saveComplement() {
            let complement_product = $('#products-to-complements').val()
            let selected = $('#products-to-complements-selected').is(':checked')

            let formData = new FormData($('#create-complement-form')[0])

            $.ajax({
                url: '/admin/complement/{{ $product->id }}/' + complement_product + '/' + ((selected) ? '1' : '0'),
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
            }).done(function(response) {
                if (response === 'complement added') {
                    $('#create-complement').modal('toggle');
                }
            })

            return false
        }
    </script>
@endsection
