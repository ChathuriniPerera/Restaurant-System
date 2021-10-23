<?php
ob_start();
//time zone set 
date_default_timezone_set("Asia/Colombo");

include '../header.php';
include '../nav.php';
?>

<?php
$delivery = $order_id = null;
$e = array();
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {
    $delivery = clean_data($_POST['delivery']);
    $order_id = clean_data($_POST['order_id']);
    $status = clean_data($_POST['status']);

    if ($delivery == "no") {
        $e['delivery'] = "Must select Delivery Person ";
    }

    if (empty($e)) {
        $sql = "UPDATE `tb_order` SET `status`=2, `delivery_person`='$delivery' WHERE `order_id`=$order_id";
        $order = $conn->query($sql);
        header('LOCATION:accepted_order.php?order_id=' . $order_id);
    }
}
?>



<?php
if (isset($_GET['order_id'])) {
    $order_id = clean_data($_GET['order_id']);
    $status = clean_data($_GET['status']);
}

$osql = "SELECT * FROM `tb_order` WHERE `order_id`=$order_id";
$oresult = $conn->query($osql);
$orow = $oresult->fetch_assoc();
$delivery_date = $orow['delivery_date'];
$today = date('Y-m-d');
?>
<?php if ((@$status == 0) && ($delivery_date == $today)) { ?>
    <a type="button" name="operate" value="expire" class = "btn btn-primary order-notify" href="<?php echo SITE_URL; ?>manage_orders/expire_orders.php?order_id=<?php echo $orow['order_id']; ?>"><i class="fas fa-ban"></i></a>
<?php } ?>


<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST"
      enctype="multipart/form-data">
          <?php if ($status == 1) { ?>
        <input type="hidden" name="order_id" value="<?php echo $orow['order_id']; ?>">
        <input type="hidden" name="status" value="<?php echo $orow['status']; ?>">
        <button type="submit" name="operate" value="save" class="btn btn-primary order-notify"><i class = "fas fa-concierge-bell"></i></button>
    <?php } ?>
    <div class="row order-card">
        <div class="card" style="width: 22rem;">
            <div class="card-header">
                <h5><strong>Order Details</strong></h5>
            </div>
            <div class="card-body">

                <div class="row"><h5 class="card-title"><strong>Reference Number : </strong><a class="card-text" value=""><?php echo date('Y') . date('m') . date('d') . $orow['order_id']; ?></a></h5></div>                                 

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
                <div class="form-group col">
                    <label for="delivery">Set Delivery Person : </label>
                    <select class="form-control" name="delivery">
                        <option value="no">Choose...</option>
                        <?php
                        $sql_D = "SELECT * FROM `tb_employee` WHERE user_type='Dilivery person' AND status!=2";
                        $result_D = $conn->query($sql_D);
                        if ($result_D->num_rows > 0) {
                            while ($row_D = $result_D->fetch_assoc()) {
                                ?><option value="<?php echo $row_D['user_id']; ?>" <?php if ($orow['delivery_person'] == $row_D['user_id']) { ?> selected <?php } ?>><?php echo $row_D['full_name']; ?></option> 
                                <?php
                            }
                        }
                        ?>          
                    </select>
                    <div class="text-danger"><?php echo @$e['delivery']; ?></div>
                </div>

            </div>
        </div>

        <div class="card" style="width: 47rem;">
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
                        <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 10%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 1) { ?> 
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Customer Confirmed</h6></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped badge-confirm" role="progressbar" style="width: 25%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 2) { ?>
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Manager Accept</h6></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-danger" role="progressbar" style="width: 40%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 3) { ?>
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Processing in Kitchen</h6></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-warning" role="progressbar" style="width: 55%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 4) { ?>
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Ready to Pick-up</h6></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped badge-badge" role="progressbar" style="width: 70%" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 5) { ?>
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : On Delivery</h6></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width: 85%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 6) { ?>
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Completed</h6></p>
                    <div class="progress">
                        <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 100%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                <?php } elseif ($order_status == 7) { ?>
                    <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Cancelled</h6></p>
                <?php } ?>         

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
</form>


<?php
include '../footer.php';
ob_end_flush();
?>
