<?php
//time zone set 
date_default_timezone_set("Asia/Colombo");

//Include Database Connection
include '../conn.php';

//Include helper Connection
include '../helper.php';

//Include config Connection
include '../config.php';
?>

<?php
if (isset($_GET['order_id']) && $_SERVER['REQUEST_METHOD'] == "GET") {
    $new_order = $_GET['order_id'];
    $sql = "SELECT * FROM `tb_order` WHERE sha1(order_id) = '$new_order'";
//    print_r($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $new_order = $row['order_id'];
            $contact_name = $row['contact_name'];
            $phone_number = $row['phone_number'];
            $email = $row['email'];
            $delivery_date = $row['delivery_date'];
            $time = $row['time'];
            $pay_method = $row['pay_method'];
            $total_price = $row['total_price'];
            $discount = $row['discount'];
            $net_price = $row['net_total'];
        }
        $items = "SELECT order_id, COUNT(`order_id`) AS ordercount FROM tb_order_item WHERE order_id = $new_order GROUP BY order_id";
        $itm = $conn->query($items);

        $sql = "UPDATE `tb_order` SET `status`=1 WHERE `order_id`=$new_order";
        $order = $conn->query($sql);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon Sri Lankan Foods-Services</title>

        <!-- Bootstrap core CSS -->
        <link href="../web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

        <!--Google Fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;500&display=swap" rel="stylesheet">

    </head>

    <body>

        <!-- Navigation -->
        <?php
        include 'webnav.php';
        ?>

        <!-- Page Content -->
        <div >
            <?php
            $order = "SELECT * FROM `tb_order`";
            $result = $conn->query($order);
            $row = $result->fetch_assoc();
            ?>
            <img src="../img/mixed-grill.jpg" alt="" class="set_success"/>
            <span class="top-middle">Your Order Confirmed</span>
            <img src="../img/ole.png" alt="" class="image-2"/>
            <div class="card order" style="width: 25rem;">
                <div class="card-body">
                    <h5 class="card-title">Order Details</h5>
                    <div class="col row">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Reference ID :  </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo date('Y') . date('m') . date('d') . $new_order; ?></div>
                    </div>
                    <div class="col row">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Order Date :    </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo " " . $delivery_date; ?></div>
                    </div>
                    <div class="col row">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Subtotal :  Rs.</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($total_price, 2); ?></div>
                    </div>
                    <div class="col row">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Discount :  Rs.</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($discount, 2); ?></div>
                    </div>
                    <div class="col row">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Payable Amount :  Rs.</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo number_format($net_price, 2); ?></div>
                    </div>
                    <div class="col row">
                        <div class="text-xs font-weight-bold text-dark text-uppercase mb-1">Order Place Time :  </div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $time; ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- /.container -->

        <!-- Footer -->
        <footer class="bg-dark">
            <?php
            include 'webfooter.php';
            ?>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>