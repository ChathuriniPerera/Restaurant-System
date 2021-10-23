<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$sql = "SELECT * FROM `tb_customers`";
$result = $conn->query($sql);
$result->num_rows;
?>

<!--Search Bar-->
<form class="col d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
    <div class="input-group">
        <input type="text" class="form-control bg-yellow border-0 small" type="search" id="myInput" onkeyup="myFunction()" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" >        
        
            <button class="btn btn-primary" type="button" >
                <i class="fas fa-search fa-sm"></i>
            </button>
        
    </div>
</form>

<table class="table table-striped" id="myTable">
    <thead>
        <tr>
            <th>Customer ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Phone Number</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['customer_id']; ?></td>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['phone_number']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                    <td><a href="<?php echo SITE_URL; ?>customer_manage/customer_orders.php?customer_id=<?php echo $row['customer_id']; ?>" class="btn btn-primary"><i class="fas fa-eye"></i></a></td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<?php include '../footer.php'; ?>

<script>
    $(document).ready(function () {
        $("#myInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#myTable tr").filter(function () {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });
    });
</script>
