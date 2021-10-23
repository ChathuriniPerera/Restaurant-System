<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';
?>


<?php
if (isset($_GET['order_id'])) {
    $order_id = clean_data($_GET['order_id']);
}
?>

<?php
$osql = "SELECT * FROM `tb_order` WHERE `order_id`=$order_id";
$oresult = $conn->query($osql);
$orow = $oresult->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon Sri Lankan Foods-Contact</title>

        <!-- Bootstrap core CSS -->
        <link href="../web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template -->
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

    </head>

    <body>

        <!-- Navigation -->
        <?php
        include 'webnav.php';
        ?>

        <a type="button" href="orders.php" class="btn btn-outline-danger order-card"><i class="far fa-hand-point-left"></i> Back</a>
        <h5 class="text-center">Order Details</h5>


        <div class="row col-12 order-card">
            <div class="card"  style="width: 25rem;">
                <div class="card-body">
                    <div class="row"><h5 class="card-title"><strong>Reference Number : </strong><a class="card-text" value=""><?php echo date('Y') . date('m') . date('d') . $orow['order_id']; ?></a></h5></div>                                 
                    <div class="card-body"> 
                        <strong>                                                
                            <div class="row">
                                <h6 class="card-title">Customer Name : </h6>
                                <p class="card-text ord-st-frm" value=""><?php echo $orow['contact_name']; ?></p>
                            </div>
                            <div class="row">
                                <h6 class="card-title">Phone Number : </h6>
                                <p class="card-text ord-st-frm" value=""><?php echo $orow['phone_number'] ?></p>
                            </div>
                            <div class="row">
                                <h6 class="card-title">Email : </h6>
                                <p class="card-text ord-st-frm" value=""><?php echo $orow['email']; ?></p>
                            </div>
                            <hr>
                            <div class="row">
                                <h6 class="card-title">Delivery Address : </h6>
                                <div class="card-text ord-st-frm" value=""><?php echo $orow['house_number']; ?> <?php echo $orow['street_address']; ?> <?php echo $orow['city_name']; ?></div>
                            </div>
                            <div class="row">
                                <h6 class="card-title">Pay Method : </h6>
                                <p class="card-text ord-st-frm"><?php echo $orow['pay_method']; ?></p>
                            </div>
                            <hr>
                            <div class="row">
                                <h6 class="card-title">Total Amount : </h6>
                                <p class="card-text ord-st-frm"><?php echo $orow['total_price']; ?></p>
                            </div>
                        </strong>
                    </div>                       
                </div>
            </div>

            <div class="card"  style="width: 55rem;">
                <div class="card-body">
                    <div class="row">
                        <h6>Order ID :</h6>
                        <div class="card-text" value=""><h6><?php echo $orow['order_id']; ?></h6></div>
                    </div>
                    <div class="row">
                        <h6>Delivery Date :</h6>
                        <div class="card-text" value=""><h6><?php echo $orow['delivery_date']; ?></h6></div>
                    </div>
                    <div class="row">
                        <h6>Time :</h6>
                        <div class="card-text" value=""><h6><?php echo $orow['time']; ?></h6></div>
                    </div>

                    <?php
                    $order_status = $orow['status'];
                    if ($order_status == 0) {
                        ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Pending Confirmation</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 1) { ?> 
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status :Confirmed</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 25%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 2) { ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Management Accepted</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 3) { ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Processing in Kitchen</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped badge-badge" role="progressbar" style="width: 55%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 4) { ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Ready to Pick-up</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 70%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 5) { ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : On Delivery</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 85%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 6) { ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Completed</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    <?php } elseif ($order_status == 7) {
                        ?>
                        <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Cancelled</h6></p>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped " role="progressbar"  aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                        </div><?php } ?> 

                    <?php
                    $sql = "SELECT * FROM `tb_order_item` i LEFT JOIN tb_menu m ON m.item_id=i.item_id WHERE i.order_id=$order_id";
                    $result = $conn->query($sql);
                    $result->num_rows;
                    ?>

                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Item Image</th>
                                <th>Item Name</th>
                                <th>Quantity</th>
                                <th>Unit Price</th>
                                <th>Items Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><img src="<?php echo SITE_URL; ?>img/<?php echo $row['item_image']; ?>" class="img-fluid"
                                                 style="width:50px"></td>
                                        <td><?php echo $row['item_name']; ?></td>
                                        <td><?php echo $row['quantity']; ?></td>
                                        <td><?php echo $row['unit_price']; ?></td>
                                        <td><?php echo $row['item_total']; ?></td>
                                        <?php
                                    }
                                }
                                ?>
                            </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
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