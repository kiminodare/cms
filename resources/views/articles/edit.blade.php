@extends('adminlte::page')

@section('title', 'AdminLTE')
{{-- @section('css')
    <link rel="stylesheet" href="assets/css/dashboard.css">
@stop --}}
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop
@section('plugins.Sweetalert2', true)
@section('plugins.Datatables', true)
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
                    <div class="d-grid mb-3" id="form"  data-url="{{ route('articles.update',['article' => $id]) }}">
                        <label for="name">Name</label>
                        <input type="text" name="title" id="title" class="mb-sm-3 form-control"
                            value="{{$article->title}}" aria-describedby="basic-addon1">
                        <textarea name="editor1" id="content" rows="10" cols="80">
                            {{$article->content}}
                        </textarea>
                        <select class="mb-sm-3 form-select" name="category" id="category" aria-label="Default select example">
                            <option value="{{$cat->id}}">{{$cat->name}}</option>
                            @foreach ($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <td><button type="button" class="btn btn-primary Updatebtn">Save</button></td>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script src="https://cdn.ckeditor.com/4.19.0/full-all/ckeditor.js"></script>
<script>
    CKEDITOR.replace('editor1');
    $(document).on('click', '.Updatebtn', function () {
        var data = CKEDITOR.instances.content.getData();

        var title = $('#title').val();
        var categories = $('#category').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: $('#form').data('url'),
            type: "PUT",
            data: {
                title: title,
                content: data,
                categories: categories,
            },
            success: function (response) {
                var errors = response.message
                console.log(errors);
                if (response.errors == false) {
                    Swal.fire({
                        title: "Success",
                        text: "Category edit successfully",
                        icon: "success",
                        button: "OK",
                    }).then(function () {
                        window.location = "{{route('articles.index')}}";
                    });
                } else {
                    Swal.fire({
                        title: "Error",
                        text: "Category not edited",
                        icon: "error",
                        button: "OK",
                    }).then(function () {
                        window.location = "{{route('articles.index')}}";
                    });
                }
            }
        })
    })
</script>
@stop