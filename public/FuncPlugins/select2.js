export function select2Base(selector) {
    if ($(selector).length) {
        $(selector).select2({
            addCssClass: "error",
        });
    }
}

export function select2Tag(selector, multiple = false) {
    if ($(selector).length) {
        $(selector).select2({
            addCssClass: "error",
            // language: language,
            tags: true,
            allowClear: true,
            multiple: multiple,
            tokenSeparators: [',', ' ']
        });
    }
}
