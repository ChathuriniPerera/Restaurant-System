<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$user_name = $sub_module = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operator'] == "save") {

    $user_name = clean_data($_POST['user_name']);


//Assign sub_module
    if (isset($_POST['sub_module'])) {
        $sub_module = $_POST['sub_module'];
    }

//empty validation
    if (empty($user_name)) {
        $e['user_name'] = "User Name sholud not be empty";
    }
    if (empty($sub_module)) {
        $e['sub_module'] = "Please Set Modules";
    }

    if (empty($e)) {
        for ($x = 0; $x < count($sub_module); $x++) {
            $msg2 = $result3 = null;
                    
            $s = substr($sub_module[$x], 0, 2);

            $module = "SELECT * FROM `tb_user_module` WHERE `user_id`='$user_name' AND `module_id`='$sub_module[$x]'";
            $result = $conn->query($module);
            if ($result->num_rows == 0) {
                $submodule_insert = "INSERT INTO `tb_user_module`(`user_id`, `module_id`) VALUES ('$user_name','$sub_module[$x]')";
                $result3 = $conn->query($submodule_insert);
                $status = "UPDATE `tb_employee` SET `status`= '1' WHERE `user_id`='$user_name'";
                $conn->query($status);
                
            }else{
                $msg2=1;
            }

            $module_insert = "SELECT * FROM `tb_user_module` WHERE `user_id` = '$user_name' AND `module_id` = '$s'";
            $result2 = $conn->query($module_insert);
            if ($result2->num_rows == 0) {
                $Mmodule_insert = "INSERT INTO `tb_user_module`(`user_id`, `module_id`) VALUES ('$user_name','$s')";
                $conn->query($Mmodule_insert);
            }
        }

        if ($result3===TRUE) {
            ?>
            <div class="alert alert-success" role="alert">
                <p>Data Insert Success</p>
            </div><?php } 
            
        if ($msg2==1){
        ?>
        <div class = "alert alert-warning" role = "alert">
            <p>Data Already Assign</p>
        </div>
        <?php }
    }
}
?>

<div class="form-row">
    <div class="card col-sm-12">
        <div class="card-header">
                Assign Menus
            </div>
        <div class="card-body">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                  enctype="multipart/form-data">
                <div class="form-row">
                    <div class="col-md-6 mb-3">
                        <label for="inputState">User Name</label>
                        <select id="inputState" class="form-control" name="user_name">
                            <option selected>Choose...</option>
                            <?php
                            $sql_sub = "SELECT * FROM `tb_employee`";
                            $result_sub = $conn->query($sql_sub);
                            if ($result_sub->num_rows > 0) {
                                while ($row_sub = $result_sub->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row_sub['user_id'] ?>"><?php echo $row_sub['full_name'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <?php
                        $sql_main = "SELECT * FROM `tb_module` WHERE LENGTH(`module_id`)=2";
                        $result_main = $conn->query($sql_main);
                        if ($result_main->num_rows > 0) {
                            while ($row_main = $result_main->fetch_assoc()) {
                                ?>
                                <label for="inputState"><?php echo $row_main['description'] ?>
                                    <div>
                                        <?php
                                        $sql_sub = "SELECT * FROM `tb_module` WHERE LENGTH(`module_id`)=4 AND SUBSTR(`module_id`,1,2) = '" . $row_main['module_id'] . "'";
                                        $result_sub = $conn->query($sql_sub);
                                        if ($result_sub->num_rows > 0) {
                                            while ($row_sub = $result_sub->fetch_assoc()) {
                                                ?>
                                                <input type="checkbox" value="<?php echo $row_sub['module_id'] ?>" name="sub_module[]"><?php echo $row_sub['description'] ?>
                                                <?php
                                            }
                                        }                    
                                        ?>                                              
                                    </div>
                                </label>
                                <?php
                                echo '</br>';
                            }
                        }
                        ?>
                        </select>
                    </div>
                </div>
                <button class="btn btn-primary" type="submit" value="save" name="operator">Submit</button>
            </form>
        </div>
    </div>
</div>

<?php include '../footer.php'; ?>