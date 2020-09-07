<div class="container">
    <div class="row">
        @include('product.show._photo')

        <div class="col-md-6">
            @include('product.show._buy_combined')
            @include('product.show._groups_combined')

            @unless(empty($product->propertyValues))
                <table class="table table-sm">
                    <tbody>
                    @foreach($product->propertyValues as $propertyValue)
                        <tr>
                            <th>{{ $propertyValue->property->name }}</th>
                            <td>{{ $propertyValue->title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <hr>
            @endunless

            @unless(empty($product->description))
                <hr>
                <p class="text-secondary">{!!  nl2br($product->description) !!}</p>
                <hr>
            @endunless

        </div>
    </div>
</div>
