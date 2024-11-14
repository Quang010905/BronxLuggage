@extends('layout.admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Add Photo Gallery
                </header>
                <form action="{{url('/insert-gallery/'.$productId)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-3" align="right">
                        </div>
                        <div class="col-md-6">
                            <input type="file" class="form-control" id="file" name="file[]" accept="images/*" multiple>
                            <span id="error_gallery"></span>
                        </div>
                        <div class="col-md-3">
                            <input type="submit" name="download" name="upload" value="upload" class="btn btn-success">
                        </div>
                    </div>
                </form>
                <div class="panel-body">
                    <div class="position-center">
                        @if(Session::has('message'))
                        <div class="alert alert-success">
                            {{ Session::get('message') }}
                        </div>
                        @endif
                        <input type="hidden" value="{{ $productId }}" name="productId" class="productId">
                        <meta name="csrf-token" content="{{ csrf_token() }}">
                        <div id="gallery_load"></div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
@endsection