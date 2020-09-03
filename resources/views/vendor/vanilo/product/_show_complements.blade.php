<div class="card">
    <div class="card-block">
        <h6 class="card-title">{{ __('ctic_admin.complements') }}</h6>

        <table class="table">
            <tr>
                <td>
                    @foreach($product->complementProducts as $complementProduct)
                        <span class="badge badge-pill badge-dark">
                            {{ $complementProduct->name }}:
                            {{ __('ctic_admin.is_selected') }}: {{ ($complementProduct->pivot->selected) ? __('ctic_admin.yes') : __('ctic_admin.no') }}
                        </span>
                    @endforeach
                </td>
                <td class="text-right">
                    <button type="button" data-toggle="modal"
                            data-target="#complements-modal"
                            class="btn btn-outline-success btn-sm">{{ __('ctic_admin.edit') }}</button>
                </td>
            </tr>
        </table>
    </div>
</div>

@include('vanilo::complement._form', [
    'product' => $product,
    'productsElegibleAsComplement' => $productsElegibleAsComplement
])
