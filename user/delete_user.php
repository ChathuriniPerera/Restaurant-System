<?php
ob_start();
?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
}

if (isset($_GET['status'])) {
    $status = $_GET['status'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == '0') {
    $user_id = $_POST['user_id'];
    $sql = "DELETE FROM tb_employee WHERE user_id='$user_id'";
    $conn->query($sql);
    header('Location:create_user.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == '1') {
    $user_id = $_POST['user_id'];
    $status = "UPDATE `tb_employee` SET `status`= '2' WHERE `user_id`='$user_id'";
    $conn->query($status);
    $conn->query("DELETE FROM `tb_user_module` WHERE `user_id`='$user_id'");   
    header('Location:create_user.php');
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && $_POST['operate'] == "cancel") {
    $user_id = $_POST['user_id'];
    header('Location:create_user.php');
}
?>

<div class="container h-100 text-center">
    <div class="row h-100 justify-content-center align-items-center">
        <div class="col-6">
            <div class="alert alert-danger alert-dismissible">
                <a href="view_employee.php" class="close"></a>
                <h4>Confirmation</h4>            
                <p>Do you want to <?php if($status==0){ echo "delete";} else {echo "band";}?> this user?</p>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <button type="submit" class="btn btn-warning" name="operate" value="<?php echo $status ?>" ><i class="fas fa-check"></i></button>                   
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