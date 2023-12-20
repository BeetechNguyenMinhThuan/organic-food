<script type="text/javascript">
    function viewCustomer() {
        const productId = $(this).data('product-id');

        $.ajax({
            url: '{{ route('admin.statistic.product.showCustomer')}}',
            type: 'get',
            data: {
                productId: productId,
            },
            success: function (response) {
                const data = response;
                let modalContent = '<ul>';
                data.forEach((customer) => {
                    modalContent +=
                        `<li class='mb-3'>
                            <p>Tên khách hàng: ${customer.first_name} ${customer.last_name}</p>
                            <p>Email: ${customer.email}</p>
                        </li>`
                });
                modalContent+='</ul>'

                $('.modal-body').html(modalContent);

            },
            error: function (xhr, status, error) {
                console.log(error);
            }
        });
    }

    $(function () {
        $(document).on('click', '.view-customer', viewCustomer)
    })
</script>
