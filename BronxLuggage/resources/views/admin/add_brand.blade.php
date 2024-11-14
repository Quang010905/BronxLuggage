@extends('layout.admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Brand
                </header>
                <div class="panel-body">
                    <div class="position-center">
                        @if(Session::has('msg'))
                        <span style="color:red">
                            {{session('msg')}}
                        </span>
                        @endif
                        <form role="form" method="post" action="{{url('/save-brand')}}">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand Name</label>
                                <input type="text" name="brand_name" class="form-control" id="exampleInputEmail1" placeholder="brand_name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Description</label>
                                <textarea style="resize: none" rows="5" class="form-control" name="brand_description" id="exampleInputPassword1" placeholder="Description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Status</label>
                                <select name="brand_status" class="form-control input-sm m-bot15">
                                    <option value="1">Show</option>
                                    <option value="0">Hide</option>
                                </select>
                            </div>
                            <button type="submit" name="add_brand" class="btn btn-info">Add Brand</button>
                        </form>
                    </div>

                </div>
            </section>

        </div>
        @endsection