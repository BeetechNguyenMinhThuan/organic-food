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
            if(data.code === 200){
                toastr.success('Thêm vào giỏ hàng thành công', {timeOut: 2000})
            }
        },
        error: function () {

        }

    })
}

$(function () {
    $(".button-add-to-cart").on('click', addToCart);
})
