$(document).on('click', '.RegisterBtn', function () {
    var name = $('#name').val();
    var username = $('#username').val();
    var exampleInputEmail1 = $('#exampleInputEmail1').val();
    var phone_number = $('#phone_number').val();
    var password = $('#InputPassword').val();
    var subscription_type = $('input[name="subscription_type"]:checked').val();
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    $.ajax({
        url: "{{ $login_url }}",
        type: "POST",
        data: {
            username: username,
            name: name,
            phone_number: phone_number,
            email: exampleInputEmail1,
            password: password,
            subscription_type: subscription_type
        },
        cache: false,
        success: function (response) {
            // var errors = response.message
            console.log(response)
            return false
            // if (response.errors == true) {
            //     $(".alert-danger").show()
            //     $.each(errors, function (key, value) {
            //         $(".alert-danger").text(value);
            //         // alert(key + ": " + value);
            //         $(window).scrollTop(0);
            //     });
            // } else if (response.error == true) {
            //     $(".alert-danger").show()
            //     $(".alert-danger").text(response.message);
            //     $(window).scrollTop(0);
            // } else if (response.payment == true) {
                
            //     window.location.href = response.message;
            // } else if (response.message == "Success") {
            //     swal(
            //         'Success!',
            //         'Your 7-day trial registration is successful, please login below to start using Bizappbot',
            //         'success'
            //     ).then(function () {
            //         window.location.href = "{{ route('login')}}";
            //     });
            // }
        }
    })
})