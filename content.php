<div class="container">
    <div class="row">
        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 1";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Orders Received</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>                          
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-pizza-slice fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 2";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Orders Accepted</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-clipboard-check fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 3";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Orders Processing</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-utensils fa-2x text-gray-300"></i>                     
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 4";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Ready to Delivery</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-shopping-basket fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 5";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Orders On Delivery</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-2 col-md-4 mb-2">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <?php
                            $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 6";
                            $result = $conn->query($sql);
                            $row = $result->fetch_assoc();
                            ?>
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Order Complete</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-check-double fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <div class="row">
        <?php
        $dsql = "SELECT * FROM `tb_employee` WHERE `user_type` = 'Dilivery Person'";
        $dresult = $conn->query($dsql);
        if ($dresult->num_rows > 0) {
            while ($drow = $dresult->fetch_assoc()) {
                $deliver_id = $drow['user_id'];
                ?><?php
                $ownsql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `delivery_person` = '$deliver_id'";
                $ownresult = $conn->query($ownsql);
                if ($ownresult->num_rows > 0) {
                    while ($ownrow = $ownresult->fetch_assoc()) {
                        ?>

                        <div class="card">
                            <div class="card border-left-success shadow h-50 py-2" style="max-width: 25rem;">
                                <div class="card-body">
                                    <h5 class="card-title">Deliver by :<?php echo $drow['full_name']; ?></h5>
                                    <h5 class="card-title">Orders Delivered :<?php echo $ownrow['NumberofOrdrs']; ?></h5>
                                </div>
                            </div>
                        </div>

                        <?php
                    }
                }
                ?><?php
            }
        }
        ?>

    </div>
    <div class="col-xl-4 col-md-8 mb-4">
        <div class="card border-left-dark shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <?php
                        $sql = "SELECT COUNT(order_id) AS NumberofOrdrs FROM `tb_order` WHERE `status` = 7";
                        $result = $conn->query($sql);
                        $row = $result->fetch_assoc();
                        ?>
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Cancel Orders</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $row['NumberofOrdrs']; ?></div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-check-double fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <!-- /.row -->
</div><!-- /.container-fluid -->

<?php
$sql = "SELECT SUM(quantity) AS qty, category FROM `tb_order_item` LEFT JOIN tb_menu ON tb_order_item.item_id = tb_menu.item_id LEFT JOIN tb_menu_category ON tb_menu.category_id = tb_menu_category.category_id GROUP BY category";
$r = $conn->query($sql);
$lable = array();
$data1 = array();
while ($row = $r->fetch_assoc()) {
    $lable[] = $row['category'];
    $data1[] = $row['qty'];
}
?>
<script>
    $(function () {


        var ChartData = {
            labels: [
<?php echo "'" . implode("','", $lable) . "'"; ?>

            ],
            datasets: [
                {
                    label: 'Quantity',
                    backgroundColor: 'rgba(60,141,188,0.9)',
                    borderColor: 'rgba(60,141,188,0.8)',
                    pointRadius: false,
                    pointColor: '#3b8bba',
                    pointStrokeColor: 'rgba(60,141,188,1)',
                    pointHighlightFill: '#fff',
                    pointHighlightStroke: 'rgba(60,141,188,1)',
                    data: [
<?php
echo implode(',', $data1);
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
                        display: true,
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            callback: function (label, index, labels) {
                                if (/\s/.test(label)) {
                                    return label.split(" ");
                                } else {
                                    return label;
                                }
                            }
                        }
                    }],
                yAxes: [{
                        gridLines: {
                            display: false,
                        },
                        ticks: {
                            beginAtZero: true
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