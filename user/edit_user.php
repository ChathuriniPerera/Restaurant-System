<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
$user_id = $title = $full_name = $email = $telephone = $address = $user_type = $profile_image = $employee_id = $Dateofbirth = null;
$e = array(); //errors

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "update") {

    $user_id = clean_data($_POST['user_id']);
    $title = clean_data($_POST['title']);
    $full_name = clean_data($_POST['full_name']);
    $email = clean_data($_POST['email']);
    $telephone = clean_data($_POST['telephone']);
    $address = clean_data($_POST['address']);
    $Dateofbirth = clean_data($_POST['dateofbirth']);
    $employee_id = clean_data($_POST['employeeid']);

    //empty validation
    if (empty($title)) {
        $e['title'] = "Title sholud not be empty";
    }
    if (empty($full_name)) {
        $e['full_name'] = "Name should not be empty";
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
    if (empty($Dateofbirth)) {
        $e['dateofbirth'] = "Date of Birth should not be empty";
    }if (empty($employee_id)) {
        $e['employeeid'] = "Employee NIC should not be empty";
    }

    //Name string validation

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
        $gender = substr($employee_id, 2, 3);
        $birthyr = substr($Dateofbirth, 2, 2);
        $check_v = substr($employee_id, 9);
        $idlength = strlen($employee_id);
        $nic_yr = substr($employee_id, 0, 2);

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
            $e['profile_image'] = "File is not an Image.";
            $uploadOK = 0;
        }

        if (file_exists($target_file)) {
            $e['profile_image'] = "Sorry File Already Exists.";
            $uploadOK = 0;
        }
        if ($_FILES["profile_image"]["size"] > 5000000) {
            $e['profile_image'] = "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['profile_image'] = "Sorry, Only JPG,JPeG,PNG,pdf & GIF are Allowed";
            $uploadOK = 0;
        }
        if ($uploadOK == 0) {
            // $e['profile_image']="Sorry, Your File Was not Upload.";
        } else {
            if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {
                $profile_image = basename($_FILES["profile_image"]["name"]);
            } else {
                $e['profile_image'] = "Sorry,there was an error uploading your file.";
            }
        }
    }

    //Update Data Into Database
    if (empty($e)) {
        $sql = "UPDATE `tb_employee` SET `title`='$title',`full_name`='$full_name',`email`='$email',`telephone`='$telephone',`address`='$address', `employee_nic`='$employee_id',`birth_date`='$Dateofbirth', `profile_image`='$profile_image'WHERE user_id='$user_id'";
        $r = $conn->query($sql);
        if ($r === TRUE) {
            //echo 'SUCCESS';
        } else {
            echo "Data Update Failed:" . $conn->error;
        }
    }
}

//Load data into form fields from database
if (isset($_GET['user_id'])) {         //(edit button eka click kalama url eka haraha ewana value eka[user_id]) 
    $user_id = clean_data($_GET['user_id']);
}
if (!empty($user_id)) {
    $sql = "SELECT * FROM tb_employee WHERE user_id='$user_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $user_id = $row['user_id'];
            $title = $row['title'];
            $full_name = $row['full_name'];
            $email = $row['email'];
            $telephone = $row['telephone'];
            $address = $row['address'];
            $user_type = $row['user_type'];
            $profile_image = $row['profile_image'];
            $employee_id = $row['employee_nic'];
            $Dateofbirth = $row['birth_date'];
        }
    }
}
?>

<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                Edit User Account
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
                        <input type="text" class="form-control" id="employeeid" name="employeeid" placeholder="Employee NIC"
                               value="<?php echo "$employee_id"; ?>">
                        <div class="text-danger"><?php echo @$e['employeeid']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="bd">Date of Birth</label>
                        <input type="date" class="form-control" name="dateofbirth" 
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
                               value="<?php echo "$address"; ?>">
                        <div class="text-danger"><?php echo @$e['address']; ?></div>
                    </div>

                    <div class="form-group">
                        <label for="user_type">User Type</label>
                        <select id="inputState" class="form-control" name="user_type">      
                            <option value="Manager" <?php if ($user_type == 'Manager') { ?> selected<?php } ?>>Manager
                            </option>
                            <option value="Cashier" <?php if ($user_type == 'Cashier') { ?> selected <?php } ?>>Cashier
                            </option>
                            <option value="Chef" <?php if ($user_type == 'Chef') { ?> selected <?php } ?>>Chef</option>
                            <option value="Waitor" <?php if ($user_type == 'Waitor') { ?> selected <?php } ?>>Waitor
                            </option>
                            <option value="Dilivery Person" <?php if ($user_type == 'Dilivery Person') { ?> selected <?php } ?>>Dilivery Person</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="profile_image">Profile Image</label>
                        <input type="file" class="form-control" id="profile_image" name="profile_image"
                               placeholder="Select Profile Image">
                        <div class="text-danger"><?php echo @$e['profile_image']; ?></div>
                    </div>

                </div>

                <div class="card-footer">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                    <button type="submit" name="operate" value="update" class="btn btn-primary">Update
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
                                   class="btn btn-primary"><i class="fas fa-user-edit"></i></td>
                            <td>
                                <?php if ($row['status'] != 2) { ?> 
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