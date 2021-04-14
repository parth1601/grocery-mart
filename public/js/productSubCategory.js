$(document).ready(function () {

    $('#Products_category').change(function () {
        var categorySelector = $(this);
        subcategory(categorySelector.val());
    });
    
    var urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('crudAction')=="new"){
        $(window).on('load', function () {
            var categorySelector = $('#Products_category');
            subcategory(categorySelector.val());
        });
    }
    
    var subcategory = function (categoryId){
        $.ajax({
            url: "/admin/get-subcategory",
            type: "POST",
            dataType: "JSON",
            data: {
                categoryId: categoryId
            },
            success: function (html) {
                var subcatSelect = $("#Products_subCategory");
                subcatSelect.html('');
                $.each(html, function (index, value) {
                    subcatSelect.append('<option value="' + value.id + '">' + value.name + '</option>');
                });
            },
            error: function (err) {
                console.log("An error ocurred while loading data ...");
            }
        });
    }
});