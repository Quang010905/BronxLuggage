@extends('layout.user')

@section('content')

<html>

<head>
    <title>test cart</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/custom.css">
    <link rel="stylesheet" href="css/fontawesome.min.css">
</head>

<body>
    <section class="h-100 h-custom" style="background-color: white">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12">
                    <div class="card card-registration card-registration-2" style="border: 3px solid gray;">
                        <div class="card-body p-0">
                            <div class="row g-0">
                                <div class="col-lg-8">
                                    <div class="p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-5">
                                            <h1 class="fw-bold mb-0">Shopping Cart</h1>
                                            <h6 class="mb-0 text-muted">{{ count($cart_items) }} items</h6>
                                        </div>
                                        @if(Session::has('msg'))
                                        <span style="color: red;">&nbsp;&nbsp;&nbsp;
                                            {{ session('msg') }}
                                        </span>
                                        @endif
                                        @if(Session::has('message'))
                                        <span style="color: green;">&nbsp;&nbsp;&nbsp;
                                            {{ session('message') }}
                                        </span>
                                        @endif
                                        @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                        @endif
                                        @if(session('success'))
                                        <div class="alert alert-success">
                                            {{ session('success') }}
                                        </div>
                                        @endif
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 20%;">Image</th>
                                                    <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 25%;">Product Name</th>
                                                    <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 25%;">Quantity</th>
                                                    <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 15%;">Price</th>
                                                    <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 15%;">Total</th>
                                                    <th scope="col" style="border: 3px solid gray; text-align: center; vertical-align: middle; width: 10%;">Action</th>
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
                                                            <input type="number" name="cart_quantity" value="{{ $item->cart_quantity }}" min="1" style="width: 60px;">
                                                            <button type="submit" class="btn btn-primary btn-sm" name="update_cart">Update</button>
                                                        </form>
                                                    </td>
                                                    <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">{{ $item->cart_price }}$</td>
                                                    <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">{{ $item->cart_quantity * $item->cart_price }}$</td>
                                                    <td style="border: 3px solid gray; text-align: center; vertical-align: middle;">
                                                        <a href="{{ url('/delete-cart/' . $item->cart_id) }}" class="text-muted" onclick="return confirm('Are you sure?')">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                        <div class="pt-5">
                                            <h6 class="mb-0"><a href="{{ url('shop/index') }}" class="text-body"><i class="fas fa-long-arrow-alt-left me-2"></i>Back to shop</a></h6>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 bg-body-tertiary">
                                    <div class="p-5">
                                        <h3 class="fw-bold mb-5 mt-2 pt-1">Summary</h3>
                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-4">
                                            <h5 class="text-uppercase">items {{ count($cart_items) }}</h5>
                                            <h5>{{ number_format($total_price, 2, '.', '') }}$</h5>
                                        </div>

                                        <hr class="my-4">

                                        <div class="d-flex justify-content-between mb-5">
                                            <h5 class="text-uppercase">Total price</h5>
                                            <h5>{{ number_format($total_price, 2, '.', '') }}$</h5>
                                        </div>

                                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-dark btn-block btn-lg"
                                            data-mdb-ripple-color="dark" onclick="window.location.href='{{ url('checkout-page') }}'"
                                            @if($has_out_of_stock) disabled @endif>
                                            Checkout
                                        </button>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>
@endsection