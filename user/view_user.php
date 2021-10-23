<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$sql = "SELECT * FROM tb_employee";
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
            <th>Full Name</th>
            <th>User Type</th>
            <th>Profile Image</th>
            <th>Email</th>
            <th>Telephone</th>
            <th>Address</th>
            <th>Edit Users</th>
            <th>Access Control</th>
            <th>Change Password</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                ?>
                <tr>
                    <td><?php echo $row['title'] . " " . $row['full_name']; ?></td>
                    <td><?php echo $row['user_type']; ?></td>

                    <td><img src="<?php echo SITE_URL; ?>Upload/<?php echo $row['profile_image']; ?>" class="img-fluid"
                             style="width:50px"></td>

                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['telephone']; ?></td>
                    <td><?php echo $row['address']; ?></td>

                    <td><a href="<?php echo SITE_URL; ?>user/edit_user.php?user_id=<?php echo $row['user_id']; ?>"
                           class="btn btn-primary"><i class="fas fa-user-edit"></i></td>
                    <td>
                        <?php if ($row['status'] != 2) { ?> 
                            <a href="<?php echo SITE_URL; ?>user/delete_user.php?user_id=<?php echo $row['user_id']; ?>&status=<?php echo $row['status'] ?>"
                               class="btn btn-danger"><?php if ($row['status'] == 0) { ?>
                                    <i class="fas fa-trash"></i>
                                <?php } else {
                                    ?> 
                                    <i class="fas fa-user-slash"></i>
                                <?php }
                            }
                            ?>
                    </td> 
                    <td><a href="<?php echo SITE_URL; ?>user/change_password.php?user_id=<?php echo $row['user_id']; ?>"
                           class="btn btn-warning"><i class="fas fa-unlock-alt"></i></td>
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