<?php include 'config.php'; ?>
<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Chart</title>


    </head>
    <body class="hold-transition sidebar-mini">
        <div class="container">


            <div class="row">

                <div class="col-md-6">


                    <!-- BAR CHART -->

                    <div class="chart">
                        <canvas id="barChart" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                    </div>




                </div>
                <!-- /.col (RIGHT) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->

        <!-- Bootstrap core JavaScript-->
        <script src="<?php echo SITE_URL; ?>/vendor/jquery/jquery.min.js"></script>
        <script src="<?php echo SITE_URL; ?>/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?php echo SITE_URL; ?>/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="<?php echo SITE_URL; ?>/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="<?php echo SITE_URL; ?>/vendor/chart.js/Chart.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="<?php echo SITE_URL; ?>/js/demo/chart-area-demo.js"></script>
        <script src="<?php echo SITE_URL; ?>/js/demo/chart-pie-demo.js"></script>
        <?php
        
        
        $sql = "select * from tb_data";
        $r = $conn->query($sql);
        $lable = array();
        $data1 = array();
        $data2 = array();
        while ($row = $r->fetch_assoc()) {
            $lable[] = $row['year'];
            $data1[] = $row['Food 1'];
            $data2[] = $row['Food 2'];
        }
        
        ?>
        <script>
            $(function () {


                var ChartData = {
                    labels: [
                        <?php
                        echo implode(',', $lable)?>
                    ],
                    datasets: [
                        {
                            label: 'Food1',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [
                                <?php
                                echo implode(',',$data1);
                                ?>
                            ]
                        },
                        {
                            label: 'Food2',
                            backgroundColor: 'rgba(60,141,188,0.9)',
                            borderColor: 'rgba(60,141,188,0.8)',
                            pointRadius: false,
                            pointColor: '#3b8bba',
                            pointStrokeColor: 'rgba(60,141,188,1)',
                            pointHighlightFill: '#fff',
                            pointHighlightStroke: 'rgba(60,141,188,1)',
                            data: [
                                <?php
                                echo implode(',',$data2);
                                ?>
                            ]
                        },
                    ]
                }

                var barChartCanvas = $('#barChart').get(0).getContext('2d')
                var barChartData = $.extend(true, {}, ChartData)


                var barChartOptions = {
                    responsive: true,
                    maintainAspectRatio: false,
                    datasetFill: false,
                    legend: {
                        display: true
                    },
                    scales: {
                        xAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }],
                        yAxes: [{
                                gridLines: {
                                    display: false,
                                }
                            }]
                    }

                }

                var barChart = new Chart(barChartCanvas, {
                    type: 'bar',
                    data: barChartData,
                    options: barChartOptions
                })



            })
        </script>

