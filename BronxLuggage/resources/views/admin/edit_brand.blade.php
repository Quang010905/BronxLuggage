@extends('layout.admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Update Brand
                </header>
                <div class="panel-body">
                    @foreach($brands as $brand)
                    <div class="position-center">
                        @if(Session::has('msg'))
                        <span style="color:red">
                            {{session('msg')}}
                        </span>
                        @endif
                        <form role="form" method="post" action="{{url('/update-brand/'. $brand->brand_id)}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name Brand</label>
                                <input type="text" value="{{$brand->brand_name}}" name="brand_name" class="form-control" id="exampleInputEmail1" placeholder="Brand_name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="brand_description" id="exampleInputPassword1">{{$brand->brand_description}}</textarea>
                            </div>
                            <button type="submit" name="update_brand" class="btn btn-info">Update Brand</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
        @endsection