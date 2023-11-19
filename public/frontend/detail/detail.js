function checkFavorite() {
    let checkFavoriteUrl = $('.product-detail').data('check')
    let btnAddFavorite = $('.action-createFavorite');
    let btnRemoveFavorite = $('.action-removeFavorite');

    $.ajax({
        type: 'GET',
        url: checkFavoriteUrl,
        dataType: 'json',
        success: function (data) {
            if (data.status === 200) {
                if (data.data) {
                    btnAddFavorite.addClass('d-none');
                    btnRemoveFavorite.removeClass('d-none');
                }
            } else {
            }
        },
        error: function (err) {
            toastr.error(err.responseJSON.data, {timeOut: 2000})
        }
    })
}

function ratingProduct(e) {
    e.preventDefault();
    let ratingProduct = $(this).data('url')
    let comment = $(".comment").val();
    let ratingStar = $('input[name="rating"]:checked').val();
// Hiển thị giá trị của radio button đang được chọn trong console
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        url: ratingProduct,
        dataType: 'json',
        data: {
            comment, ratingStar
        },
        success: function (data) {
            if (data.status === 200) {
                toastr.success('Gửi đánh giá thành công', {timeOut: 500})
                $('.comment').val("");
                 $('input[name="rating"]:checked').prop('checked', false);

            }
        },
        error: function (err) {
            toastr.error(err.responseJSON.data, {timeOut: 2000})
        }
    })
}

$(function () {
    checkFavorite();
    $(document).on('click', ".btn-rating-product", ratingProduct);
})
