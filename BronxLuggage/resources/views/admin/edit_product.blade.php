@extends('layout.admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Update Product
                </header>
                <div class="panel-body">

                    <div class="position-center">
                        @if(Session::has('msg'))
                        <span style="color:red">
                            {{session('msg')}}
                        </span>
                        @endif
                        <form role="form" method="post" action="{{url('/update-product')}}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Name</label>
                                <input type="text" name="product_name" class="form-control" id="exampleInputEmail1" value="{{$products->product_name}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Price</label>
                                <input type="text" name="product_price" class="form-control" id="exampleInputEmail1" value="{{$products->product_price}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Quantity</label>
                                <input type="text" name="product_quantity" class="form-control" id="exampleInputEmail1" value="{{$products->product_quantity}}">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Image</label>
                                <input type="file" name="product_image" class="form-control" id="exampleInputEmail1">
                                <img src="{{asset('images/'. $products->product_image)}}" width="70" height="70">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="product_description" id="exampleInputPassword1">{{$products->product_description}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Content</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="product_content" id="exampleInputPassword1">{{$products->product_content}}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Category</label>
                                <select name="product_category" class="form-control input-sm m-bot15">
                                    @foreach($categories as $category)
                                    <option value="{{ $category->category_id }}" {{ $products->category_id == $category->category_id ? 'selected' : '' }}>
                                        {{ $category->category_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Brand</label>
                                <select name="product_brand" class="form-control input-sm m-bot15">
                                    @foreach($brands as $brand)
                                    <option value="{{ $brand->brand_id }}" {{ $products->brand_id == $brand->brand_id ? 'selected' : '' }}>
                                        {{ $brand->brand_name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Status</label>
                                <select name="product_status" class="form-control input-sm m-bot15">
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                </select>
                            </div>
                            <button type="submit" name="update_product" class="btn btn-info">Update Product</button>
                            <input type="hidden" name="product_id" value="{{ $products->product_id }}">
                        </form>
                    </div>

                </div>
            </section>

        </div>
        @endsection