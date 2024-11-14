@extends('layout.admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Update Category
                </header>
                <div class="panel-body">
                    @foreach($categories as $category)
                    <div class="position-center">
                        @if(Session::has('msg'))
                        <span style="color:red">
                            {{session('msg')}}
                        </span>
                        @endif
                        <form role="form" method="post" action="{{url('/update-category/'. $category->category_id)}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Name Category</label>
                                <input type="text" value="{{$category->category_name}}" name="category_name" class="form-control" id="exampleInputEmail1" placeholder="Category_name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="category_description" id="exampleInputPassword1">{{$category->category_description}}</textarea>
                            </div>
                            <button type="submit" name="update_category" class="btn btn-info">Update Category</button>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
        @endsection