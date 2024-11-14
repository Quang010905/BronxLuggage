@extends('layout.admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            List Customer Account
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-2 m-b-xs">
                Search By Name
                <form method="get" action="{{url('search-customer-name')}}">
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
            <form method="POST" action="{{ url('/delete-customers') }}" onsubmit="return confirm('Are you sure you want to delete the selected items?');">
                @csrf
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" id="selectAll"><i></i>
                                </label>
                            </th>
                            <th>Customer Name</th>
                            <th>Customer Email</th>
                            <th>Customer Password</th>
                            <th>Phone</th>
                            <th>Birthday</th>
                            <th>Gender</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($customers as $customer)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]" value="{{ $customer->customer_id }}"><i></i></label></td>
                            <td>{{$customer->customer_name}}</td>
                            <td>{{$customer->customer_email}}</td>
                            <td>{{$customer->customer_password}}</td>
                            <td>{{$customer->customer_phone}}</td>
                            <td>{{$customer->customer_birthday}}</td>
                            <td>{{$customer->customer_gender}}</td>
                            <td>
                                <a href="{{url('/detele-customer/'.$customer->customer_id)}}" class="active styling-delete" ui-toggle-class="" onclick="return confirm('Are you sure?')">
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
                        {{ $customers->appends(request()->input())->links() }}
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