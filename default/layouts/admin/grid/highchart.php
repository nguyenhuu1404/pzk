<?php
$data = array('thang1'=>20, 'thang2'=>10, 'thang3'=>40, 'thang4'=>5, 'thang5'=>15, 'thang6'=>8, 'thang7'=>2);
$dataJson = json_encode($data);

?>
<style type="text/css">
    #container, #sliders {
        min-width: 310px;
        max-width: 800px;
        margin: 0 auto;
    }
    #container {
        height: 400px;
    }
</style>
<script type="text/javascript">
    $(function () {
        // Set up the chart
        var chart = new Highcharts.Chart({
            chart: {
                renderTo: 'container',
                type: 'column',
                margin: 75,
                options3d: {
                    enabled: true,
                    alpha: 15,
                    beta: 15,
                    depth: 50,
                    viewDistance: 25
                }
            },
            title: {
                text: 'Chart rotation demo'
            },
            subtitle: {
                text: 'Test options by dragging the sliders below'
            },
            plotOptions: {
                column: {
                    depth: 25
                }
            },
            xAxis: {
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
            },
            series: [{
                "name": "WordPress",
                "data": [4, 5, 6, 2, 5, 7, 2, 1, 6, 7, 3, 4]
            }, {
                "name": "CodeIgniter",
                "data": [5, 2, 3, 6, 7, 1, 2, 6, 6, 4, 6, 3]
            }, {
                "name": "Highcharts",
                "data": [7, 8, 9, 6, 7, 10, 9, 107, 6, 9, 8, 4]
            }]
        });

        function showValues() {
            $('#R0-value').html(chart.options.chart.options3d.alpha);
            $('#R1-value').html(chart.options.chart.options3d.beta);
        }

        // Activate the sliders
        $('#R0').on('change', function () {
            chart.options.chart.options3d.alpha = this.value;
            showValues();
            chart.redraw(false);
        });
        $('#R1').on('change', function () {
            chart.options.chart.options3d.beta = this.value;
            showValues();
            chart.redraw(false);
        });

        showValues();
    });
</script>


<div id="container"></div>