function productQuickView(e){

    event.preventDefault();

    let productId = $(e).data('id');
    var fetchUrl = ROOT_URL+'ajax/productQuickView.php';

    var QuickModal = $("#product_quick_viewModal");
    QuickModal.modal('show');

    // H -> Html
    var H_productId = $("#qm-product_id");
    var H_productName = $("#qm-name");
    var H_productDesc = $("#qm-desc");
    var H_productOldPrice = $("#qm-old_price");
    var H_productNewPrice = $("#qm-new_price");
    var H_ViewMore = $("#qm-view_more");
    var H_productImges = $("#qm-product_images");
    
    var slickSliderParent = $('.product-details-left');
    slickSliderParent.find('.slick-initialized').removeClass('slick-initialized');
    slickSliderParent.find('.slick-slider').removeClass('slick-slider');

    H_productImges.empty();

    $.ajax({

        type: 'POST',
        url : fetchUrl,
        dataType: 'json',
        data: {
            'product_id' : productId,
            'quick_view' : 'yes'
        },
        success:function(res){

            H_productId.val(productId);
            H_productName.html(res.name);
            H_productDesc.html(res.desc);
            H_productOldPrice.html(res.old_price);
            H_productNewPrice.html(res.new_price);
            H_ViewMore.attr('href', res.url);
            H_productImges.html(res.lg_img);

             /* Product Details Images Slider */
            if ($(".product-details-images").length) {
                
                $(".product-details-images").slick({
                    arrows: true,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    autoplay: true,
                    autoplaySpeed: 2000,
                    dots: false,
                    infinite: true,
                    centerMode: false,
                    centerPadding: 0,
                    prevArrow: '<span class="slick-prev"><i class="fa fa-angle-left"></i></span>',
                    nextArrow: '<span class="slick-next"><i class="fa fa-angle-right"></i></span>',
                });

            };
            


        }, // success
        error:function(err){
            console.log(err);
        }

    });

}//productQuickView


$(".change_page_no").on('click', function(){

    event.preventDefault();

    var page = $(this).data('value');
    var url = window.location.href;
    var refreshURL = replaceUrlParam(url, 'page', page);
    window.location.href = refreshURL;

});

function sortProducts(e){
    var value = $(e).val();
    var url = window.location.href;
    var refreshURL = replaceUrlParam(url, 'sort', value);
    window.location.href = refreshURL;
}
