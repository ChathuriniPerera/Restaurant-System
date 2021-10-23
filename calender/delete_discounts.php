<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
if (isset($_GET['month_id'])) {
    $month_id = $_GET['month_id'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == 'delete') {
    $month_id = $_POST['month'];
    $sql = "DELETE FROM `tb_discount` WHERE `id` = '$month_id'";
    $conn->query($sql);
    header('Location:edit_discounts.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "cancel") {
    $day_id = $_POST['day'];
    header('Location:edit_discounts.php');
}
?>

<div class="container h-100 text-center">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">
            <div class="alert alert-danger alert-dismissible">
                <h4>Confirmation</h4>            
                <p>Do you want to Delete this Month Discount?</p>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="month" value="<?php echo $month_id; ?>">
                    <button type="submit" class="btn btn-warning" name="operate" value="delete" ><i class="fas fa-check"></i></button>                   
                    <button type="submit" class="btn btn-info" name="operate" value="cancel"><i class="fas fa-times"></i></button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>

<?php
ob_end_flush();
?>