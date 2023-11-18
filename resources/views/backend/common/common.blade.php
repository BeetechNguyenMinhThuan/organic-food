<script type="text/javascript">
    function preViewImage(parent, old) {
        parent.find(".preview_image").click(function (e) {
            parent.find('.btn_gallery').attr('value', '');
            parent.find(".btn_gallery").trigger('click');
        });
        parent.find('.btn_gallery').change(function (e) {
            let file = e.target.files[0];
            if (file && file.type.startsWith("image/")) {
                parent.find('.preview_image').attr('src', URL.createObjectURL(e.target.files[0]));
            } else {
                parent.find('.btn_gallery').val('');
                old.val('');
            }
        });
        parent.find('.btn_remove_image').click(function (e) {
            parent.find('.btn_gallery').val('');
            old.val('');
        })
    }
</script>
