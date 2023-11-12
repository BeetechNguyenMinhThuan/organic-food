(function ($) {
    'use strict';
    /*Product Details*/
    var productDetails = function () {
        $('.product-image-slider').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: false,
            asNavFor: '.slider-nav-thumbnails',
        });

        $('.slider-nav-thumbnails').slick({
            slidesToShow: 4,
            slidesToScroll: 1,
            asNavFor: '.product-image-slider',
            dots: false,
            focusOnSelect: true,

            prevArrow: '<button type="button" class="slick-prev"><i class="fi-rs-arrow-small-left"></i></button>',
            nextArrow: '<button type="button" class="slick-next"><i class="fi-rs-arrow-small-right"></i></button>'
        });

        // Remove active class from all thumbnail slides
        $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');

        // Set active class to first thumbnail slides
        $('.slider-nav-thumbnails .slick-slide').eq(0).addClass('slick-active');

        // On before slide change match active thumbnail to current slide
        $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            $('.slider-nav-thumbnails .slick-slide').removeClass('slick-active');
            $('.slider-nav-thumbnails .slick-slide').eq(mySlideNumber).addClass('slick-active');
        });

        $('.product-image-slider').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var img = $(slick.$slides[nextSlide]).find("img");
            $('.zoomWindowContainer,.zoomContainer').remove();
            $(img).elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 750
            });
        });
        //Elevate Zoom
        if ($(".product-image-slider").length) {
            $('.product-image-slider .slick-active img').elevateZoom({
                zoomType: "inner",
                cursor: "crosshair",
                zoomWindowFadeIn: 500,
                zoomWindowFadeOut: 750
            });
        }
        //Filter color/Size
        $('.list-filter').each(function () {
            $(this).find('a').on('click', function (event) {
                event.preventDefault();
                $(this).parent().siblings().removeClass('active');
                $(this).parent().toggleClass('active');
                $(this).parents('.attr-detail').find('.current-size').text($(this).text());
                $(this).parents('.attr-detail').find('.current-color').text($(this).attr('data-color'));
            });
        });
        //Qty Up-Down
        // Sử dụng delegation cho sự kiện click trên phần tử có class 'qty-up' hoặc 'qty-down'
        $(document).on('click', '.cart-qty-up, .cart-qty-down', function (event) {
            event.preventDefault();
            var qtyInput = $(this).closest('.detail-qty').find('.qty-val');
            var qtyval = parseInt(qtyInput.val(), 10);

            if ($(this).hasClass('qty-up')) {
                qtyval = qtyval + 1;
            } else if ($(this).hasClass('qty-down')) {
                qtyval = qtyval - 1;
                if (qtyval < 1) {
                    alert("Số lượng phải lớn hơn hoặc bằng 1!");
                    $(this).val(1)

                }
                qtyval = qtyval > 1 ? qtyval : 1;
            }

            qtyInput.val(qtyval);
        });
        $(document).on('change', ".qty-val", function (event) {
            let value = $(this).val();

            if (value < 1) {
                alert("Số lượng phải lớn hơn hoặc bằng 1!");
                $(this).val(1)
            }
        });


        $('.dropdown-menu .cart_list').on('click', function (event) {
            event.stopPropagation();
        });
    };

    //Load functions
    $(document).ready(function () {
        productDetails();
    });

})(jQuery);
