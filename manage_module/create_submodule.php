<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$main_module = $module_description = $module_name = $view_file_name = $sub_module_id = null;

$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {

    $main_module = clean_data($_POST['main_module']);
    $module_description = clean_data($_POST['module_description']);
    $module_name = clean_data($_POST['module_name']);
    $view_file_name = clean_data($_POST['view_file_name']);

    if (empty($main_module)) {
        $e['main_module'] = "Please Select a Main Module";
    }
    if (empty($module_description)) {
        $e['module_description'] = "Sb Module Can't be Empty";
    }
    if (empty($module_name)) {
        $e['module_name'] = "Directory/Folder Can't be Empty";
    }
    if (empty($view_file_name)) {
        $e['view_file_name'] = "View File Name Can't be Empty";
    }

    if (!empty($main_module)) {
        $sub_sql = "SELECT MAX(`menu_index`) AS menu_index FROM `tb_module` WHERE LENGTH(`module_id`)=4 AND SUBSTR(`module_id`,1,2)= $main_module";
        $sub_result = $conn->query($sub_sql);
        $row = $sub_result->fetch_assoc();
        $sub_result = (int) $row['menu_index'] + 1;
        if ($sub_result < 10) {
            $sub_id = $main_module . "0" . $sub_result;
        } else {
            $sub_id = "0" . $main_module . $sub_result;
        }

        if (empty($e)) {
            $sql_insert = "INSERT INTO `tb_module`(`module_id`, `description`, `module`, `view`, `menu_index`, `menu_icon`) 
                                       VALUES ('$sub_id','$module_description','$module_name','$view_file_name','$sub_result','')";
            $result_insert = $conn->query($sql_insert);
            if ($result_insert === TRUE) {
                ?>
                <div class="alert alert-warning" role="alert">
                    Data Insert Success!
                </div>
                <?php
                $main_module = $module_description = $module_name = $view_file_name = $sub_module_id = null;
            } else {
                echo "Data Insert Failed" . $conn->error;
            }
        }
    }
}
?>

<div class="col-sm-6">
    <div class="card">
        <div class="card-header">Sub Module</div>
        <div class="card-body">
            <form class="needs-validation" action=" <?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="maltipart/form-data">
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <label for="inputState">Main Module</label>
                        <select id="main_module" name="main_module" class="form-control">
                            <option value="">Choose...</option>
                            <?php
                            $sql_sub = "SELECT * FROM `tb_module` WHERE LENGTH(`module_id`)=2";
                            $result_sub = $conn->query($sql_sub);
                            if ($result_sub->num_rows > 0) {
                                while ($row_sub = $result_sub->fetch_assoc()) {
                                    ?>
                                    <option value="<?php echo $row_sub['module_id'] ?>"><?php echo $row_sub['description'] ?></option>
                                    <?php
                                }
                            }
                            ?>
                        </select>
                         <div class="text-danger"><?php echo @$e['main_module']; ?></div>
                    </div>
                </div>    
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <label >Sub Module Description</label>
                        <input type="text" class="form-control"" placeholder="Sub Module Description" id="module_description" name="module_description" value="<?php echo $module_description; ?>">
                        <div class="text-danger"><?php echo @$e['module_description']; ?></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <label for="">Module Name</label>
                        <input type="text" class="form-control" placeholder="Directory/Folder Name" id="module_name" name="module_name" value="<?php echo $module_name; ?>">
                        <div class="text-danger"><?php echo @$e['module_name']; ?></div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="col-md-9 mb-3">
                        <label for="">View File Name</label>
                        <input type="text" class="form-control" placeholder="PHP File Name" id="view_file_name" name="view_file_name" value="<?php echo $view_file_name; ?>">
                        <div class="text-danger"><?php echo @$e['view_file_name']; ?></div>
                    </div>
                </div>
                <button class="btn btn-primary" value="save" name="operate" type="submit">Create Module</button>
            </form>
        </div>
    </div>
</div>
<?php include '../footer.php'; ?>
