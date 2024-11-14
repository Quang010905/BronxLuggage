@extends('layout.admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            List Comment
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
            <form method="POST" action="{{ url('/delete-comments') }}" onsubmit="return confirm('Are you sure you want to delete the selected items?');">
                @csrf
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" id="selectAll"><i></i>
                                </label>
                            </th>
                            <th>Confirm</th>
                            <th>Comment Name</th>
                            <th>Comment</th>
                            <th>Created</th>
                            <th>Comment Product</th>
                            <th>Comment management</th>
                            <th style="width:30px;"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comment as $key => $comm)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]" value="{{ $comm->comment_id }}"><i></i></label></td>
                            <td>
                                @if($comm->comment_status == 1)
                                <a href="{{url('/unactive-comment/'. $comm->comment_id)}}">
                                    <span class="fa-thumb-styling fa fa-eye" title="Click to hide this comment"></span>
                                </a>
                                @else
                                <a href="{{url('/active-comment/'. $comm->comment_id)}}">
                                    <span class="fa-thumb-styling fa fa-eye-slash" title="Click to display this comment"></span>
                                </a>
                                @endif
                            </td>
                            <td>{{$comm-> comment_name}}</td>
                            <td>{{$comm-> comment_content}}</td>

                            <td>{{$comm-> created_at}}</td>
                            <td>{{$comm-> product-> product_name}}</td>

                            <td>
                                <a href="{{url('/detele-comment/'.$comm->comment_id)}}" class="active styling-delete" ui-toggle-class="" onclick="return confirm('Are you sure?')">
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

    </div>
</div>
<script>
    document.getElementById('selectAll').addEventListener('click', function(event) {
        let checkboxes = document.querySelectorAll('input[name="post[]"]');
        checkboxes.forEach(checkbox => checkbox.checked = event.target.checked);
    });
</script>
@endsection