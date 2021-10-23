<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
if (isset($_GET['date_id'])) {
    $date_id = $_GET['date_id'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == 'delete') {
    $date_id = $_POST['date'];
    $sql = "DELETE FROM `tb_holiday` WHERE `id`='$date_id'";
    $conn->query($sql);
    header('Location:add_holidays.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "cancel") {
    $day_id = $_POST['day'];
    header('Location:add_holidays.php');
}
?>

<div class="container h-100 text-center">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">
            <div class="alert alert-danger alert-dismissible">
                <h4>Confirmation</h4>            
                <p>Do you want to Delete this Date Details?</p>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="date" value="<?php echo $date_id; ?>">
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