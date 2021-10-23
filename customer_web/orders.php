<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';

//cartstep1
session_start();
?>

<?php
if (isset($_SESSION['customer_id'])) {
    $customer_id = clean_data($_SESSION['customer_id']);
} else {
    header("Location:customerlogin.php");
}

if (!empty($customer_id)) {
    $sql = "SELECT * FROM `tb_customers` WHERE customer_id='$customer_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customer_id = $row['customer_id'];
            $contact_name = $row['first_name'] . " " . $row['last_name'];
            $phone_number = "+94" . $row['phone_number'];
            $email = $row['email'];
        }
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

        <title>Taste Of Ceylon Sri Lankan Foods-Contact</title>

        <!-- Custom styles for this template -->
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

    </head>

    <body>

        <!-- Navigation -->
        <?php
        include 'webnav.php';
        ?>

        <!-- Page Content -->

        <?php
        $sql = "SELECT * FROM `tb_order` WHERE `customer_id`= $customer_id";
        $result = $conn->query($sql);
        $result->num_rows;
        ?>

        <table class="table table-sm">
            <thead class="thead-light">
                <tr>
                    <th scope="col">Reference ID</th>                    
                    <th scope="col">Delivery Date</th>
                    <th scope="col">Delivery Time</th>
                    <th scope="col">Total</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                    <th scope="col"></th>
                </tr>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo date('Y') . date('m') . date('d') . $row['order_id']; ?></td>                         
                            <!--<td></td>-->
                            <td><?php echo $row['delivery_date']; ?></td>
                            <td><?php echo $row['time']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
                            <td>
                                <?php if ($row['status'] == 0) { ?>
                                    <span class="badge badge-secondary">Pending Confirmation</span>
                                <?php } elseif ($row['status'] == 1) { ?> 
                                    <span class="badge badge-primary">Confirmed</span>
                                <?php } elseif ($row['status'] == 2) { ?> 
                                    <span class="badge badge-info">Management Accepted</span>
                                <?php } elseif ($row['status'] == 3) { ?>
                                    <span class="badge badge-warning">Processing in Kitchen</span>
                                <?php } elseif ($row['status'] == 4) { ?>
                                    <span class="badge badge-info">Ready to Pick-up</span>
                                <?php } elseif ($row['status'] == 5) { ?>
                                    <span class="badge badge-warning">On Delivery</span>
                                <?php } elseif ($row['status'] == 6) { ?>
                                    <span class="badge badge-success">Completed</span>
                                <?php } elseif ($row['status'] == 7) { ?>
                                    <span class="badge badge-dark">Cancelled</span><?php } ?>
                            </td>
                            <td><a class="btn btn btn-outline-info" href="<?php echo SITE_URL; ?>customer_web/weborder_details.php?order_id=<?php echo $row['order_id']; ?>"><i class="fas fa-eye"></i></a></td>
                            <td>
                                <?php if ($row['status'] < 2) { ?>
                                    <a class="btn btn-outline-danger" href="<?php echo SITE_URL; ?>customer_web/cancel_orders.php?order_id=<?php echo $row['order_id']; ?>"><i class="fas fa-times"></i></a>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if ($row['status'] == 0) { ?>             
                                    <a class="btn btn-outline-success" href="<?php echo SITE_URL; ?>customer_web/order_reconfirmation.php?order_id=<?php echo $row['order_id']; ?>"><i class="fas fa-envelope-open-text"></i></a>
                                <?php } ?>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>

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