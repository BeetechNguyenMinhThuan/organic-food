let timeoutID = null;

function showModalOrderDetail(e) {
    e.preventDefault();

}

function searchOrder(e) {
    e.preventDefault();
    let orderSearch = $('.order_search').val();
    let urlSearch = $(this).data('url');
    if (orderSearch) {
        $('.list-profile-orders').html('<div class="text-center"><span class="loader123"></span></div>');
        clearTimeout(timeoutID);

        timeoutID = setTimeout(() => {
            $.ajax({
                type: 'GET',
                url: urlSearch,
                dataType: 'json',
                data: {
                    order_search: orderSearch,
                },
                success: function (data) {
                    if (data.status === 200) {
                        $('.list-profile-orders').html(data.html)
                    }
                },
                error: function (err) {
                    console.log(err)
                    toastr.error(err.responseJSON.data, {timeOut: 2000})
                }
            })
        }, 500)
    }else{
        location.reload();
    }
}

$(function () {
    $(document).on("click", ".action-view-order", showModalOrderDetail);
    $(document).on("click", ".searchOrder", searchOrder);

});
