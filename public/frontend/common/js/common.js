function cartDelete(e) {
    e.preventDefault();
    let productId = $(this).data('id')
    let urlCartDelete = $('.header-cart-list').data('url')
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'DELETE',
        url: urlCartDelete,
        dataType: 'json',
        data: {productId: productId},
        success: function (data) {
            if (data.status === 200) {
                $('.cart-product-list').html(data.cartList)
                $('.header-cart-list').html(data.cartListDropdown)
                toastr.success('Xoá sản phẩm khỏi giỏ hàng thành công', {timeOut: 500})
            }
        },
        error: function (error) {

        }
    })
}

function addToCart(e) {
    e.preventDefault();
    let quantity = $(".qty-val").val()
    let urlAddCart = $(this).data('url');
    $.ajax({
        type: 'GET',
        url: urlAddCart,
        dataType: 'json',
        data: {quantity: quantity},
        success: function (data) {
            if (data.code === 200) {
                $('.header-cart-list').html(data.cartListDropdown)
                toastr.success('Thêm vào giỏ hàng thành công', {timeOut: 2000})
            }
        },
        error: function (err) {
            toastr.error(err.responseJSON.data, {timeOut: 2000})
        }
    })
}


$(function () {
    $(document).on('click', ".delete-cart-product", cartDelete)
    $(document).on('click', ".button-add-to-cart", addToCart);

})
