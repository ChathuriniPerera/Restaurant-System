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
$sql = "SELECT * FROM `tb_order`";
$result = $conn->query($sql);
$result->num_rows;
?>

<table class="table">
    <thead class="thead-light">
        <tr>
            <th scope="col">Order ID</th>
            <th scope="col">Customer</th>
            <th scope="col">Created</th>
            <th scope="col">Delivery Date</th>
            <th scope="col">Delivery Time</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
            <th></th>
        </tr>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['order_id']; ?></td>
                    <td><?php echo $row['contact_name'] ?></td>
                    <td><?php echo $row['created']; ?></td>
                    <td><?php echo $row['delivery_date']; ?></td>
                    <td><?php echo $row['time']; ?></td>
                    <td><?php echo $row['total_price']; ?></td>
                    <td>
                        <?php if ($row['status'] == 0) { ?>
                            <span class="badge badge-secondary">Pending Confirmation</span>
                        <?php } elseif ($row['status'] == 1) { ?> 
                            <span class="badge badge-confirm">Confirmed</span>
                        <?php } elseif ($row['status'] == 2) { ?> 
                            <span class="badge badge-danger">Management Accepted</span>
                        <?php } elseif ($row['status'] == 3) { ?>
                            <span class="badge badge-warning">Processing in Kitchen</span>
                        <?php } elseif ($row['status'] == 4) { ?>
                            <span class="badge badge-badge">Ready to Pick-up</span>
                        <?php } elseif ($row['status'] == 5) { ?>
                            <span class="badge badge-info">On Delivery</span>
                        <?php } elseif ($row['status'] == 6) { ?>
                            <span class="badge badge-success">Completed</span>
                        <?php } elseif ($row['status'] == 7) { ?>
                            <span class="badge badge-cancel">Cancelled</span><?php } ?>
                    </td>
                    <td><a class="btn btn-primary" href="<?php echo SITE_URL; ?>manage_orders/order_details.php?order_id=<?php echo $row['order_id']; ?> && status=<?php echo $row['status']; ?>"><i class="fas fa-eye"></i></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php include '../footer.php'; ?>