'use strict'

const Plugins = [
    // SweetAlert2
    {
        from: 'node_modules/sweetalert2/dist/',
        to: 'public/plugins/sweetalert2'
    },
    {
        from: 'node_modules/@sweetalert2/theme-bootstrap-4/',
        to: 'public/plugins/sweetalert2-theme-bootstrap-4'
    },

    // Toastr
    {
        from: 'node_modules/toastr/build/',
        to: 'public/plugins/toastr'
    },
    // toastr
    {
        from: 'node_modules/toastr',
        to: 'public/plugins/toastr'
    },

    //bootstrap datetimepicker
    {
        from: 'node_modules/bootstrap-datepicker/dist',
        to: 'public/plugins/bootstrap-datepicker'
    },
    {
        from: 'node_modules/bootstrap-datetimepicker',
        to: 'public/plugins/bootstrap-datetimepicker'
    },

    {
        from: 'node_modules/eonasdan-bootstrap-datetimepicker',
        to: 'public/plugins/eonasdan-bootstrap-datetimepicker'
    },

    //eonasdan bootstrap datetimepicker
    {
        from: 'node_modules/eonasdan-bootstrap-datetimepicker',
        to: 'public/plugins/eonasdan-bootstrap-datetimepicker'
    },


    // Moment
    {
        from: 'node_modules/moment/min',
        to: 'public/plugins/moment'
    },
    {
        from: 'node_modules/moment/locale',
        to: 'public/plugins/moment/locale'
    },

    // moment js
    {
        from: 'node_modules/moment/src',
        to: 'public/plugins/moment'
    },

    // Select2
    {
        from: 'node_modules/select2/dist/',
        to: 'public/plugins/select2'
    },
    {
        from: 'node_modules/@ttskch/select2-bootstrap4-theme/dist/',
        to: 'public/plugins/select2-bootstrap4-theme'
    },
    // ClockPicker second
    {
        from: 'node_modules/clockpicker-seconds',
        to: 'public/plugins/clockpicker-seconds'
    },

    //highchart
    {
        from: 'node_modules/highcharts/',
        to: 'public/plugins/highcharts',
    }
]

export default Plugins
