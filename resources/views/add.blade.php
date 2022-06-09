@extends('adminlte::page')

@section('title', 'AdminLTE')
{{-- @section('css')
    <link rel="stylesheet" href="assets/css/dashboard.css">
@stop --}}
@section('content_header')
    <h1 class="m-0 text-dark">Dashboard</h1>
@stop
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
                    <form method="POST" enctype="multipart/form-data" id="laravel-ajax-file-upload" data-url="{{ route('store.user') }}" action="javascript:void(0)" >
                        <div class="d-grid mb-3">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name" class="mb-sm-3 form-control" aria-describedby="basic-addon1">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email" class="mb-sm-3 form-control" aria-describedby="basic-addon1">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="mb-sm-3 form-control" aria-describedby="basic-addon1">
                            <label for="file">Upload Photo</label>
                            <input type="file" name="file" class="mb-sm-3 form-control-file" id="exampleFormControlFile1">
                        </div>
                        <td><button type="button" class="btn btn-primary Updatebtn">Save</button></td>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('js')
<script>
    $(document).on('click', '.Updatebtn', function (e) {
            e.preventDefault();
            var name = $('#name').val();
            var email = $('#email').val();
            var password = $('#password').val();
            var url = $('#laravel-ajax-file-upload').data('url')
            var fd = new FormData();
            fd.append('name', name) // Name template
            fd.append('email', email) // Message Template
            fd.append('password', password) // Message Template
            fd.append('file', $('#exampleFormControlFile1').get(0).files[0]) // put the file here
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url:url,
                type: "POST",
                data: fd,
                cache: false,
                contentType: false,
                processData: false,
                cache: false,
                success: function (response) {
                    var errors = response.message
                    console.log(response)
                    if (response.errors == true) {
                        $(".alert-danger").show()
                        $.each(errors, function (key, value) {
                            $(".alert-danger").text(value);
                            // alert(key + ": " + value);
                            $(window).scrollTop(0);
                        });
                    } else {
                        window.location.href = "{{ route('dashboard')}}";
                    }
                }
            })
        })
</script>
@stop