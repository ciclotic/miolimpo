<div class="card">
    <div class="card-block">
        <h6 class="card-title">{{ __('ctic_admin.complements') }}</h6>

        <table class="table">
            <tr>
                <td>
                    @foreach($product->complementProducts as $complementProduct)
                        <span class="badge badge-pill badge-dark">
                            {{ $complementProduct->complement_product->name }}:
                            {{ __('ctic_admin.is_selected') }}: {{ ($complementProduct->selected) ? __('ctic_admin.yes') : __('ctic_admin.no') }}
                        </span>
                    @endforeach
                </td>
                <td class="text-right">
                    <button type="button" data-toggle="modal"
                            data-target="#complements-assign-to-model-modal"
                            class="btn btn-outline-success btn-sm">{{ __('Manage') }}</button>
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- @include('vanilo::complement.assign._form', [
    'for' => 'product',
    'forId' => $product->id,
    'assignments' => $product->complementProducts,
    'products' => $products
]) --}}
