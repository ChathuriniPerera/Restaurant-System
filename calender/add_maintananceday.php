<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Include Database Connection
include '../conn.php';
?>
<?php
$date = $description = $s_time = $e_time = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {
    $e = array();

    $date = clean_data($_POST['date']);
    $description = clean_data($_POST['description']);
    $s_time = clean_data($_POST['s_time']);
    $e_time = clean_data($_POST['e_time']);

    if (empty($date)) {
        $e['date'] = "Date should not be empty";
    }
    if (empty($description)) {
        $e['description'] = "Description should not be empty";
    }
    if (empty($s_time)) {
        $e['s_time'] = "Start Time should not be empty";
    }
    if (empty($e_time)) {
        $e['e_time'] = "End Time should not be empty";
    }
    if (empty($e)) {
        $sql_m = "INSERT INTO `tb_maintanance`(`date`, `description`, `start_time`, `end_time`) VALUES ('$date','$description','$s_time','$e_time')";
        $result_m = $conn->query($sql_m);
        if ($result_m === TRUE) {
//            echo 'Data Entered Success';
        } else {
            echo 'Data Update Failed' . $conn->error;
        }
    }
}
?>
<div class="row">
    <div class="col-4">
        <div class="form">
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                  enctype="multipart/form-data"> 
                <div class="form-group">
                    <label>Status Type</label>
                    <input type="text" class="form-control" id="" value="Maintanance" readonly="">
                </div>
                <div class="form-group ">
                    <label >Date</label>
                    <input type="date" class="form-control" id="" name="date" min="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="form-group ">
                    <label >Description</label>
                    <input type="text" class="form-control" name="description" value="<?php echo @$description; ?>">
                    <div class="text-danger"><?php echo @$e['description']; ?></div>
                </div>
                <div class="form-group ">
                    <label >Start Time</label>
                    <input type="time" class="form-control" id="stime" name="s_time" max="<?php echo date("h:i:sa"); ?>">
                </div>
                <div class="form-group ">
                    <label >Close Time</label>
                    <input type="time" class="form-control" id="etime" name="e_time" max="<?php echo date("h:i:sa"); ?>">
                </div> 
                <div class="card-footer">
                    <button type="submit" name="operate" value="save" class="btn btn-primary">Add Details</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-8">
        <?php
        $sql_tb = "SELECT * FROM `tb_maintanance`";
        $result_tb = $conn->query($sql_tb);
        $result_tb->num_rows;
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th>Start Time</th>
                    <th>Close Time</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_tb->num_rows > 0) {
                    while ($row = $result_tb->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['date']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['start_time']; ?></td>     
                            <td><?php echo $row['end_time']; ?></td>  
                            <td><a href="<?php echo SITE_URL; ?>calender/delete_maintanance.php?rapair_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-eraser"></i></a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php include '../footer.php'; ?>
