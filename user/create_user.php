<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>

<?php
$title = $full_name = $email = $telephone = $address = $user_type = $password = $confirm_password = $profile_image = $employeeid = $Dateofbirth = null;

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {

    $e = array();

    $title = clean_data($_POST['title']);
    $full_name = clean_data($_POST['full_name']);
    $employeeid = clean_data($_POST['employeeid']);
    $Dateofbirth = clean_data($_POST['dateofbirth']);
    $email = clean_data($_POST['email']);
    $telephone = clean_data($_POST['telephone']);
    $address = clean_data($_POST['address']);
    $user_type = clean_data($_POST['user_type']);
    $password = clean_data($_POST['password']);
    $confirm_password = clean_data($_POST['confirm_password']);

    //empty validation
    if (empty($title)) {
        $e['title'] = "Title sholud not be empty";
    }
    if (empty($full_name)) {
        $e['full_name'] = "Name should not be empty";
    }
    if (empty($employeeid)) {
        $e['employeeid'] = "Employee ID should not be empty";
    }
    if (empty($Dateofbirth)) {
        $e['dateofbirth'] = "Join date should not be empty";
    }
    if (empty($email)) {
        $e['email'] = "Email should not be empty";
    }
    if (empty($telephone)) {
        $e['telephone'] = "Telephone should not be empty";
    }
    if (empty($address)) {
        $e['address'] = "Address should not be empty";
    }
    if (empty($user_type)) {
        $e['user_type'] = "User Type should not be empty";
    }
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

    //Name string validattion

    if (!empty($full_name)) {
        $fullnameString = preg_match('@[^ \w]@', $full_name) + preg_match('@[0-9]@', $full_name);

        if ($fullnameString != 0) {
            $e['full_name'] = "Name couldn't contain any number or special character";
        }
    }

    //Birthdate Vlidation
    if (!empty($Dateofbirth)) {
        $byear = substr($Dateofbirth, 0, 4);
        $thisyr = date('Y');
        $age = $thisyr - $byear;
        if ($age < 18) {
            $e['dateofbirth'] = "Employee must be a 18+ Person";
        }
    }


    //NIC validation
    if (!empty($employeeid)) {
        $gender = substr($employeeid, 2, 3);
        $birthyr = substr($Dateofbirth, 2, 2);
        $check_v = substr($employeeid, 9);
        $idlength = strlen($employeeid);
        $nic_yr = substr($employeeid, 0, 2);
        $title;
        if ($idlength == 10) {
            if ($nic_yr != $birthyr) {
                $e['employeeid'] = "Employee NIC Does not match";
            } if ($check_v != "V") {
                $e['employeeid'] = "Employee NIC Does not match";
            }
            if ($gender > 500) {
                if (($title != "Ms.") && ($title != "Miss.")) {
                    $e['employeeid'] = "Employee NIC Does not match";
                }
            } else {
                if ($title != "Mr.") {
                    $e['employeeid'] = "Employee NIC Does not match";
                }
            }
        }
        $newbirth_yr = substr($Dateofbirth, 0, 4);
        $newnic_yr = substr($employeeid, 0, 4);
        $new_gender = substr($employeeid, 4, 3);
        if ($idlength == 12) {
            if ($newnic_yr != $newbirth_yr) {
                $e['employeeid'] = "Employee NIC Does not match";
            }
            if ($new_gender > 500) {
                if (($title != "Ms.") && ($title != "Miss.")) {
                    $e['employeeid'] = "Employee NIC Does not match";
                }
            } else {
                if ($title != "Mr.") {
                    $e['employeeid'] = "Employee NIC Does not match";
                }
            }
        }
    }

    //Email Validation

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "Invalid Email Address";
        }
    }

    //Telephone Number validattion

    if (!empty($telephone)) {
        $validtelephone = filter_var($telephone, FILTER_SANITIZE_NUMBER_INT);
        $validtelephone = str_replace("-", "", $validtelephone);
        if (strlen($validtelephone) == 10) {
            $e['telephone'] = "Please Set the Country Code '+94' at the Begining";
        }

        if (strlen($validtelephone) != 12 && strlen($validtelephone) < 12) {
            $e['telephone'] = "Invalid Phone Number";
        }

        if (strlen($validtelephone) == 12) {
            $phonecode = substr($validtelephone, 0, 3);
            if ($phonecode != +94) {
                
            }
        }
    }

    //advance validations
    if (!empty($user_name)) {
        $sql = "SELECT * FROM tb_employee WHERE user_name='$user_name'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            $e['user_name'] = "User Name Already Taken by Other User";
        }
    }

    //File/Image Upload
    if (empty($e)) {
        $target_dir = "../Upload/";
        //../uploads/myphoto.jpg
        $target_file = $target_dir . basename($_FILES["profile_image"]["name"]);
        $uploadOK = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["profile_image"]['tmp_name']);
        if ($check !== false) {
            $uploadOK = 1;
        } else {
            $e['profile_image'] = @$e['profile_image'] . "File is not an Image." . "</br>";
            $uploadOK = 0;
        }

        if (file_exists($target_file)) {
            $e['profile_image'] = @$e['profile_image'] . "Sorry File Already Exists." . "</br>";
            $uploadOK = 0;
        }
        if ($_FILES["profile_image"]["size"] > 5000000) {
            $e['profile_image'] = @$e['profile_image'] . "Sorry, your file is too large." . "</br>";
            $uploadOK = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['profile_image'] = @$e['profile_image'] . "Sorry, Only JPG,JPeG,PNG,pdf & GIF are Allowed" . "</br>";
            $uploadOK = 0;
        }
        if ($uploadOK == 0) {
            // $e['profile_image']="Sorry, Your File Was not Upload.";
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $profile_image = basename($_FILES["profile_image"]["name"]);
            } else {
                $e['profile_image'] = @$e['profile_image'] . "Sorry,there was an error uploading your file." . "</br>";
            }
        }
    }

    //Submit Data Into Database
    if (empty($e)) {
        $sql = "INSERT INTO `tb_employee`(`user_type`, `password`, `title`, `full_name`,  `employee_nic`, `birth_date`, `email`, `telephone`, `address`, `profile_image`) 
                    VALUES ('$user_type','" . sha1($password) . "','$title','$full_name','$employeeid','$Dateofbirth','$email','$telephone','$address','$profile_image')";
        $r = $conn->query($sql);
        if ($r === TRUE) {
//           echo "Data Insert"; 
            $title = $full_name = $email = $telephone = $address = $user_type = $password = $confirm_password = $profile_image = $employeeid = $Dateofbirth = null;
        } else {
            echo "Data Insert Failed:" . $conn->error;
        }
    }
}
?>
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Create New User Account
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Title</label>
                                <select name="title" id="title" class="form-control">
                                    <option value="">---</option>
                                    <option value="Mr." <?php if ($title == 'Mr.') { ?> selected <?php } ?>>Mr.</option>
                                    <option value="Miss." <?php if ($title == 'Miss.') { ?> selected <?php } ?>>Miss.</option>
                                    <option value="Ms." <?php if ($title == 'Ms.') { ?> selected <?php } ?>>Ms.</option>
                                </select>
                                <div class="text-danger"><?php echo @$e['title']; ?></div>
                            </div>
                        </div>

                        <div class="col">
                            <div class="form-group">
                                <label for="full_name">Name</label>
                                <input type="text" name="full_name" id="full_name" class="form-control"
                                       placeholder="Name" value="<?php echo "$full_name"; ?>">
                                <div class="text-danger"><?php echo @$e['full_name']; ?></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="eid">Employee NIC</label>
                        <input type="text" class="form-control" id="employeeid" name="employeeid" placeholder="Employee ID"
                               value="<?php echo "$employeeid"; ?>">
                        <div class="text-danger"><?php echo @$e['employeeid']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="bd">Date of Birth</label>
                        <input type="date" class="form-control" name="dateofbirth" placeholder="Date of Birth" 
                               value="<?php echo "$Dateofbirth"; ?>" max="<?php echo date('Y-m-d') ?>">
                        <div class="text-danger"><?php echo @$e['dateofbirth']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" placeholder="Email"
                               value="<?php echo "$email"; ?>">
                        <div class="text-danger"><?php echo @$e['email']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="telephone">Telephone</label>
                        <input type="text" class="form-control" id="telephone" name="telephone"
                               placeholder="Telephone Number" value="<?php echo "$telephone"; ?>">
                        <div class="text-danger"><?php echo @$e['telephone']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="address">Address</label>
                        <input type="text" class="form-control" id="address" name="address" placeholder="Address"
                               value="<?php echo $address; ?>">
                        <div class="text-danger"><?php echo @$e['address']; ?></div>
                    </div>


                    <div class="form-group">
                        <label for="user_type">User Type</label>
                        <select id="inputState" class="form-control" name="user_type">
                            <option value="">---</option>
                            <option value="Manager" <?php if ($user_type == 'Manager') { ?> selected<?php } ?>>Manager
                            </option>
                            <option value="Cashier" <?php if ($user_type == 'Cashier') { ?> selected <?php } ?>>Cashier
                            </option>
                            <option value="Chef" <?php if ($user_type == 'Chef') { ?> selected <?php } ?>>Chef</option>
                            <option value="Waitor" <?php if ($user_type == 'Waitor') { ?> selected <?php } ?>>Waitor
                            </option>
                            <option value="Dilivery Person" <?php if ($user_type == 'Dilivery Person') { ?> selected <?php } ?>>Dilivery Person</option>
                        </select>
                        <div class="text-danger"><?php echo @$e['user_type']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Enter Password" value="<?php echo "$password"; ?>">
                        <div class="text-danger"><?php echo @$e['password']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="confirm_password">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm_password"
                               name="confirm_password" placeholder="Confirm Password"
                               value="<?php echo "$confirm_password"; ?>">
                        <div class="text-danger"><?php echo @$e['confirm_password']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image"
                               placeholder="Select Profile Image" value="">
                        <div class="text-danger"><?php echo @$e['profile_image']; ?></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" name="operate" value="save" class="btn btn-primary">Create
                        Account</button>
                </div>
            </form>
        </div>
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
                                            <?php
                                        }
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
