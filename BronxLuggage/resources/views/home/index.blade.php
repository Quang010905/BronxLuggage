@extends('layout.user')

@section('content')
<link href='{{asset('assets')}}/css/stylecontactbanner.css' rel='stylesheet'>

<body>

    <!-- Modal -->
    <div class="modal fade bg-white" id="templatemo_search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="w-100 pt-1 mb-5 text-right">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="" method="get" class="modal-content modal-body border-0 p-0">
                <div class="input-group mb-2">
                    <input type="text" class="form-control" id="inputModalSearch" name="q" placeholder="Search ...">
                    <button type="submit" class="input-group-text bg-success text-light">
                        <i class="fa fa-fw fa-search text-white"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Start Banner Hero -->
    <style>
        #template-mo-zay-hero-carousel .carousel-item img {
            width: 100%;
            height: 600px;
            object-fit: cover;
        }
    </style>
    <div id="template-mo-zay-hero-carousel" class="carousel slide" data-bs-ride="carousel">
        <ol class="carousel-indicators">
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="0" class="active"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="1"></li>
            <li data-bs-target="#template-mo-zay-hero-carousel" data-bs-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="{{asset('assets')}}/img/bronx.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left align-self-center">
                                <h1 class="h1 text-success"><b>Bronx Luggage</b></h1>
                                <h3 class="h2">Welcome to our shop!</h3>
                                <p>
                                    The beauty of receiving high quality luggage is a truly amazing feeling. Great luggage can be passed down from family members who are experienced travelers. A high-quality set of luggage will last a lifetime.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="{{asset('assets')}}/img/banner.png " alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1">Briggs & Riley</h1>
                                <h3 class="h2">There's just no comparison!</h3>
                                <p>
                                    Briggs & Riley will guarantee their luggage from manufacturing defect, Airline damage and even for any reason whatsoever.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="container">
                    <div class="row p-5">
                        <div class="mx-auto col-md-8 col-lg-6 order-lg-last">
                            <img class="img-fluid" src="{{asset('assets')}}/img/banner_01.png" alt="">
                        </div>
                        <div class="col-lg-6 mb-0 d-flex align-items-center">
                            <div class="text-align-left">
                                <h1 class="h1">BRONX LUGGAGE AFFORDABLE COLLECTIONS</h1>
                                <h3 class="h2">"Built for Your Needs" </h3>
                                <p>
                                    Established in 1985, it luggage has been focused on designing luggage which meets traveler's needs. It Luggage offers the lightest luggage available on the market, most full-sized pieces are under 5 pounds.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev text-decoration-none w-auto ps-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="prev">
            <i class="fas fa-chevron-left"></i>
        </a>
        <a class="carousel-control-next text-decoration-none w-auto pe-3" href="#template-mo-zay-hero-carousel" role="button" data-bs-slide="next">
            <i class="fas fa-chevron-right"></i>
        </a>
    </div>
    <!-- End Banner Hero -->

    <br><br>
    <!-- Start Categories of The Month -->
    <section class="bg-success py-5">
        <div class="container">
            <div class="row align-items-center py-5">
                <div class="col-md-12 text-white text-center">
                    <h1>Luggage</h1>
                    <p>
                        We stand behind our products and treat our customers like family.
                    </p>
                </div>
                <p class="text-center"><a class="btn btn-success" href="{{url('shop/index')}}">Go Shop</a></p>
            </div>
        </div>
    </section>
    <br><br>
    <!-- End Categories of The Month -->

    <!-- Start Featured Product -->
    <section class="bg-light">
        <div class="container py-5">
            <div class="row text-center py-3">
                <div class="col-lg-6 m-auto">
                    <h1 class="h1">Recommend Items</h1>
                    <p>
                        "Your Satisfaction, Our Priority"
                    </p>
                </div>
            </div>
            <div class="row">

                @foreach($products as $product)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100 product-wap rounded-0" style="height: 450px;">
                        <div class="card rounded-0" style="height: 300px;">
                            <img class="card-img rounded-0 img-fluid" src="{{url('images/'. $product->product_image)}}" style="width: 100%; height: 300px; object-fit: cover;">
                            <div class="card-img-overlay rounded-0 product-overlay d-flex align-items-center justify-content-center">
                                <ul class="list-unstyled">
                                    <li><a class="btn btn-success text-white" href="shop-single.html"><i class="far fa-heart"></i></a></li>
                                    <li><a class="btn btn-success text-white mt-2" href="{{url('/product-detail/'. $product->product_id)}}"><i class="far fa-eye"></i></a></li>
                                    <li>
                                        @if(Session::has('customer_name'))
                                        @if($product->product_quantity > 0)
                                        <form action="{{ url('/save-cart') }}" method="POST" id="add-to-cart-form-{{ $product->product_id }}">
                                            @csrf
                                            <input type="hidden" name="productid_hidden" value="{{ $product->product_id }}">
                                            <a class="btn btn-success text-white mt-2" href="javascript:void(0);" onclick="document.getElementById('add-to-cart-form-{{ $product->product_id }}').submit();">
                                                <i class="fas fa-cart-plus"></i>
                                            </a>
                                        </form>
                                        @else
                                        <button class="btn btn-secondary text-white mt-2" disabled>
                                            <i class="fas fa-cart-plus"></i>
                                        </button>
                                        @endif
                                        @else
                                        <a href="{{ url('/login/index') }}" class="btn btn-success text-white mt-2">
                                            <i class="fas fa-cart-plus"></i>
                                        </a>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="{{url('/product-detail/'. $product->product_id)}}" class="h3 text-decoration-none">{{$product->product_name}}</a>
                            <ul class="w-100 list-unstyled d-flex justify-content-between mb-0">
                                <li></li>
                                <li class="pt-2">
                                    <span class="product-color-dot color-dot-red float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-blue float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-black float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-light float-left rounded-circle ml-1"></span>
                                    <span class="product-color-dot color-dot-green float-left rounded-circle ml-1"></span>
                                </li>
                            </ul>
                            <ul class="list-unstyled d-flex justify-content-center mb-1">
                                <li>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-warning fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                    <i class="text-muted fa fa-star"></i>
                                </li>
                            </ul>
                            <p class="text-center mb-0">{{number_format($product->product_price).' '. '$'}}</p>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
        </div>
    </section>
    <!-- End Featured Product -->

    <!-- Start Script -->
    <script src="{{asset('assets')}}/js/jquery-1.11.0.min.js"></script>
    <script src="{{asset('assets')}}/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="{{asset('assets')}}/js/bootstrap.bundle.min.js"></script>
    <script src="{{asset('assets')}}/js/templatemo.js"></script>
    <script src="{{asset('assets')}}/js/custom.js"></script>
    <!-- End Script -->
</body>

</html>
@endsection