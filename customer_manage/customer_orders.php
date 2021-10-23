<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
if (isset($_GET['customer_id'])) {
    $customer_id = clean_data($_GET['customer_id']);
}

$sql_kot = "SELECT * FROM `tb_order` WHERE `customer_id` = '$customer_id'";
$result_kot = $conn->query($sql_kot);
if ($result_kot->num_rows > 0) {
    while ($row_kot = $result_kot->fetch_assoc()) {
        $order_id = $row_kot['order_id']
        ?>
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title">Reference Number : <?php echo date('Y') . date('m') . date('d') . $row_kot['order_id']; ?></h5>
                <div class="row">
                    <div class="card col-md-4">
                        <div class="card-body">
                            <strong>                                                
                                <div class="row">
                                    <h6 class="card-title">Customer Name : </h6>
                                    <p class="card-text ord-st-frm" value=""><?php echo $row_kot['contact_name']; ?></p>
                                </div>
                                <div class="row">
                                    <h6 class="card-title">Phone Number : </h6>
                                    <p class="card-text ord-st-frm" value=""><?php echo $row_kot['phone_number'] ?></p>
                                </div>
                                <div class="row">
                                    <h6 class="card-title">Email : </h6>
                                    <p class="card-text ord-st-frm" value=""><?php echo $row_kot['email']; ?></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <h6 class="card-title">Delivery Address : </h6>
                                    <div class="card-text ord-st-frm" value=""><?php echo $row_kot['house_number']; ?> <?php echo $row_kot['street_address']; ?> <?php echo $row_kot['city_name']; ?></div>
                                </div>
                                <div class="row">
                                    <h6 class="card-title">Pay Method : </h6>
                                    <p class="card-text ord-st-frm"><?php echo $row_kot['pay_method']; ?></p>
                                </div>
                                <hr>
                                <div class="row">
                                    <h6 class="card-title">Total Amount : </h6>
                                    <p class="card-text ord-st-frm"><?php echo $row_kot['total_price']; ?></p>
                                </div>
                            </strong> 
                            <hr>
                            <strong>
                                <div class="row">
                                    <?php
                                    $sql_Dpn = "SELECT * FROM `tb_order` o LEFT JOIN tb_employee e ON o.delivery_person = e.user_id WHERE o.order_id = $order_id";
                                    $result_Dpn = $conn->query($sql_Dpn);
                                    $row_Dpn = $result_Dpn->fetch_assoc();
                                    ?>
                                    <h6 class="card-title">Deliver By : </h6>
                                    <p class="card-text ord-st-frm"><?php echo $row_Dpn['title'] . " " . $row_Dpn['full_name']; ?></p>
                                </div> 
                            </strong>
                        </div>
                    </div>
                    <div class="card col-md-8">
                        <div class="row">
                            <h6>Order ID :</h6>
                            <div class="card-text card-text-left" value=""><h6><?php echo $row_kot['order_id']; ?></h6></div>
                        </div>
                        <div class="row">
                            <h6>Delivery Date :</h6>
                            <div class="card-text card-text-right" value=""><h6><?php echo $row_kot['delivery_date']; ?></h6></div>
                        </div>
                        <div class="row">
                            <h6>Time :</h6>
                            <div class="card-text" value=""><h6><?php echo $row_kot['time']; ?></h6></div>
                        </div>

                        <?php
                        $order_status = $row_kot['status'];
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
                        $order_id = $row_kot['order_id'];
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
            <a href=""></a>
        </div>
        <?php
    }
}
?>

<?php include '../footer.php'; ?>