<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
$user_id = $full_name = $password = $confirm_password = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "update") {
    $user_id = clean_data($_POST['user_id']);
    $full_name = clean_data($_POST['full_name']);
    $password = clean_data($_POST['password']);
    $confirm_password = clean_data($_POST['confirm_password']);

    if (empty($password)) {
        $e['password'] = "Password should not be empty";
    }
    if (empty($confirm_password)) {
        $e['confirm_password'] = "Password should not be empty";
    }
    //password strength check
    if (!empty($password)) {
        $passlength = strlen($password);
        $uppercase = preg_match('@[A-Z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChar = preg_match('@[^\w]@', $password);

        if ($passlength < 8) {
            $e['password'] = @$e['password'] . "Password must be at least 8 characters in length." . "<br>";
        }
        if ($uppercase == 0) {
            $e['password'] = @$e['password'] . "Password must include at least one uppercase letter." . "<br>";
        }
        if ($number == 0) {
            $e['password'] = @$e['password'] . "Password must include at least one number." . "<br>";
        }
        if ($specialChar == 0) {
            $e['password'] = @$e['password'] . "Password must include at least one special chatacter.";
        }
    }

    //Confirm_password
    if (!empty($confirm_password)) {
        if ($confirm_password != $password) {
            $e['confirm_password'] = "Password is not matched.";
        }
    }

    //Update Data Into Database
    if (empty($e)) {
        $sql = "UPDATE `tb_employee` SET `password`='" . sha1($password) . "' WHERE user_id='$user_id'";
        $r = $conn->query($sql);
        if ($r === TRUE) {
            echo 'Success';
        } else {
            echo "Data Update Failed:" . $conn->error;
        }
    }
}

//Load data into form fields from database
if (isset($_GET['user_id'])) {
    $user_id = clean_data($_GET['user_id']);
}
if (!empty($user_id)) {
    $sql = "SELECT * FROM tb_employee WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_id = $row['user_id'];
            $full_name = $row['full_name'];
        }
    }
}
?>
<div class="row">
    <div class="card text-center col-md-5">
        <div class="card-header">
            Change Password
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
              enctype="multipart/form-data">
            <div class="card-body">
                <div class="form-group">
                    <label >User Name</label>
                    <input type="text" class="form-control" id="full_name" name="full_name" readonly value="<?php echo $full_name; ?>">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                    <div class="text-danger"><?php echo @$e['password']; ?></div>
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Confirm Password</label>
                    <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Confirm Password">
                    <div class="text-danger"><?php echo @$e['confirm_password']; ?></div>
                </div>
            </div>
            <div class="card-footer text-muted">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                <button type="submit" name="operate" value="update" class="btn btn-primary">Change Password</button>
            </div>
        </form>
    </div>

    <div class="col-md-7">

        <!--Search Bar-->
        <form class="col d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
            <div class="input-group">
                <input type="text" class="form-control bg-yellow border-0 small" type="search" id="myInput" onkeyup="myFunction()" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2" >        

                <button class="btn btn-primary" type="button" >
                    <i class="fas fa-search fa-sm"></i>
                </button>

            </div>
        </form>

        <?php
        $sql = "SELECT * FROM `tb_employee`";
        $result = $conn->query($sql);
        $result->num_rows;
        ?>

        <table class="table table-striped" id="myTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User Type</th>
                    <th>Profile Image</th>
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
                            <td><a href="<?php echo SITE_URL; ?>user/edit_user.php?user_id=<?php echo $row['user_id']; ?>"
                                   class="btn btn-primary"><i class="fas fa-user-edit"></i>
                            </td>
                            <td><?php if ($row['status'] != 2) { ?> 
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
                            <td><a href="<?php echo SITE_URL; ?>user/reset_password.php?user_id=<?php echo $row['user_id']; ?>"
                                   class="btn btn-warning"><i class="fas fa-unlock-alt"></i></a></td>

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