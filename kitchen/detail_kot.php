<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

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


<?php
$sql_kot = "SELECT * FROM `tb_order` WHERE `status` = 3";
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
                <a href="<?php echo SITE_URL; ?>kitchen/detail_kot_update.php?order_id=<?php echo $row_kot['order_id']; ?> && status=<?php echo $row_kot['status']; ?>" class="btn btn-primary col">Order Process Complete</a>
            </div>
            <a href=""></a>
        </div>
        <?php
    }
}
?>

<?php include '../footer.php'; ?>
