@extends('layout.admin_layout')
@section('admin_content')
<div class="form-w3layouts">
    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Contacts
                </header>
                <div class="panel-body">
                    @foreach($contacts as $contact)
                    <div class="position-center">
                        @if(Session::has('msg'))
                        <span style="color:red">
                            {{session('msg')}}
                        </span>
                        @endif
                        <form role="form">
                            @csrf
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customer Name</label>
                                <input type="text" value="{{$contact->contact_customername}}" name="customer_name" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Customer Email</label>
                                <input type="text" value="{{$contact->contact_customeremail}}" name="customer_email" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Subject</label>
                                <input type="text" value="{{$contact->contact_subject}}" name="customer_subject" class="form-control" id="exampleInputEmail1">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputPassword1">Message</label>
                                <textarea style="resize: none" rows="20" class="form-control" name="customer_message" id="exampleInputPassword1">{{$contact->contact_message}}</textarea>
                            </div>
                        </form>
                    </div>
                    @endforeach
                </div>
            </section>

        </div>
        @endsection