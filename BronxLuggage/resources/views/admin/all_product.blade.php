@extends('layout.admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            List Product
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-2 m-b-xs">
                Search By Name
                <form method="get" action="{{url('search-product-name')}}">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="input-sm form-control" name="name" value="{{isset($name) ? $name : ''}}">
                        <span class="input-group-btn">
                            <button class="btn btn-sm btn-default" type="submit">Search</button>
                        </span>
                    </div>
                </form>
            </div>
            <div class="col-sm-4">
            </div>
            <div class="col-sm-3">
            </div>
        </div>
        <div class="table-responsive">
            @if(Session::has('msg'))
            <span style="color: green;">&nbsp;&nbsp;&nbsp;
                {{session('msg')}}
            </span>
            @endif
            @if(Session::has('eror'))
            <span style="color: red;">&nbsp;&nbsp;&nbsp;
                {{session('eror')}}
            </span>
            @endif
            <form method="POST" action="{{ url('/delete-products') }}" onsubmit="return confirm('Are you sure you want to delete the selected items?');">
                @csrf
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" id="selectAll"><i></i>
                                </label>
                            </th>
                            <th>Product Name</th>
                            <th>Details Images</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Product Image</th>
                            <th>Category</th>
                            <th>Brand</th>
                            <th>Status</th
                                <th style="width:30px;">
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]" value="{{ $product->product_id }}"><i></i></label></td>
                            <td>{{$product->product_name}}</td>
                            <td>
                                <a href="{{url('add-gallery/' .$product->product_id)}}">Add Gallery</a>
                            </td>
                            <td>{{$product->product_price}}</td>
                            <td>{{$product->product_quantity}}</td>
                            <td>
                                <img src="{{asset('images/'. $product->product_image)}}" width="70" height="70">
                            </td>
                            <td>{{$product->category_name}}</td>
                            <td>{{$product->brand_name}}</td>
                            <td>
                                @if($product->product_status == 1)
                                <a href="{{url('/unactive-product/'. $product->product_id)}}"><span class="fa-thumb-styling fa fa-eye"></span></a>
                                @else
                                <a href="{{url('/active-product/'. $product->product_id)}}"><span class="fa-thumb-styling fa fa-eye-slash"></span></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/edit-product/'.$product->product_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a href="{{url('/detele-product/'.$product->product_id)}}" class="active styling-delete" ui-toggle-class="" onclick="return confirm('Are you sure?')">
                                    <i class="fa fa-times text-danger text"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <button type="submit" class="btn btn-danger">Delete Selected</button>
            </form>
        </div>
        <footer class="panel-footer">
            <div class="row">

                <div class="col-sm-5 text-center">
                    <small class="text-muted inline m-t-sm m-b-sm"></small>
                </div>
                <div class="col-sm-7 text-right text-center-xs">
                    <ul class="pagination pagination-sm m-t-none m-b-none">
                        {{ $products->appends(request()->input())->links() }}
                    </ul>
                </div>
            </div>
        </footer>
    </div>
</div>
<script>
    document.getElementById('selectAll').addEventListener('click', function(event) {
        let checkboxes = document.querySelectorAll('input[name="post[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    });
</script>
@endsection