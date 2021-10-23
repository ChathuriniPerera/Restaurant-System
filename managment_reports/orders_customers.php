<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$date_from = $to_date = $customer = null;
$where = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $date_from = clean_data($_POST['from_date']);
    $to_date = clean_data($_POST['to_date']);
    $customer = clean_data($_POST['customer']);

    if (empty($date_from)) {
        $e['from_date'] = "Date shouldn't be empty";
    }
    if (empty($to_date)) {
        $e['to_date'] = "Date shouldn't be empty";
    }
    if (empty($customer)) {
        $e['customer'] = "Customer shouldn't be empty";
    }
    if (!empty($date_from) && !empty($to_date)) {
        $where .= " created BETWEEN '$date_from' AND '$to_date' AND";
    }
    if (!empty($customer)) {
        $where .= " customer_id = '$customer' AND";
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
                    <div class="text-danger"><?php echo @$e['from_date']; ?></div>
                </div>
                <div class="form-group col-md-3">
                    <label for="">Customer Name</label>
                    <select id="inputState" class="form-control" name="customer" >
                        <option value="">Choose...</option>
                        <?php
                        $sql_cas = "SELECT * FROM `tb_customers`";
                        $result_cas = $conn->query($sql_cas);
                        if ($result_cas->num_rows > 0) {
                            while ($row_cas = $result_cas->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_cas['customer_id']; ?>" <?php if (@$customer == $row_cas['customer_id']) { ?> selected <?php } ?>><?php echo $row_cas['first_name'] . " " . $row_cas['last_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php echo @$e['customer']; ?></div>
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
