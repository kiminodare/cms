@extends('adminlte::page')

@section('title', 'AdminLTE')
@section('css')
    <link rel="stylesheet" href="assets/css/dashboard.css">
@stop
@section('content_header')
    <h1 class="m-0 text-dark">Articles</h1>
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
                    <a type="button" href="{{ route('articles.create') }}" class="mb-sm-3 btn btn-success">Add article</a>
                    <table class="table" id="table_id">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Created Date</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody id="tbody">
                        @foreach ($article as $key => $list)
                            <tr>
                              <td class="number">{{++$key}}</td>
                            
                              <td>{{$list->title}}</td>
                              <td>{{$list->created_at}}</td>
                              {{-- GBLK HREF DI BUTTON hahahaha,jangan bawa email bawa id aja  --}}
                              <td><a href='{{ route('articles.edit',['article' => $list->id]) }}' type="button" class="btn btn-info">Edit</a> <button type="button" data-url="{{ route('articles.destroy',['article' => $list->id]) }}" class="delete btn btn-danger">Delete</button></td>
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

        $('.delete').click(function () {
            var url = $(this).data('url');
            console.log(url);
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
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                        url: url,
                        type: "DELETE",
                        success: function (response) {
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            ).then(function() {
                                window.location = "{{route('articles.index')}}";
                            });
                        }
                    })
                }
            })
        })
    });
</script>
@stop