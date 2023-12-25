<script type="text/javascript">
    function initOrderAmount() {
        let orderData = {!! json_encode($orders) !!}
            console.log( Object.values(orderData))
        Highcharts.chart('statistics-orders', {

            title: {
                text: 'Thống kê số đơn hàng theo từng tháng',
                align: 'left'
            },


            yAxis: {
                title: {
                    text: 'Số đơn hàng'
                }
            },

            xAxis: {
                categories: Object.keys(orderData)
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Đơn hàng',
                data: Object.values(orderData)
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    }

    function initOrderRevenue() {
        let orderDataRevenue = {!! json_encode($ordersRevenue) !!};

        let allDayInMonth = {!! json_encode($allDaysInMonth) !!};
        console.log(Object.values(orderDataRevenue))
        Highcharts.chart('statistics-orders-revenue', {

            title: {
                text: 'Thống kê doanh thu từng ngày trong tháng',
                align: 'left'
            },

            tooltip: {
                pointFormat: '&#8226; Số tiền: <b>{point.y} VNĐ</b>'
            },
            yAxis: {
                title: {
                    text: 'Doanh thu'
                }
            },

            xAxis: {
                categories: Object.keys(orderDataRevenue)
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Doanh thu',
                data:Object.values(orderDataRevenue)
            }],

            responsive: {
                rules: [{
                    condition: {
                        maxWidth: 500
                    },
                    chartOptions: {
                        legend: {
                            layout: 'horizontal',
                            align: 'center',
                            verticalAlign: 'bottom'
                        }
                    }
                }]
            }

        });
    }

    $(function () {
        initOrderAmount();
        initOrderRevenue()

    })

</script>
