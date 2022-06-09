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
                    <x-adminlte-input name="name" label="Category name" placeholder="name" id="name" label-class="text-lightblue">
                        <x-slot name="prependSlot">
                            <div class="input-group-text">
                                <i class="fas fa-newspaper text-lightblue"></i>
                            </div>
                        </x-slot>
                    </x-adminlte-input>
                    <br>
                    <x-adminlte-button class="btn-flat CreateBtn" type="submit" label="Submit" theme="success" icon="fas fa-lg fa-save"/>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')

<script>
    $(document).ready(function () {
        var table = $("#table_id").DataTable();

        $(document).on('click', '.CreateBtn', function (e) {

            var title = $('#name').val();
          
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:'{{ route('categories.store') }}',
                type: "POST",
                data: {
                    name: title,
                },
                success: function (response) {
                    var errors = response.message
                    console.log(errors);
                    if (response.errors == false) {
                        Swal.fire({
                            title: "Success",
                            text: "Category created successfully",
                            icon: "success",
                            button: "OK",
                        }).then(function() {
                            window.location = "{{route('categories.index')}}";
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Category not created",
                            icon: "error",
                            button: "OK",
                        }).then(function() {
                            window.location = "{{route('categories.index')}}";
                        });
                    }
                }
            })
        })
    });
</script>
@stop