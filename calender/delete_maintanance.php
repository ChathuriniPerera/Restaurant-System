<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
if (isset($_GET['rapair_id'])) {
    $rapair_id = $_GET['rapair_id'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == 'delete') {
    $rapair_id = $_POST['rapair_id'];
    $sql = "DELETE FROM `tb_maintanance` WHERE `id`='$rapair_id'";
    $conn->query($sql);
    header('Location:add_maintananceday.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "cancel") {
    $rapair_id = $_POST['rapair_id'];
    header('Location:add_maintananceday.php');
}
?>

<div class="container h-100 text-center">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">
            <div class="alert alert-danger alert-dismissible">
                <h4>Confirmation</h4>            
                <p>Do you want to Delete Maintenance Details?</p>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="rapair_id" value="<?php echo $rapair_id; ?>">
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