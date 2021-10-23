<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$date_from = $to_date = $status = null;
$where = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $date_from = clean_data($_POST['from_date']);
    $to_date = clean_data($_POST['to_date']);
    $status = clean_data($_POST['status']);

    if (empty($date_from)) {
        $e['from_date'] = "Date shouldn't be empty";
    }
    if (empty($to_date)) {
        $e['to_date'] = "Date shouldn't be empty";
    }
    if (!empty($date_from) && !empty($to_date)) {
        $where .= " created BETWEEN '$date_from' AND '$to_date' AND";
    }
    if (!empty($status)) {
        $where .= " status = '$status' AND";
    }
    if (!empty($where)) {
        $where = substr($where, 0, -3);
        $where = " WHERE $where";
    }
}
$sql = "SELECT * FROM tb_order $where";
$result = $conn->query($sql);
?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="inputCity">Date From</label>
                    <input type="date" class="form-control" id="" name="from_date" value="<?php echo $date_from; ?>">
                    <div class="text-danger"><?php echo @$e['from_date']; ?></div>
                </div>
                <div class="form-group col-md-3">
                    <label for="inputState">Date To</label>
                    <input type="date" class="form-control" id="" name="to_date" value="<?php echo $to_date; ?>">
                    <div class="text-danger"><?php echo @$e['to_date']; ?></div>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Status</label>
                    <select id="inputState" class="form-control" name="status">
                        <option value="">Choose...</option>
                        <option value="0" <?php if ($status == "0") { ?> selected <?php } ?>>Pending Confirmation</option>
                        <option value="1" <?php if ($status == "1") { ?> selected <?php } ?>> Confirmed</option>
                        <option value="2" <?php if ($status == "2") { ?> selected <?php } ?>>Management Accepted</option>
                        <option value="3" <?php if ($status == "3") { ?> selected <?php } ?>>Processing in Kitchen</option>
                        <option value="4" <?php if ($status == "4") { ?> selected <?php } ?>>Ready To Delivery</option>
                        <option value="5" <?php if ($status == "5") { ?> selected <?php } ?>>On Delivery</option>
                        <option value="6" <?php if ($status == "6") { ?> selected <?php } ?>>Completed</option>
                        <option value="7" <?php if ($status == "7") { ?> selected <?php } ?>>Cancelled</option>
                    </select>
                </div>
                <div class="form-group col-md-3">
                    <button type="submit" class="btn btn-primary btn-sm" name="operate" value="search" style="margin-top: 35px">Generate Reports</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Reference Number</th>
                    <th>Contact Name</th>  
                    <th>Phone Number</th>
                    <th>Email</th>
                    <th>Created Date</th>
                    <th>Delivered On</th>
                    <th>Total Price</th>
                    <th>Payable Amount</th>
                    <th>Payment Method</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo date('Y') . date('m') . date('d') . $row['order_id']; ?></td>
                            <td><?php echo $row['contact_name']; ?></td>
                            <td><?php echo $row['phone_number']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['created']; ?></td>
                            <td><?php echo $row['delivery_date']; ?></td>
                            <td><?php echo $row['total_price']; ?></td>
                            <td><?php echo $row['net_total']; ?></td>
                            <td><?php echo $row['pay_method']; ?></td>
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
