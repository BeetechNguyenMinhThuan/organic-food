let language = $("body").data('locales');

let formatDate = 'dd/mm/yyyy',
    formatMonth = 'mm/yyyy',
    formatTime = 'HH:mm:ss',
    formatDateTime = 'DD/MM/YYYY HH:mm';

switch (language) {
    case 'vi':
        formatDate = 'dd/mm/yyyy';
        formatMonth = 'mm/yyyy';
        formatTime = 'HH:mm:ss';
        formatDateTime = 'DD/MM/YYYY HH:mm';
        break;
    case 'en':
        formatDate = 'yyyy-mm-dd';
        formatMonth = 'yyyy-mm';
        formatTime = 'HH:mm:ss';
        formatDateTime = 'YYYY-MM-DD HH:mm';
        break;
    default:
        break;
}

// Using bootstrap-datepicker Plugin
export function datePicker(selector) {
    if ($(selector).length) {
        $(selector).datepicker({
            format: formatDate,
            language: 'vi',
            todayHighlight: true,
            startDate: new Date(),
            autoClose: true
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    } else
        return false;
}

export function datePickerMultiple(selector, multidateNum = 3) {
    // giới hạn lại số năm
    let limitYearStart = moment().subtract(20, 'years').format(formatDate.toUpperCase());
    let limitYearEnd = moment().add(20, 'years').format(formatDate.toUpperCase());
    if ($(selector).length) {
        $(selector).datepicker({
            icons: {
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
            },
            useCurrent: false,
            format: formatDate,
            language: language,
            todayHighlight: true,
            multidate: multidateNum,
            multidateSeparator: ", ",
            ignoreReadonly: true,
            startDate: limitYearStart,
            endDate: limitYearEnd,
            orientation: "bottom left",
        }).on('hide', function (e) {
            e.stopPropagation();
        });
    } else
        return false;
}

export function monthPicker(selector) {
    if ($(selector).length) {
        $(selector).datepicker({
            viewMode: "months",
            minViewMode: "months",
            format: formatMonth,
            weekStart: 1,
            language: language,
            todayHighlight: true,
            autoClose: true
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    } else
        return false
}

export function yearPicker(selector) {
    if ($(selector).length) {
        $(selector).datepicker({
            viewMode: "years",
            minViewMode: "years",
            format: "yyyy",
            weekStart: 1,
            language: language,
            todayHighlight: true,
            autoClose: true
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
    } else
        return false
}

export function dateRangePicker(selector) {
    if ($(selector).length) {
        let $start = $(selector).find('.start_at'),
            $end = $(selector).find('.end_at'),
            ops = {
                format: formatDate,
                language: language,
                todayHighlight: true,
                autoClose: true
            }
        console.log(ops);
        if ($start.length && $end.length) {
            $start.datepicker(ops).on('changeDate', function (ev) {
                $end.datepicker('setStartDate', $(this).val())
                $(this).datepicker('hide');
            });
            $end.datepicker(ops).on('changeDate', function (ev) {
                $start.datepicker('setEndDate', $(this).val())
                $(this).datepicker('hide');
            });
        } else
            return false;
    } else
        return false
}

export function monthRangePicker(selector) {
    if ($(selector).length) {
        let $start = $(selector).find('.start_at'),
            $end = $(selector).find('.end_at'),
            ops = {
                viewMode: "months",
                minViewMode: "months",
                format: formatMonth,
                language: language,
                todayHighlight: true,
                autoClose: true
            }
        if ($start.length && $end.length) {
            $start.datepicker(ops).on('changeDate', function (ev) {
                $end.datepicker('setStartDate', $(this).val())
                $(this).datepicker('hide');
            });
            $end.datepicker(ops).on('changeDate', function (ev) {
                $start.datepicker('setEndDate', $(this).val())
                $(this).datepicker('hide');
            });
        } else
            return false;
    } else
        return false
}

// Using Jquery Clockpicker Plugin
export function timePicker(selector) {
    if ($(selector).length) {
        $(selector).clockpicker({
            placement: 'bottom',
            format: formatTime,
            align: 'left',
            autoclose: true,
            'default': 'now'
        });
    } else
        return false;
}

export function dateTimeRangePicker(selector) {
    if ($(selector).length) {
        let $start = $(selector).find('.start_at'),
            $end = $(selector).find('.end_at'),
            ops = {
                format: formatDateTime,
                sideBySide: true,
                locale: moment.locale(language),
                icons: {
                    previous: 'fas fa-chevron-left',
                    next: 'fas fa-chevron-right',
                },
                showClose: true,
                minDate: false,
                maxDate: false,
                useCurrent: false,
            }
        if ($start.length && $end.length) {
            $start.datetimepicker(ops).on('dp.change', function (ev) {
                if ($start.val() != '') {
                    $end.data("DateTimePicker").minDate($start.val());
                } else {
                    $end.data("DateTimePicker").minDate(false);
                }
            });
            $end.datetimepicker(ops).on('dp.change', function (ev) {
                if ($end.val() != '') {
                    $start.data("DateTimePicker").maxDate($end.val());
                } else {
                    $start.data("DateTimePicker").maxDate(false);
                }
            });
            $start.datetimepicker(ops).on('dp.show', function (ev) {
                if ($end.val() != '') {
                    $start.data("DateTimePicker").maxDate($end.val());
                } else {
                    $start.data("DateTimePicker").maxDate(false);
                }
                if ($start.val() != '') {
                    $end.data("DateTimePicker").minDate($start.val());
                } else {
                    $end.data("DateTimePicker").minDate(false);
                }
            });
            $end.datetimepicker(ops).on('dp.show', function (ev) {
                if ($start.val() != '') {
                    $end.data("DateTimePicker").minDate($start.val());
                } else {
                    $end.data("DateTimePicker").minDate(false);
                }
                if ($end.val() != '') {
                    $start.data("DateTimePicker").maxDate($end.val());
                } else {
                    $start.data("DateTimePicker").maxDate(false);
                }
            });
        } else
            return false;
    } else
        return false
}

export function dateTimePicker(selector) {
    if ($(selector).length) {
        $(selector).datetimepicker({
            format: formatDateTime,
            sideBySide: true,
            locale: moment.locale(language),
            icons: {
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
            },
            showClose: true,
            minDate: false,
            maxDate: false,
            useCurrent: false,
        });
    } else
        return false;
}

export function dateTimePickerMaxNow(selector) {
    if ($(selector).length) {
        $(selector).datetimepicker({
            format: formatDateTime,
            sideBySide: true,
            locale: moment.locale(language),
            icons: {
                previous: 'fas fa-chevron-left',
                next: 'fas fa-chevron-right',
            },
            showClose: true,
            minDate: false,
            maxDate: new Date(),
            useCurrent: false,
        });
    } else
        return false;
}

export function monthPickerMaxNow(selector) {
    if ($(selector).length) {
        $(selector).datepicker({
            viewMode: "months",
            minViewMode: "months",
            format: formatMonth,
            weekStart: 1,
            language: language,
            todayHighlight: true,
            autoClose: true,
            endDate: "0m",
            ignoreReadonly: true,
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        }).on('hide', function (e) {
            e.stopPropagation();
        });
    } else
        return false
}
