<?php
include '../header.php';
include '../nav.php';

//Include Database Connection
include '../conn.php';
?>

<?php
$id = $day = $open_time = $close_time = null;

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "update_calender") {
    $e = array();

    $id = clean_data($_POST['id']);
    $day = clean_data($_POST['day']);
    $open_time = clean_data($_POST['open_time']);
    $close_time = clean_data($_POST['close_time']);

    //empty validation
    if (empty($day)) {
        $e['day'] = "Day should not be Empty..!";
    }
    if (empty($open_time)) {
        $e['open_time'] = "Open Time should not be Empty..!";
    }
    if (empty($close_time)) {
        $e['close_time'] = "Open Time should not be Empty..!";
    }

    if (empty($e)) {
        $sql = "INSERT INTO `tb_calender`(`day`, `open_time`, `close_time`) VALUES ('$day','$open_time','$close_time')";
        $result = $conn->query($sql);
        if ($result === TRUE) {
//            echo "Data Successfuly Inserted:";
        } else {
            echo "Data Insert Failed:" . $conn->error;
        }
    }
}

//Load DB data
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $id = clean_data(@$_GET['id']);
    $sql = "SELECT * FROM `tb_calender` WHERE id='$id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $day = $row['day'];
            $open_time = $row['open_time'];
            $close_time = $row['close_time'];
        }
    }
}
?>
<div class="row">
    <div class="col">

        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
              enctype="multipart/form-data">

            <div class="form-group ">
                <label for="day">Day</label>
                <select id="day" class="form-control" name="day">
                    <option value="Sunday" <?php if ($day == 'Sunday') { ?> selected<?php } ?>>Sunday
                    </option>
                    <option value="Monday" <?php if ($day == 'Monday') { ?> selected <?php } ?>>Monday
                    </option>
                    <option value="Tuesday" <?php if ($day == 'Tuesday') { ?> selected <?php } ?>>Tuesday</option>
                    <option value="Wednesday" <?php if ($day == 'Wednesday') { ?> selected <?php } ?>>Wednesday
                    </option>
                    <option value="Thursday" <?php if ($day == 'Thursday') { ?> selected <?php } ?>>Thursday</option>
                    <option value="Friday" <?php if ($day == 'Friday') { ?> selected <?php } ?>>Friday
                    </option>
                    <option value="Saturday" <?php if ($day == 'Saturday') { ?> selected <?php } ?>>Saturday
                    </option>
                </select>
                <div class="text-danger"><?php echo @$e['day']; ?></div>
            </div>

            <div class="form-group">
                <label for="">Open Time</label>
                <input type="time" class="form-control" id="" name="open_time" value="<?php echo $open_time; ?>">
                <div class="text-danger"><?php echo @$e['open_time']; ?></div>
            </div>

            <div class="form-group">
                <label for="">Close Time</label>
                <input type="time" class="form-control" id="" name="close_time" value="<?php echo $close_time; ?>">
                <div class="text-danger"><?php echo @$e['close_time']; ?></div>
            </div>
            <input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
            <button type="submit" class="btn btn-primary" name="operate" value="update_calender">Update Calender</button>
        </form>
    </div>
    <div class="col">

        <?php
        $sql_tb = "SELECT * FROM `tb_calender`";
        $result_tb = $conn->query($sql_tb);
        $result_tb->num_rows;
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Day</th>
                    <th>Open Hour</th>
                    <th>Close Hour</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_tb->num_rows > 0) {
                    while ($row = $result_tb->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['day']; ?></td>
                            <td><?php echo $row['open_time']; ?></td>
                            <td><?php echo $row['close_time']; ?></td>                       
                            <td><a href="<?php echo SITE_URL; ?>calender/deletecalender.php?day_id=<?php echo $row['id']; ?>" class="btn btn-primary"><i class="fas fa-eraser"></i></a></td>
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
