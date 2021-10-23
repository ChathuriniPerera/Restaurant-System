<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$category_id = $category_name = null;

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {
    $e = array();

    $category_name = clean_data($_POST['category_name']);

    //empty validation
    if (empty($category_name)) {
        $e['category_name'] = "Category Name should not be Empty..!";
    }

    if (empty($e)) {
        $sql = "INSERT INTO `tb_menu_category`(`category`) VALUES ('$category_name')";
        $category = $conn->query($sql);
        if ($category === TRUE) {
            echo "Data Successfuly Inserted:";
        } else {
            echo "Data Insert Failed:" . $conn->error;
        }
    }
}
?>


<div class="col">
    <form class="form-inline" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
          enctype="multipart/form-data">
        <div class="form-group mb-2">
            <label for="category_name">Category Name</label>
            <input type="text" class="form-control mx-sm-5 mb-6" id="category_name" name="category_name" 
                   placeholder="Category Name" value="<?php echo "$category_name"; ?>">
            <div class="text-danger"><?php echo @$e['category_name']; ?></div>
            <button type="submit" name="operate" value="save" class="btn btn-primary">Create Category</button>
        </div>
    </form>
</div>
<div class="col">

    <?php
    $sql = "SELECT * FROM `tb_menu_category`";
    $result = $conn->query($sql);
    $result->num_rows;
    ?>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Category ID</th>
                <th>Category Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $row['category_id']; ?></td>
                        <td><?php echo $row['category']; ?></td>
                        <td><a href="<?php echo SITE_URL; ?>menu_items/edit_category.php?category_id=<?php echo $row['category_id']; ?>" class="btn btn-primary"><i class="fas fa-pen-alt"></i></a></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>


<?php include '../footer.php'; ?>