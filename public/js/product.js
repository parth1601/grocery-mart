$(document).ready(function () {

    $(window).on('load', function () {
        var id = 5;
        var aa_product_catg = $("#chocolatesList");
        arrangeProducts(id, aa_product_catg);
        var id = 10;
        var aa_product_catg = $("#oilList");
        arrangeProducts(id, aa_product_catg);
        var id = 12;
        var aa_product_catg = $("#riceList");
        arrangeProducts(id, aa_product_catg);
        var id = 17;
        var aa_product_catg = $("#snackesList");
        arrangeProducts(id, aa_product_catg);
        
    });

    var arrangeProducts = function (categoryId, aa_product_catg) {
        $.ajax({
            url: "/products/get-products",
            type: "POST",
            dataType: "JSON",
            data: { id: categoryId },
            success: function (html) {

                aa_product_catg.html('');
                $.each(html, function (index, value) {
                    // console.log(value);
                    var status;
                    if (value.status) {
                        status = '<span class="aa-badge aa-sale" href="#">SALE!</span></li>';
                    }
                    else {
                        status = '<span class="aa-badge aa-sold-out" href="#">SOLD OUT!</span></li>';
                    }
                    aa_product_catg.append(' <li class="col-md-3" ><figure ><a  class="aa-product-img" href="/products/detail/'+value.id+'"><img src="images/product/'
                        + value.img
                        + '" height="300" alt="'
                        + value.key
                        + '"></a><a class="aa-add-card-btn" id="'
                        + value.id
                        + '"><span class="fa fa-shopping-cart"></span>Add To Cart</a><figcaption><h5 class="aa-product-title"><a>'
                        + value.name
                        + '</a></h5><span class= "aa-product-price" >₹ '
                        + (value.pa) / 100
                        + '</span > <span class="aa-product-price"><del>₹'
                        + (value.pb) / 100
                        + '</del></span></figcaption></figure>'
                        + '<div class="aa-product-hvr-content">'
                        // + '<a href="#" data-toggle="tooltip" data-placement="top" title="Add to Wishlist"><span class="fa fa-heart-o"></span></a>'
                        // + '<a href="#" data-toggle="tooltip" data-placement="top" title="Compare"><span class="fa fa-exchange"></span></a>'
                        + '<a  data-toggle2="tooltip" data-placement="top" title="Quick View" data-toggle="modal"  data-target="#quick-view-modal" class="modal2" id="'
                        + value.id
                        + '" onclick="modal(this.id)"><span class="fa fa-search" ></span></a></div>'
                        + status);

                });
            },
            error: function (err) {
                console.log("An error ocurred while loading data ...");
            }
        });
    }
});

function modal(id){
    var id = id;
    // console.log(id);
    // console.log("hello...!!");
    $.ajax({
        url: "/products/getproductbyid",
        type: "POST",
        dataType: "JSON",
        data:{ id:id},
        success: function (html) {
            var modal1 = $("#modal1");
            var img = $(".simpleLens-big-image-container");
            var btn = $("#modalButtons");
            modal1.html('');
            img.html('');
            btn.html('');
            $.each(html, function (index, value) {
                // console.log(value);
                var status;
                if (value.status) {
                    status = "In Stock";
                } 
                else {
                    status = "Out Of Stock";
                }
                modal1.append(
                '<h3>'+value.name+'</h3>'+
                '<div class= "aa-price-block" >'+
                    '<span class="aa-product-view-price">₹ '+value.pa/100+'</span>'+
                    '<p class="aa-product-avilability">Avilability: <span>'+status+'</span></p>'+
                '</div >'+
                    '<p>' + value.description+'</p>'+
                    // '<h4>Size</h4>'+
                    '<p class="aa-prod-category">'+
                    'Category: <a href="#">'+value.category+'</a>'+
                '</p>'
                );
                img.append(
                    '<a class="simpleLens-lens-image" data-lens-image="/images/product/'+value.img+'">'+
                    '<img src = "/images/product/' + value.img +'" height = "300" class= "simpleLens-big-image" >'+
                    '</a >');
                btn.append('<a href="#" class="aa-add-to-cart-btn"><span class="fa fa-shopping-cart"></span>Add To Cart</a>'+
                    '<a href="/products/detail/' + value.id +'" class= "aa-add-to-cart-btn" > View Details</a>');
            });
        },
        error: function (err) {
            console.log("An error ocurred while loading data ...");
        }
    });
}