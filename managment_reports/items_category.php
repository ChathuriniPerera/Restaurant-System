<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$category = null;
$where = null;
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $category = clean_data($_POST['category']);

    if (empty($category)) {
        $e['category'] = "Category Schouldn't be Empty";
    }
}
$sql = "SELECT * FROM tb_menu WHERE category_id=$category";
$result = $conn->query($sql);
?>

<div class="card">
    <div class="card-body">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-group col-md-3">
                    <label for="">Category</label>
                    <select id="inputState" class="form-control" name="category">
                        <option value="">Choose...</option>
                        <?php
                        $sql_cat = "SELECT * FROM `tb_menu_category`";
                        $result_cat = $conn->query($sql_cat);
                        if ($result_cat->num_rows > 0) {
                            while ($row_cat = $result_cat->fetch_assoc()) {
                                ?>
                                <option value="<?php echo $row_cat['category_id']; ?>" <?php if (@$category == $row_cat['category_id']) { ?> selected <?php } ?>><?php echo $row_cat['category']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <div class="text-danger"><?php echo @$e['category']; ?></div>
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
                    <th>Item ID</th>
                    <th>Item Name</th>
                    <th>Description</th>
                    <th>Item Price</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (@$result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $row['item_id']; ?></td>
                            <td><?php echo $row['item_name']; ?></td>
                            <td><?php echo $row['description']; ?></td>
                            <td><?php echo $row['price']; ?></td>
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
