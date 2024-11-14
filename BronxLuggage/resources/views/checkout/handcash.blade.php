@extends('layout.user')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/testcheckoutpayment.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">

<div class="payment-cart-section">
    <div class="payment-cart-container">
        <div class="payment-cart-inner-container">
            <div class="thank-you-message">
                <h1>Thank You for Your Order!</h1>
                <p>We have received your order and will be in touch soon.</p>
                <p>Please check your email for further details.</p>
                <a href="{{ url('/home/index') }}" class="back-to-home">Return to Home</a>
            </div>
        </div>
    </div>
</div>
@endsection