<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Include Database Connection
include '../conn.php';
?>

<?php
$month = $rate = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $getid = clean_data(@$_GET['id']);
}
if (!empty($getid)) {
    $sql_g = "SELECT * FROM `tb_discount` WHERE id='$getid'";
    $result_g = $conn->query($sql_g);

    if ($result_g->num_rows > 0) {
        while ($row_g = $result_g->fetch_assoc()) {
            $id = $row_g['id'];
            $gmonth = $row_g['month'];
            $grate = $row_g['discount'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] = "save") {

    $month = clean_data($_POST['month']);
    $rate = clean_data($_POST['rate']);

    if (empty($month)) {
        $e['month'] = "Month Can not be Empty";
    }
    if (empty($rate)) {
        $e['rate'] = "Rate Can not be Empty";
    }

    if (empty($e)) {
        $discount_sql = "INSERT INTO `tb_discount`(`month`, `discount`) VALUES ('$month', '$rate')";
        $discount_results = $conn->query($discount_sql);
        if ($discount_results === TRUE) {
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
                    <input type="text" class="form-control" id="" value="Discounts" readonly="">
                </div>
                <div class="form-group ">
                    <label >Month</label>
                    <select id="" class="form-control" name="month" >
                        <option value="">---</option>
                        <option value="January" <?php if ($month == 'January') { ?> selected<?php } ?>>January</option>
                        <option value="February" <?php if ($month == 'February') { ?> selected <?php } ?>>February</option>
                        <option value="March" <?php if ($month == 'March') { ?> selected <?php } ?>>March</option>
                        <option value="April" <?php if ($month == 'April') { ?> selected <?php } ?>>April</option>
                        <option value="May" <?php if ($month == 'May') { ?> selected <?php } ?>>May</option>      
                        <option value="June"<?php if ($month == 'June') { ?> selected <?php } ?>>June</option>
                        <option value="July"<?php if ($month == 'July') { ?> selected <?php } ?>>July</option>
                        <option vlaue="August" <?php if ($month == 'August') { ?> selected<?php } ?>> August </option>
                        <option value="September" <?php if ($month == 'September') { ?> selected <?php } ?>>September</option>
                        <option value="October" <?php if ($month == 'October') { ?> selected <?php } ?>>October</option>
                        <option value="November" <?php if ($month == 'November') { ?> selected <?php } ?>>November</option>
                        <option value="December" <?php if ($month == 'December') { ?> selected <?php } ?>>December</option>
                    </select>
                    <div class="text-danger"><?php echo @$e['month']; ?></div>
                </div>
                <div class="form-group">
                    <label for="">Discount Rate</label>
                    <input type="text" class="form-control" id="" name="rate" value="<?php echo @$grate; ?>">
                    <div class="text-danger"><?php echo @$e['rate']; ?></div>
                </div> 
                <div class="form-group col-md-12">
                    <button type="submit" name="operate" value="save" class="btn btn-primary">Add Discount</button>
                </div>
            </form>
        </div>
    </div>
    <div class="col-8">
        <?php
        $sql_tb = "SELECT * FROM `tb_discount`";
        $result_tb = $conn->query($sql_tb);
        $result_tb->num_rows;
        ?>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Month</th>
                    <th>Discount</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_tb->num_rows > 0) {
                    while ($row_tb = $result_tb->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row_tb['month']; ?></td>
                            <td><?php echo $row_tb['discount'] . "%"; ?></td>                    
                            <td><a href="<?php echo SITE_URL; ?>calender/delete_discounts.php?month_id=<?php echo $row_tb['id']; ?>" class="btn btn-primary"><i class="fas fa-eraser"></i></a></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../footer.php'; ?>s
