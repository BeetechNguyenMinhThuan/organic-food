<script type="text/javascript">

    function initStatisticUser() {
        let userData = {!! json_encode($users) !!}
        Highcharts.chart('statistics-user', {

            title: {
                text: 'Thống kê số lượng người dùng mới',
                align: 'left'
            },


            yAxis: {
                title: {
                    text: 'Số lượng người dùng'
                }
            },

            xAxis: {
                categories: Object.keys(userData)
            },

            legend: {
                layout: 'vertical',
                align: 'right',
                verticalAlign: 'middle'
            },

            series: [{
                name: 'Người dùng',
                data: Object.values(userData)
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

    function initUserAgent() {
        let activityUser = {!! json_encode($activityUsers) !!};
        const browsers = activityUser.map(d => d.browser);
        const counts = activityUser.map(d => d.count);

        let options = {
            chart: {
                type: 'donut'
            },
            plotOptions: {
                pie: {
                    customScale: 0.8,
                    expandOnClick: false
                }
            },
            series: counts,
            labels: browsers
        }

        let chart = new ApexCharts(document.querySelector("#pieChartUserAgent"), options);
        chart.render();
    }


    $(function () {
        initStatisticUser()
        initUserAgent();
    })

</script>
