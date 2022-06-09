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
                    <div class="d-grid mb-3" id="form"  data-url="{{ route('categories.update',['category' => $id]) }}">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name" class="mb-sm-3 form-control"
                            value="{{$category->name}}" aria-describedby="basic-addon1">
                    </div>
                    <td><button type="button" class="btn btn-primary Updatebtn">Save</button></td>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).on('click', '.Updatebtn', function () {
            var name = $('#name').val();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:$('#form').data('url'),
                type: "PUT",
                data: {
                    name: name
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
                        }).then(function() {
                            window.location = "{{route('categories.index')}}";
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Category not edited",
                            icon: "error",
                            button: "OK",
                        }).then(function() {
                            window.location = "{{route('categories.index')}}";
                        });
                    }
                }
            })
        })
</script>
@stop