<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$module_id = $module_name = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {

    $module_id = clean_data($_POST['module_id']);
    $module_name = clean_data($_POST['module_name']);

    if (empty($module_name)) {
        $e['module_name'] = "Module Name Should not be Empty...!";
    }

    //Submit Data Into Table module Database
    if (empty($e)) {
        $sql = "INSERT INTO `tb_module`(`module_id`, `description`, `module`, `view`, `menu_index`, `menu_icon`) VALUES ('$module_id','$module_name','','','$module_id','')";
        $result = $conn->query($sql);
        if ($result === TRUE) {
            echo "Data Insert";
            $module_name = null;
        } else {
            echo "Data Insert Failed" . $conn->error;
        }
    }
}
?>

<div class="row">
    <div class="col-sm-6">
        <div class="card">
            <div class="card-header">Main Module</div>
            <div class="card-body">
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                      enctype="multipart/form-data">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <?php
                            $module_id = "SELECT MAX(`module_id`) FROM `tb_module` WHERE LENGTH(`module_id`)=2";
                            $result_id = $conn->query($module_id);
                            $row = $result_id->fetch_assoc();
                            $max_id = (int) $row['MAX(`module_id`)'] + 1;
                            if ($max_id < 10) {
                                $new_id = "0" . $max_id;
                            } else {
                                $new_id = $max_id;
                            }
                            ?>
                            <label for="validationTooltip01">Module ID</label>
                            <input type="text" class="form-control" id=""  name="module_id" value="<?php echo $new_id; ?>" readonly>                         
                        </div>
                        <div class="col-md-7 mb-3">
                            <label for="validationTooltip01">Module Name</label>
                            <input type="text" class="form-control" id="module_name" name="module_name" value="<?php echo "$module_name"; ?>" placeholder="Module Name" >
                            <div class="text-danger"><?php echo @$e['module_name']; ?></div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit" name="operate" value="save">Create Module</button>
                </form>
            </div>
        </div>
    </div>  
</div>

<?php include '../footer.php'; ?>