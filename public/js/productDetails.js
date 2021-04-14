$(document).ready(function () {
    $(window).on('load', function () {
        var pathname = window.location.pathname.split("/");
        var id = pathname[3];
        var description = $('#description');
        description.html('');
        $.ajax({
            url: "/products/getproductbyid",
            type: "POST",
            dataType: "JSON",
            data: { id: id },
            success: function (html) {
                $.each(html, function (index, value) {
                    console.log(value);
                    description.append('<p>' + value.description + '</p>');
                });
            },
            error: function (err) {
                console.log("An error ocurred while loading data ...");
            }
        });
    });
});