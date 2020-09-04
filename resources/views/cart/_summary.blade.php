<table class="table table-borderless table-condensed">
    <tr>
        <th class="pl-0">Products:</th>
        <td>{{ format_price(number_format(Cart::total(), 2, ',', '.')) }}</td>
    </tr>
</table>

<h5>Total:</h5>
<h3>{{ format_price(number_format(Cart::total(), 2, ',', '.')) }}</h3>

<hr>
