@extends('layout.user')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/testcheckoutpayment.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">

<div class="payment-cart-section">
    <div class="payment-cart-container">
        <div class="payment-cart-inner-container">
            <div class="d-flex justify-content-between align-items-center mb-5">
                <h1 class="fw-bold mb-0">Shopping Cart</h1>
                <h6 class="mb-0 text-muted">{{ count($cart_items) }} items</h6>
            </div>

            @if(Session::has('msg'))
            <span style="color: red;">&nbsp;&nbsp;&nbsp;{{ session('msg') }}</span>
            @endif

            @if(Session::has('message'))
            <span style="color: green;">&nbsp;&nbsp;&nbsp;{{ session('message') }}</span>
            @endif

            <table class="table table-bordered payment-cart-table">
                <thead>
                    <tr>
                        <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 20%;">Image</th>
                        <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 25%;">Product Name</th>
                        <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 25%;">Quantity</th>
                        <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 15%;">Price</th>
                        <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 15%;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart_items as $item)
                    <tr>
                        <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">
                            <img src="{{ asset('images/' . $item->cart_image) }}" class="img-fluid rounded-3" style="width: 100px; height: 100px; object-fit: fill;">
                        </td>
                        <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">
                            <h6 class="text-muted">{{ $item->cart_name }}</h6>
                        </td>
                        <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">
                            <form action="{{ url('/update-cart-quantity/' . $item->cart_id) }}" method="POST">
                                @csrf
                                <h6>{{ $item->cart_quantity }}</h6>
                            </form>
                        </td>
                        <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">{{ $item->cart_price }}$</td>
                        <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">{{ $item->cart_quantity * $item->cart_price }}$</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <label for="payment-option">Total Price</label>
            <h4>{{ number_format($total_price, 2, '.', '') }}$</h4>
            <form method="post" action="{{url('/order-place')}}">
                @csrf
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
                @endif
                <div class="payment-method">
                    <label for="payment-option">Payment Method</label>
                    <select id="payment-option" name="payment_option">
                        <option value="1">Paypal</option>
                        <option value="2">Cash</option>
                        <!-- Thêm các phương thức thanh toán khác nếu cần -->
                    </select>
                </div>
                <input type="submit" value="Purchase Confirmation" name="send_order" class="checkout-btn">
            </form>
        </div>
    </div>
</div>
@endsection