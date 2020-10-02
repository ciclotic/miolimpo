<table class="table table-borderless table-condensed">
    <tr>
        <th class="pl-0">{{ __('ctic_shop.items') }}:</th>
        <td>{{ format_price(number_format(Cart::total(), 2, ',', '.')) }}</td>
    </tr>
    @if (!empty($shipping_methods[0]))
        <tr>
            <th class="pl-0">{{ __('ctic_shop.shipping') }}:</th>
            <td id="shipping_price">0</td>
        </tr>
    @endif
</table>

<h5>{{ __('ctic_shop.total') }}:</h5>
<h3 id="total_price" data-total-without-shipping="{{ number_format(Cart::total(), 2, ',', '.') }}">{{ format_price(number_format(Cart::total(), 2, ',', '.')) }}</h3>

<hr>
