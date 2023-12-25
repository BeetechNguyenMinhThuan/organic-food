$(document).ready(function () {
    // changeCategoryProduct()
});
function changeCategoryProduct(){
    $('.nav-tab-product').on('click', function(e){
        let categoryIndex = $(this).data('index')
        $(".product-popular").attr('id',`tab-${categoryIndex}`)
    })
}
