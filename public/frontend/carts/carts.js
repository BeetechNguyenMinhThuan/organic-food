import {datePicker, timePicker} from "../../FuncPlugins/datetimepicker.js";

function cartUpdate(e) {
    let urlCartUpdate = $(".cart-update-list").data("url");
    let productId = $(this).closest(".detail-qty").find(".qty-val").data("id");
    let quantity = $(this).closest(".detail-qty").find(".qty-val").val();
    if (quantity < 1) {
        return;
    }
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        type: "PUT",
        url: urlCartUpdate,
        dataType: "json",
        data: {quantity: quantity, productId: productId},
        success: function (data) {
            if (data.status === 200) {
                $(".cart-product-list").html(data.cartList);
                $(".header-cart-list").html(data.cartListDropdown);
                toastr.success("Cập nhật giỏ hàng thành công", {
                    timeOut: 500,
                });
            }
        },
        error: function (error) {
            toastr.success("Xảy ra lỗi, vui lòng thử lại", {timeOut: 500});
        },
    });
}


$(function () {
    datePicker('[data-picker="date-picker-shipping"]');
    timePicker(".shipping_hour");

    $(document).on("click", ".cart-qty-up", cartUpdate);
    $(document).on("click", ".cart-qty-down", cartUpdate);
    $(document).on("change", ".cart-product-qty", cartUpdate);
    $(document).on("click", ".shipping-address-item", function () {
        $(".shipping-address-item").removeClass("checked")
        $(this).addClass('checked')
        $(this).find('input[type="radio"]').prop("checked", true);
        let userAddressId = $(this).closest('.form-check').data('address');
        $('input[name="user_address_id"]').val(userAddressId)
    });

    $(document).on("click", ".tab-store, .tab-ship", function () {
        $(this).find('input[type="radio"]').prop("checked", true);
    });

    $(document).on("keydown", ".checkOutCartForm input", function (event) {
        if (event.key === "Enter") {
            event.preventDefault();
        }
    });

});
