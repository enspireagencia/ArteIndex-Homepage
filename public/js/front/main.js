$(document).ready(function(){
    $("#login_signin_btn").on("click", function(event){
        event.preventDefault();
        var usr_tokn = $('input[name="_token"]').val();
        var email = $('#login-email').val();
        var password = $('#login-password').val();
        $.ajax({
            type: "POST",
            url: "/login",
            data:{'_token':usr_tokn,'email':email,'password':password},
            success: function (response) {
                if(response.status == "error"){
                    swal.fire({
                        text: response.message,
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn font-weight-bold btn-light-primary"
                        }
                    }).then((function() {
                        KTUtil.scrollTop()
                    }))
                }else{
                   window.location.href="/dashboard";
                }

            }
        });
        
    });
});