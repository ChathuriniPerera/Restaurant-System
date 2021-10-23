<?php
ob_start();
?>

<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';
?>
<html>
    <head>
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>
        <!-- Custom fonts for this template-->
        <link href="<?php echo SITE_URL; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="<?php echo SITE_URL; ?>/css/sb-admin-2.min.css" rel="stylesheet">
    </head>
</html>
<?php
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == 'confirm') {
    $order_id = $_POST['order_id'];

    $sql = "UPDATE `tb_order` SET `status`=7 WHERE `order_id`=$order_id";
    $order = $conn->query($sql);
    header('Location:http://localhost/tocadmin/customer_web/orders.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "cancel") {
    $order_id = $_POST['order_id'];
    header('Location:http://localhost/tocadmin/customer_web/orders.php');
}
?>

<div class="container h-100 text-center">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">
            <div class="alert alert-danger alert-dismissible">
                <a href="customer_web/orders.php.php" class="close"></a>
                <h4>Confirmation</h4>            
                <p>Do you want to Cancel this Order</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                    <button type="submit" class="btn btn-warning" name="operate" value="confirm" ><i class="fas fa-check"></i></button>                   
                    <button type="submit" class="btn btn-info" name="operate" value="cancel"><i class="fas fa-times"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>