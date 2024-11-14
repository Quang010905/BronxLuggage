@extends('layout.user')

@section('content')
<link rel="stylesheet" href="{{ asset('css/custom.css') }}">
<div class="container mt-5">
    <h1 class="mb-4">Orders</h1>
    <h2 class="mb-4">Customer: {{ session('customer_name') }}</h2>

    @if($orders->isEmpty())
    <div class="alert alert-info" role="alert">
        You do not have any invoices yet.
    </div>
    @else
    @foreach($orders as $order)
    <div class="card mb-4">
        <div class="card-header">
            <h3 class="card-title">Order ID: {{ $order->order_id }}</h3>
        </div>
        <div class="card-body">
            <ul class="list-group">
                @foreach($orderDetails->where('order_id', $order->order_id) as $detail)
                <li class="list-group-item d-flex align-items-center">
                    <img src="{{ asset('images/' . $detail->product_image) }}" alt="{{ $detail->product_name }}" class="img-thumbnail me-3" width="100" height="100">
                    <div>
                        <h5 class="mb-1">Product: {{ $detail->product_name }}</h5>
                        <p class="mb-1">Quantity: {{ $detail->product_sales_quantity }}</p>
                        <p class="mb-1">Price: {{ $detail->product_price }}</p>
                        <p>Total: {{ $detail->product_price * $detail->product_sales_quantity }}</p>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach

    <!-- Hiển thị phân trang -->
    {{ $orders->links() }}
    @endif
</div>
@endsection