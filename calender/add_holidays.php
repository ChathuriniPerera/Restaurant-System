<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Include Database Connection
include '../conn.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {
    $id = $status_type = $date = $description = null;
    $e = array();

    $id = clean_data($_POST['s_id']);
    $status_type = clean_data($_POST['status']);
   echo $date = clean_data($_POST['date']);
    $description = clean_data($_POST['description']);

    if (empty($date)) {
        $e['date'] = "Date sholud not be empty";
    }
    if (empty($description)) {
        $e['description'] = "Description sholud not be empty";
    }

    if (!empty($date)) {
         $checksql = "SELECT COUNT(date) FROM `tb_holiday` WHERE `date` = '$date'";
         $checkholiday_result = $conn->query($checksql);
         $row_holiday = $checkholiday_result->fetch_assoc();
        echo $count = $row_holiday['COUNT(date)'];
        if ($count != 0) {
             $e['date'] = "Already Made as Holiday";
        } 
    }

    if (empty($e)) {
        $holiday_sql = "INSERT INTO `tb_holiday`(`date`, `description`) VALUES ('$date', '$description')";
        $holiday_results = $conn->query($holiday_sql);
//        print_r($holiday_results);
        if ($holiday_results === TRUE) {
//            echo 'SUCCESS';
        } else {
            echo "Data Update Failed:" . $conn->error;
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
                    <?php
                    $sql_s = "SELECT * FROM `tb_calender_status` WHERE id=1";
                    $result_s = $conn->query($sql_s);
                    if ($result_s->num_rows > 0) {
                        while ($row_s = $result_s->fetch_assoc()) {
                            ?>
                            <input type="hidden" name="s_id" value="<?php echo $id = $row_s['id']; ?>">
                            <input type="text" class="form-control" value="<?php echo $row_s['status_type']; ?>" name="status" readonly>
                            <?php
                        }
                    }
                    ?>
                </div>
                <div class="form-group ">
                    <label >Date</label>
                    <input type="date" class="form-control" name="date" min="<?php echo date('Y-m-d'); ?>">
                    <div class="text-danger"><?php echo @$e['date']; ?></div>
                </div>
                <div class="form-group ">
                    <label >Description</label>
                    <input type="text" class="form-control" name="description" >
                    <div class="text-danger"><?php echo @$e['description']; ?></div>
                </div>
                <div class="form-group col-md-12">
                    <button type="submit" name="operate" value="save" class="btn btn-primary">Add Holiday</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-8">
        <?php
        $sql_tb = "SELECT * FROM `tb_holiday`";
        $result_tb = $conn->query($sql_tb);
        $result_tb->num_rows;
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_tb->num_rows > 0) {
                    while ($row_tb = $result_tb->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row_tb['date']; ?></td>
                            <td><?php echo $row_tb['description']; ?></td>                       
                             <td><a href="<?php echo SITE_URL; ?>calender/delete_holiday.php?date_id=<?php echo $row_tb['id']; ?>" class="btn btn-primary"><i class="fas fa-eraser"></i></a></td>
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