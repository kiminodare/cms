@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('css')
    <link rel="stylesheet" href="assets/css/dashboard.css">
@stop
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop
@section('plugins.Datatables', true)
@section('plugins.Sweetalert2', true)
@section('content')
<div class="row">
    <div class="col-12">
        @include('panel.flash-message')
    </div>
</div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <a type="button" href="{{ route('add.user') }}" class="mb-sm-3 btn btn-success">Add user</a>
                    <table class="table" id="table_id">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach ($users as $key => $list)
                            <tr>
                              <td class="number">{{++$key}}</td>
                              @if ($list->path == null)
                                <td class="image"><img src="{{ asset('storage/images/default.jpg') }}" border=3 style="max-width: 5%"> {{$list->name}}</td>
                                @else
                                <td class="image"><img src="{{ asset('storage/images/'.$list->path) }}" border=3 style="max-width: 5%"> {{$list->name}}</td>
                              @endif
                              <td>{{$list->email}}</td>
                              <td>{{$list->role}}</td>
                              {{-- GBLK HREF DI BUTTON hahahaha,jangan bawa email bawa id aja  --}}
                              <td><a href='{{ route('edit.profile',['id' => $list->id]) }}' type="button" class="btn btn-info">Edit</a> <button type="button" data-url="{{ route('delete.profile',['id' => $list->id]) }}" class="delete btn btn-danger">Delete</button></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')

<script>
    $(document).ready(function () {
        var table = $("#table_id").DataTable();

        $('.delete').click(function(){
            var url = $(this).data('url');
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.get(url,function(e){
                            Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                            )
                        }).then(function() {
                            window.location = "{{route('dashboard')}}";
                        });
                    }
                })

        })
    });
</script>
@stop