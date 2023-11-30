<script type="text/javascript">
    $(function () {
        let userData = {!! json_encode($users) !!}
        Highcharts.chart('statistics-user', {

            title: {
                text: 'Thống kê số lượng người dùng mới',
                align: 'left'
            },


            yAxis: {
                title: {
                    text: 'Number of Users'
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
                name:'Người dùng',
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

    })

</script>
