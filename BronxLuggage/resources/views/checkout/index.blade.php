@extends('layout.user')

@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/testcheckout.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome.min.css') }}">
<div class="checkout-section">
    <div class="checkout-row">
        <div class="checkout-col-50">
            <div class="checkout-inner-container">
                <h3>Billing Address</h3>
                @if(Session::has('customer_name'))
                <form action="{{url('/save-checkout')}}" method="post">
                    @csrf
                    <label class="checkout-label" for="fname"><i class="fas fa-user"></i> Full Name</label>
                    <input class="checkout-input" type="text" id="fname" name="shipping_name" value="{{session('customer_name')}}">
                    <label class="checkout-label" for="email"><i class="fas fa-envelope"></i> Email</label>
                    <input class="checkout-input" type="text" id="email" name="shipping_email" value="{{session('customer_email')}}">
                    <label class="checkout-label" for="adr"><i class="fas fa-address-card"></i> Address</label>
                    <input class="checkout-input" type="text" id="adr" name="shipping_address" placeholder="Address" required>
                    <label class="checkout-label" for="phone"><i class="fas fa-phone"></i> Phone</label>
                    <input class="checkout-input" type="text" id="phone" name="shipping_phone" placeholder="Phone" required>
                    <label for="exampleInputPassword1"><i class="fa fa-book"></i> Note</label>
                    <textarea class="form-control checkout-input" style="resize: none" rows="10" name="shipping_note" id="exampleInputPassword1" placeholder="Note" required></textarea>
                    <input type="submit" value="Purchase Confirmation" name="send_order" class="checkout-btn">
                </form>
                @else
                <script>
                    window.location.href = "{{url('/login/index')}}";
                </script>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection