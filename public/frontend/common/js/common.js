let timeoutID = null;

function cartDelete(e) {
    e.preventDefault();
    let productId = $(this).data('id')
    let urlCartDelete = $('.header-cart-list').data('url')
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'delete',
                url: urlCartDelete,
                data: {productId: productId},
                cache: false,
                success: function (data) {
                    if (data.status === 200) {
                        $('.cart-product-list').html(data.cartList)
                        $('.header-cart-list').html(data.cartListDropdown)
                        toastr.success('Xoá sản phẩm khỏi giỏ hàng thành công', {timeOut: 500})
                    }
                },
                error: function (error) {
                    console.error('error', error);
                }
            })
        }
    })
}

function addToCart(e) {
    e.preventDefault();
    let quantity = $(".qty-val").val()
    if (quantity < 1) {
        return;
    }
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

function favoriteProduct(e) {
    e.preventDefault();
    let urlFavorite = $(this).data('url');
    let btnAddFavorite = $(this);
    $.ajax({
        type: 'GET',
        url: urlFavorite,
        dataType: 'json',
        success: function (data) {
            if (data.status === 200) {
                btnAddFavorite.addClass('d-none');
                toastr.success('Thêm sản phẩm yêu thích thành công', {timeOut: 2000})
                $('.action-removeFavorite').removeClass('d-none')
            }
        },
        error: function (err) {
            toastr.error(err.responseJSON.data, {timeOut: 2000})
        }
    })
}

function removeFavoriteProduct(e) {
    e.preventDefault();
    let urlRemoveFavorite = $(this).data('url');
    let btnRemoveFavorite = $(this);
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'DELETE',
        url: urlRemoveFavorite,
        dataType: 'json',
        success: function (data) {
            if (data.status === 200) {
                btnRemoveFavorite.addClass('d-none');
                toastr.success('Xoá sản phẩm yêu thích thành công', {timeOut: 2000})
                $('.action-createFavorite').removeClass('d-none')
            }
        },
        error: function (err) {
            console.log(err)
            toastr.error(err.responseJSON.data, {timeOut: 2000})
        }
    })
}

function filterProduct() {
    $('.list-product-filter').html('<div class="text-center"><span class="loader123"></span></div>');
    clearTimeout(timeoutID);
    let tagsId = [];
    let brandsId = [];
    $('.filter-tag:checked').each(function (i) {
        tagsId[i] = Number.parseInt($(this).val());
    });
    $('.filter-brand:checked').each(function (i) {
        brandsId[i] = Number.parseInt($(this).val());
    });
    let urlFilter = $(this).data('url');
    timeoutID = setTimeout(() => {
        $.ajax({
            type: 'GET',
            url: urlFilter,
            dataType: 'json',
            data: {
                tagsId,
                brandsId
            },
            success: function (data) {
                if (data.status === 200) {
                    $('.list-product-filter').html(data.html)
                }
            },
            error: function (err) {
                console.log(err)
                toastr.error(err.responseJSON.data, {timeOut: 2000})
            }
        })
    }, 500)
}

$(function () {
    $(document).on('click', ".delete-cart-product", cartDelete)
    $(document).on('click', ".button-add-to-cart", addToCart);
    $(document).on('click', ".action-createFavorite", favoriteProduct);
    $(document).on('click', ".action-removeFavorite", removeFavoriteProduct);
    $(document).on('click', ".btnFilterProduct", filterProduct);
})
