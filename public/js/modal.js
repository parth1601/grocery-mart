$(document).ready(function () {

    $(window).on('load',function () {
        // $("#aa-login-form").hide();
        $("#registrationFormInModel").hide();
    });

    $("#register").click( function () {
        $("#loginFormInModel").hide();
        $("#registrationFormInModel").show();
    });

    $("#loginHere").click(function () {
        $("#loginFormInModel").show();
        $("#registrationFormInModel").hide();
    });
});