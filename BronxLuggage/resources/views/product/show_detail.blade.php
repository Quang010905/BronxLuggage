@extends('layout.user')

@section('content')
<link rel="stylesheet" href="{{asset('assets')}}/css/custom2.css">
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

<!-- Open Content -->
<section class="bg-light">
    <div class="container pb-5">
        <div class="row">
            <div class="col-lg-5 mt-5">
                <!-- Hiển thị hình ảnh chính của sản phẩm -->
                <div class="card mb-3">
                    <img class="card-img img-fluid" src="{{ asset('images/' . $product->product_image) }}" alt="Product image" id="product-detail"
                        style="width: 100%; height: 600px; object-fit: cover;">
                </div>
                <!-- Start Carousel Wrapper -->
                <div id="multi-item-example" class="carousel slide carousel-multi-item" data-bs-ride="carousel">
                    <div class="carousel-inner product-links-wap" role="listbox">
                        @forelse($galleryImages->chunk(3) as $key => $chunk)
                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                            <div class="row">
                                @foreach($chunk as $image)
                                <div class="col-4">
                                    <a href="#">
                                        <img class="card-img img-fluid" src="{{ asset('images/' . $image->details_image) }}" alt="{{ $image->details_name }}" style="width: 200px; height: 170px; object-fit: fill;">
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @empty
                        <p>No images available.</p>
                        @endforelse
                    </div>
                    <!-- Controls -->
                    <a class="carousel-control-prev" href="#multi-item-example" role="button" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#multi-item-example" role="button" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </div>
                <!-- End Carousel Wrapper -->
            </div>
            <div class="col-lg-7 mt-5">
                <div class="card">
                    <div class="card-body">
                        <h1 class="h2">{{$product->product_name}}</h1>
                        <p class="h3 py-2">{{number_format($product->product_price). '$'}}</p>
                        <p class="py-2">
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-warning"></i>
                            <i class="fa fa-star text-secondary"></i>
                            <span class="list-inline-item text-dark">Rating 4.8 | 36 Comments</span>
                        </p>

                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Id:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{$product->product_id}}</strong></p>
                            </li>
                        </ul>
                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Brand:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{$product->brand_name}}</strong></p>
                            </li>
                        </ul>

                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Quantity:</h6>
                            </li>
                            <li class="list-inline-item">
                                @if($product->product_quantity > 0)
                                <p class="text-muted"><strong>{{$product->product_quantity}}</strong></p>
                                @else
                                <p class="text-danger"><strong>Out of Stock</strong></p>
                                @endif
                            </li>
                        </ul>

                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Category:</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>{{$product->category_name}}</strong></p>
                            </li>
                        </ul>

                        <h6>Description:</h6>
                        <p>{{$product->product_description}}</p>

                        <h6>Content:</h6>
                        <p>{{$product->product_content}}</p>

                        <ul class="list-inline">
                            <li class="list-inline-item">
                                <h6>Avaliable Color :</h6>
                            </li>
                            <li class="list-inline-item">
                                <p class="text-muted"><strong>White / Black</strong></p>
                            </li>
                        </ul>
                        @if(Session::has('customer_name'))
                        <form action="{{ url('/save-cart') }}" method="post">
                            @csrf
                            <input type="hidden" name="product-title" value="Activewear">
                            <div class="row">
                                <!-- Các trường form và nút bấm thêm sản phẩm vào giỏ hàng -->
                            </div>
                            <div class="row pb-3">
                                <div class="col d-grid">
                                    <input type="hidden" name="productid_hidden" value="{{ $product->product_id }}">
                                    <button type="submit" class="btn btn-success btn-lg" @if($product->product_quantity <= 0)
                                            disabled
                                            @endif>
                                            Add To Cart
                                    </button>
                                </div>
                            </div>
                        </form>
                        @else
                        <div class="row pb-3">
                            <div class="col d-grid">
                                <button type="button" class="btn btn-success btn-lg" id="loginButton" @if($product->product_quantity <= 0)
                                        disabled
                                        @endif>Add To Cart</button>
                            </div>
                        </div>
                        <script>
                            document.getElementById('loginButton').addEventListener('click', function() {
                                window.location.href = "{{ url('login/index') }}";
                            });
                        </script>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

<!-- Close Content -->

<!-- Close Content -->
<section>
    <div class="category-tab shop-details-tab">
        <div class="m-5">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">

                </li>
                <li class="nav-item" role="presentation">

                </li>
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews" role="tab" aria-controls="reviews" aria-selected="false">Feedback</a>
                </li>
            </ul>
        </div>
        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade " id="details" role="tabpanel" aria-labelledby="details-tab">
                <!-- Content for "Mô tả" goes here -->
            </div>

            <div class="tab-pane fade" id="companyprofile" role="tabpanel" aria-labelledby="companyprofile-tab">
                <!-- Content for "Chi tiết sản phẩm" goes here -->
            </div>

            <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                <div class="col-12">
                    <ul class="list-unstyled">
                        <li><a href="#"><i class="fas fa-user"></i> {{session('customer_name')}}</a></li>
                        <li><a href="#"><i class="fas fa-clock"></i>
                                <span class="current-time">
                                    <?php
                                    // Lấy thời gian hiện tại
                                    date_default_timezone_set('Asia/Ho_Chi_Minh'); // Thiết lập múi giờ nếu cần
                                    echo date('g:i A'); // Định dạng giờ: phút AM/PM
                                    ?>
                                </span>
                            </a>
                        </li>
                        <li><a href="#"><i class="fas fa-calendar"></i>
                                <span class="current-date">
                                    <?php
                                    // Thiết lập múi giờ nếu cần
                                    date_default_timezone_set('Asia/Ho_Chi_Minh');
                                    // Lấy ngày tháng hiện tại
                                    echo date('d M Y'); // Định dạng ngày tháng năm
                                    ?>
                                </span>
                            </a>
                        </li>
                        </a>
                    </ul>
                </div>
                <!-- start comment -->
                <section>
                    <div class="comment-list-section">
                        <p style="color: green;"><strong>Comments</strong></p>
                        @csrf
                        <div class="row list-product">
                            <div class="col-md-12 comment-list">
                                <div class="col-md-12">
                                    @foreach($comments as $comment)
                                    @if($comment->comment_status == 1) <!-- Kiểm tra comment_status -->
                                    <div class="comment-box">
                                        <ul>
                                            <li class="com-title" style="color: green;">
                                                {{$comment->comment_name}}
                                                <br>
                                                <span>{{date('d/m/Y ',strtotime($comment->created_at))}}</span>
                                            </li>
                                            <li class="com-details">
                                                {{$comment->comment_content}}
                                            </li>
                                        </ul>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <p></p>
                        <div class="pagination">
                            {{ $comments->links() }}
                        </div>
                    </div>
                    <div class="comment-section">
                        <p><strong>Write Your Review</strong></p>
                        <form method="post">
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input required type="email" placeholder="Your Email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="name">Name:</label>
                                <input required type="text" placeholder="Your Name" class="form-control" id="name" name="name">
                            </div>
                            <div class="form-group">
                                <label for="cm">Comment</label>
                                <textarea required rows="10" id="cm" placeholder="Write Comments" class="form-control" name="content"></textarea>
                            </div>
                            <div class="form-group text-right">
                                <button type="submit" class="btn btn-default">Submit</button>
                            </div>

                            {{csrf_field()}}
                        </form>
                    </div>
                </section>
                <!-- comment end -->

                @endsection