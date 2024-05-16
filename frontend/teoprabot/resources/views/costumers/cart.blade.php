@extends('costumers.layouts.template')
@section('title', 'Keranjang')
@section('css')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<style>
    /* Your existing CSS here */
</style>
@endsection
@section('main-content')
<section class="cart_area">
    <div class="container">
        <div class="cart_inner">
            <div class="table-responsive">
                {{-- @if(count($carts) > 0)
                <br>
                @if (session()->has('message'))
                <div id="alert" class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
                @elseif (session()->has('error'))
                <div id="alert" class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
                @endif --}}
                <br>
                <div class="table-responsive-custom">
                    <form action="{{ route('checkout') }}">
                        <table class="table">
                            <thead>
                                <tr>
                                    {{-- <th><input type="checkbox" id="select_all_ids"></th> --}}
                                    <th scope="col">Product</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Quantity</th>
                                    <th scope="col">Total</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            @php
                            $total = 0;
                            @endphp
                            <tbody>
                                @foreach ($carts as $cart)
                                {{-- @php
                                $product_id = $cart['product_id'];
                                $image = collect($images)->firstWhere('product_id', $product_id);
                                @endphp --}}
                                <tr>
                                    {{-- <td><input type="checkbox" name="ids[{{ $cart['ID'] }}]" class="checkbox_ids" value="{{ $cart['ID'] }}"></td> --}}
                                    <td>
                                        <div class="media">
                                            <div class="d-flex">
                                                {{-- @if ($image) --}}
                                                @foreach ($product_detil as $product )
                                                @if ($product['ID'] == $cart['ProductID'])
                                                <a href="{{ route('produkdetail', $cart['ProductID']) }}">

                                                    {{-- <img src="{{ asset($product['image']) }}" alt="" style="max-width: 100px; max-height: 100px;"> --}}
                                                </a>
                                                {{-- @endif --}}
                                                {{ $product['name'] }}
                                                @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <p>Rp {{ number_format($cart['Price'], 0, ',', '.') }}</p>
                                    </td>
                                    <td>
                                        <div class="quantity-input">
                                            {{-- <a href="" class="btn btn-secondary dec" style="background-color:#402218;color:white">-</a> --}}
                                            <input type="text" readonly id="quantityInput" value="{{ $cart['Quantity'] }}" onchange="updateQuantity({{ $cart['ID'] }}, this)">
                                            {{-- <a href="" class="btn btn-secondary in" style="background-color:#402218;color:white">+</a> --}}
                                        </div>
                                    </td>
                                    @php
                                    $total += $cart['Quantity'] * $cart['Price'];
                                    @endphp
                                    <td class="item_price" data-price="{{ $cart['Quantity'] * $cart['Price'] }}">
                                        {{ 'Rp '.number_format($cart['Quantity'] * $cart['Price'], 0, ',', '.') }}
                                    </td>
                                    <td><a href="{{route('deletecart',$cart['ID'])}}" class="text-dark">delete</a></td>
                                </tr>
                                @endforeach
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <h5>Subtotal</h5>
                                    </td>
                                    <td id="total_price">{{ 'Rp '.number_format($total, 0, ',', '.') }}</td>
                                    <td>
                                        <div class="checkout_btn_inner">
                                            <button type="submit" class="main_btn btn btn-success" style="background-color:#402218;color:white">Checkout</button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
                {{-- @else --}}
                {{-- <p>No items in the cart</p> --}}
                {{-- @endif --}}
            </div>
        </div>
    </div>
</section>
<br><br>
@endsection
@section('js')
<script>
    $(document).ready(function() {
        $(".js-example-basic-multiple-limit").select2({
            maximumSelectionLength: 2
        });
    });

    function updateQuantity(cartId, input) {
        // Logic to update quantity
    }

    $(document).ready(function() {
        // Event handler for the decrement and increment buttons
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'deskripsi',
        tabsize: 2,
        height: 400
    });
</script>
<script>
    // Handle form submission to strip <p> tags from Summernote content
    $('form').submit(function() {
        var content = $('#summernote').summernote('code');
        content = content.replace(/<p>/g, '').replace(/<\/p>/g, '');
        $('#summernote').summernote('code', content);
    });
</script>
@endsection
