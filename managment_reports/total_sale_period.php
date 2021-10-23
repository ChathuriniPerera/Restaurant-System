<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$date_from = $to_date  = null;
$where = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $date_from = clean_data($_POST['from_date']);
    $to_date = clean_data($_POST['to_date']);
  

    if (empty($date_from)) {
        $e['from_date'] = "Date shouldn't be empty";
    }
    if (empty($to_date)) {
        $e['to_date'] = "Date shouldn't be empty";
    }

    if (!empty($date_from) && !empty($to_date)) {
        $where .= " created BETWEEN '$date_from' AND '$to_date' AND";
    }

    if (!empty($where)) {
        $where = substr($where, 0, -3);
        $where = " WHERE $where";
    }
}

$sql_month = "SELECT year(tb_order.created) AS year, monthname(tb_order.created) AS month, SUM(tb_order_item.item_total) AS amount FROM `tb_order_item` LEFT JOIN tb_order ON tb_order_item.order_id = tb_order.order_id $where GROUP BY year(tb_order.created), monthname(tb_order.created)";
$result_month = $conn->query($sql_month);
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
                    <!--<th>Category Name</th>-->
                    <th>Year</th>
                    <th>Month</th>
                    <th>Amount</th>  
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result_month->num_rows > 0) {
                    $total = 0;
                    while ($row_month = $result_month->fetch_assoc()) {
                        $total += $row_month['amount'];
                        ?>
                        <tr>
                            <td><?php echo $row_month['year']; ?></td>
                            <td><?php echo $row_month['month']; ?></td>
                            <td><?php echo $row_month['amount']; ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr>
                    <td colspan="2">Total : </td>
                    <td><?php echo number_format(@$total, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<?php include '../footer.php'; ?>