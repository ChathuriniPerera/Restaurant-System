<?php ?>

<?php
//time zone set 
date_default_timezone_set("Asia/Colombo");

include '../header.php';
include '../nav.php';
?>

<?php
if (isset($_GET['order_id'])) {
    $Corder_id = $_GET['order_id'];
}

$sql = "UPDATE `tb_order` SET `status`= '7' WHERE `order_id`=$Corder_id";
$order = $conn->query($sql);
?>

<?php
$osql = "SELECT * FROM `tb_order` WHERE `order_id`=$Corder_id";
$oresult = $conn->query($osql);
$orow = $oresult->fetch_assoc();
?>

<div class="row">
    <h5><strong>Order Details</strong></h5>
</div>

<div class="row order-card">
    <div class="card" style="width: 22rem;">

        <img class="card-img-top" src="..." alt="">
        <div class="card-body">
            <div class="row"><h5 class="card-title"><strong>Reference Number : </strong><a class="card-text" value=""><?php echo date('Y') . date('m') . date('d') . $orow['order_id']; ?></a></h5></div>                                 
            <div class="card-body text-left"> 
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
            if ($order_status == 7) {
                ?>
                <p><h6 class="card-subtitle mb-2 text-muted">Order Status : Cancelled</h6></p>  <?php } ?>        
            <?php
            $sql = "SELECT * FROM `tb_order_item` i LEFT JOIN tb_menu m ON m.item_id=i.item_id WHERE i.order_id=$Corder_id";
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
<?php include '../footer.php'; ?>