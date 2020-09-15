<table class="table table-borderless table-condensed">
    <tr>
        <th class="pl-0">{{ __('ctic_shop.items') }}:</th>
        <td>{{ format_price(number_format(Cart::total(), 2, ',', '.')) }}</td>
    </tr>
</table>

<h5>{{ __('ctic_shop.total') }}:</h5>
<h3>{{ format_price(number_format(Cart::total(), 2, ',', '.')) }}</h3>

<hr>
