function cartUpdate(e) {
    e.preventDefault();
    let urlCartUpdate = $('.cart-update-list').data('url')
    let productId = $(this).closest(".detail-qty").find(".qty-val").data('id')
    let quantity = $(this).closest(".detail-qty").find(".qty-val").val();
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'PUT',
        url: urlCartUpdate,
        dataType: 'json',
        data: {quantity: quantity, productId: productId},
        success: function (data) {
            if (data.status === 200) {
                $('.cart-product-list').html(data.cartList)
                $('.cart-dropdown-wrap').html(data.cartListDropdown)
                toastr.success('Cập nhật giỏ hàng thành công', {timeOut: 500})
            }
        },
        error: function (error) {
            toastr.success('Xảy ra lỗi, vui lòng thử lại', {timeOut: 500})
        }
    })
}




$(function () {
    $(document).on('click', ".cart-qty-up", cartUpdate)
    $(document).on('click', ".cart-qty-down", cartUpdate)
    $(document).on('blur', ".cart-product-qty", cartUpdate)
})
