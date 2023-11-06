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

$(function () {
    $(document).on('click', ".delete-cart-product", cartDelete)
})
