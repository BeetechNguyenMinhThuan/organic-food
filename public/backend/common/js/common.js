import {select2Base, select2Tag} from "../../../plugins/select2.js";
import {tinymce5} from "../../../plugins/tinymce5.js";
import {actionDeleteAjax,actionChangeImageUploadFile} from "./functions.js";

$(function () {
    $(document).on('click', '.action_delete', actionDeleteAjax)

    // select2 plugin
    select2Base('.select2-base');
    select2Tag('.select2-multi-tag', true);

    // tinymce plugin
    tinymce5('.tinymce5')

    actionChangeImageUploadFile('.avatar','.img-product')

});


