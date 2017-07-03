<div class="panel-body">
    @if (count($products) > 0)
        <div class="panel panel-default">
            <div class="panel-body">
                <table class="table table-striped task-table">
                    <thead>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Discounts</th>
                    </thead>
                    <tbody>
                    @foreach ($products as $product)
                        <tr>
                            <td>
                                <div>{{ $product->title }}</div>
                            </td>
                            <td>
                                <div>
                                    {{ $product->price}}
                                    @if($product->hasDiscounts())
                                        (discount price {{$product->getPriceWithDiscounts()}})
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div>
                                    @if(!is_null($product->vouchers ))
                                        @foreach ($product->vouchers as $voucher)
                                            @if(!is_null($voucher->discount))
                                                {{$voucher->discount->amount}}%
                                            @endif
                                        @endforeach
                                    @endif
                                </div>
                            </td>
                            <td>
                                <a href="{{route('product-buy', $product->id)}}">
                                    buying a product
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        Empty list
    @endif
</div>
