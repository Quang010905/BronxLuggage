@extends('layout.admin_layout')
@section('admin_content')
<div class="table-agile-info">
    <div class="panel panel-default">
        <div class="panel-heading">
            List Category
        </div>
        <div class="row w3-res-tb">
            <div class="col-sm-2 m-b-xs">
                Search By Name
                <form method="get" action="{{url('/search-category-name')}}">
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
            <form method="POST" action="{{ url('/delete-categories') }}" onsubmit="return confirm('Are you sure you want to delete the selected items?');">
                @csrf
                <table class="table table-striped b-t b-light">
                    <thead>
                        <tr>
                            <th style="width:20px;">
                                <label class="i-checks m-b-none">
                                    <input type="checkbox" id="selectAll"><i></i>
                                </label>
                            </th>
                            <th>Category Name</th>
                            <th>Status</th
                                <th style="width:30px;">
                            </th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td><label class="i-checks m-b-none"><input type="checkbox" name="post[]" value="{{ $category->category_id }}"><i></i></label></td>
                            <td>{{$category->category_name}}</td>
                            <td>
                                @if($category->category_status == 1)
                                <a href="{{url('/unactive-category/'. $category->category_id)}}"><span class="fa-thumb-styling fa fa-eye"></span></a>
                                @else
                                <a value="{{ $category->category_id }}"href="{{url('/active-category/'. $category->category_id)}}"><span class="fa-thumb-styling fa fa-eye-slash"></span></a>
                                @endif
                            </td>
                            <td>
                                <a href="{{url('/edit-category/'.$category->category_id)}}" class="active styling-edit" ui-toggle-class="">
                                    <i class="fa fa-pencil-square-o text-success text-active"></i>
                                </a>
                                <a href="{{url('/detele-category/'.$category->category_id)}}" class="active styling-delete" ui-toggle-class="" onclick="return confirm('Are you sure?')">
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
                        {{ $categories->appends(request()->input())->links() }}
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