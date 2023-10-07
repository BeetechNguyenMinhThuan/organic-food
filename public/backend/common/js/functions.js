export function actionDeleteAjax(e) {
    let url = $(this).data('url')
    let that = $(this);
    e.preventDefault();
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
                url: url,
                data: {},
                cache: false,
                success: function (data) {
                    if (data.status) {
                        that.closest('tr').remove()
                        Swal.fire(
                            'Deleted!',
                            'Xoá thành công',
                            'success'
                        )
                    }
                },
                error: function (error) {
                    console.error('error', error);
                }
            })
        }
    })
}

export function actionChangeImageUploadFile(classInput, classImg) {
    let avatar = $(classInput);
    let imgProduct = $(classImg);
    if (avatar.length && imgProduct.length) {
        avatar.onchange = evt => {
            const [file] = avatar.files
            if (file) {
                imgProduct.src = URL.createObjectURL(file)
            }
        }
    }
}
