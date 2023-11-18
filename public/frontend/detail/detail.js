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
            }else{
            }
        },
        error: function (err) {
            toastr.error(err.responseJSON.data, {timeOut: 2000})
        }
    })
}

$(function () {
    checkFavorite();

})
