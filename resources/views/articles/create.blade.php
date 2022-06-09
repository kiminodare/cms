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
                <x-adminlte-input name="title" label="Title" placeholder="title" id="title"
                    label-class="text-lightblue">
                    <x-slot name="prependSlot">
                        <div class="input-group-text">
                            <i class="fas fa-newspaper text-lightblue"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input>
                <textarea id="content" name="editor1"></textarea>
                <br>
                <select class="mb-sm-3 form-select" name="category" id="category" aria-label="Default select example">
                    <option value="">Select Category</option>
                    @foreach($cat as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <br>
                <x-adminlte-button class="btn-flat CreateBtn" type="submit" label="Submit" theme="success"
                    icon="fas fa-lg fa-save" />
            </div>
        </div>
    </div>
</div>
@stop
@section('js')
<script src="https://cdn.ckeditor.com/4.19.0/full-all/ckeditor.js"></script>

<script>
    $(document).ready(function () {
        var table = $("#table_id").DataTable();
        CKEDITOR.replace('editor1');

        $(document).on('click', '.CreateBtn', function (e) {
            var data = CKEDITOR.instances.content.getData();

            var title = $('#title').val();
            var categories = $('#category').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route('articles.store') }}',
                type: "POST",
                data: {
                    title: title,
                    content: data,
                    categories: categories,
                },
                success: function (response) {
                    var errors = response.message
                    console.log(response);
                    if (response.errors == false) {
                        Swal.fire({
                            title: "Success",
                            text: "Article created successfully",
                            icon: "success",
                            button: "OK",
                        }).then(function() {
                            window.location = "{{route('articles.index')}}";
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Article not created",
                            icon: "error",
                            button: "OK",
                        }).then(function() {
                            window.location = "{{route('articles.index')}}";
                        });
                    }
                    // window.location.href = "{{ route('dashboard')}}";
                }
            })
        })
    });
</script>
@stop