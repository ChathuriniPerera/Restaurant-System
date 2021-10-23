<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';

session_start();
?>

<?php
$cus_id = $fname = $lname = $paddress = $pnumber = $pemail = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "update") {

    $cus_id = clean_data($_POST['customer_id']);
    $fname = clean_data($_POST['fname']);
    $lname = clean_data($_POST['lname']);
    $paddress = clean_data($_POST['address']);
    $pnumber = clean_data($_POST['pnumber']);
    $pemail = clean_data($_POST['email']);

    if (empty($fname)) {
        $e['fname'] = "First Name Shouldn't be Empty";
    }

    if (empty($lname)) {
        $e['lname'] = "Last Name Shouldn't be Empty";
    }

    if (empty($paddress)) {
        $e['address'] = "Address Shouldn't be Empty";
    }

    if (empty($pnumber)) {
        $e['pnumber'] = "Phone Number Shouldn't be Empty";
    }

    if (empty($pemail)) {
        $e['email'] = "Email Shouldn't be Empty";
    }

    //Telephone Number validattion

    if (!empty($pnumber)) {
        $validtelephone = filter_var($pnumber, FILTER_SANITIZE_NUMBER_INT);
        $validtelephone = str_replace("-", "", $validtelephone);
        if (strlen($validtelephone) == 10) {
            $e['pnumber'] = $e['pnumber'] . "Please Set the Country Code '+94' at the Begining";
        }

        if (strlen($validtelephone) != 12 && strlen($validtelephone) < 12) {
            $e['pnumber'] = $e['pnumber'] . "Invalid Phone Number";
        }

        if (strlen($validtelephone) == 12) {
            $phonecode = substr($validtelephone, 0, 3);
            if ($phonecode != +94) {
                
            }
        }
    }

    //Email Validation

    if (!empty($pemail)) {
        if (!filter_var($pemail, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "Invalid Email Address";
        }
    }

    //Update Data Into Database
    if (empty($e)) {
        $psql = "UPDATE `tb_customers` SET `first_name`='$fname', `last_name`='$lname', `phone_number`='$pnumber', `email`='$pemail', `address`='$paddress' WHERE `customer_id`='$cus_id'";
        $presults = $conn->query($psql);
        if ($presults === TRUE) {
//            echo 'SUCCESS';
        } else {
            echo "Data Update Failed:" . $conn->error;
        }
    }
}
?>

<?php
$c_id = $new_password = $confirm_password = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "reset") {
    $c_id = clean_data($_POST['customer_id']);
    $new_password = clean_data($_POST['new_password']);
    $confirm_password = clean_data($_POST['confirm_password']);

    if (empty($new_password)) {
        $e['new_password'] = "Password should not be empty";
    }
    if (empty($confirm_password)) {
        $e['confirm_password'] = "Password should not be empty";
    }

    //password strength check
    if (!empty($new_password)) {
        $passlength = strlen($new_password);
        $uppercase = preg_match('@[A-Z]@', $new_password);
        $number = preg_match('@[0-9]@', $new_password);
        $specialChar = preg_match('@[^\w]@', $new_password);

        if ($passlength < 8) {
            $e['new_password'] = @$e['new_password'] . "Password must be at least 8 characters in length." . "<br>";
        }
        if ($uppercase == 0) {
            $e['new_password'] = @$e['new_password'] . "Password must include at least one uppercase letter." . "<br>";
        }
        if ($number == 0) {
            $e['new_password'] = @$e['new_password'] . "Password must include at least one number." . "<br>";
        }
        if ($specialChar == 0) {
            $e['new_password'] = @$e['new_password'] . "Password must include at least one special chatacter.";
        }
    }

    //Confirm_password
    if (!empty($confirm_password)) {
        if ($confirm_password != $new_password) {
            $e['confirm_password'] = "Password is not matched.";
        }
    }

    //Update Data Into Database
    if (empty($e)) {
        $sql = "UPDATE `tb_customers` SET `password`='" . sha1($new_password) . "' WHERE `customer_id`= '$c_id'";
        $r = $conn->query($sql);
        if ($r === TRUE) {
//            echo 'Success';
        } else {
            echo "Data Update Failed:" . $conn->error;
        }
    }
}
?>

<?php
if (isset($_SESSION['customer_id'])) {
    $customer_id = clean_data($_SESSION['customer_id']);
} else {
    header("Location:customerlogin.php");
}

if (!empty($customer_id)) {
    $sql = "SELECT * FROM `tb_customers` WHERE customer_id='$customer_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
//            echo $customer_id = $row['customer_id'];
            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $phone_number = $row['phone_number'];
            $email = $row['email'];
            $address = $row['address'];
            $password = $row['password'];
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon Sri Lankan Foods-Contact</title>

        <!-- Bootstrap core CSS -->
        <link href="../web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template -->
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

    </head>

    <body>

        <!-- Navigation -->
        <?php
        include 'webnav.php';
        ?>

        <!-- Page Content -->

        <div class="card " style="margin-top: 10px">
            <h5 class="card-header text-center">PROFILE DETAILS</h5>
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Contact Information</h5>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="fname">First Name</label>
                                            <input type="text" class="form-control" name="fname" value="<?php echo $first_name; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="lname">Last Name</label>
                                            <input type="text" class="form-control" name="lname" value="<?php echo $last_name; ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="address">Address</label>
                                        <input type="text" class="form-control" name="address" value="<?php echo $address; ?>">
                                    </div>                       
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label for="fname">Phone Number</label>
                                            <input type="text" class="form-control" name="pnumber" value="<?php echo $phone_number; ?>">
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label for="email">Email</label>
                                            <input type="text" class="form-control" name="email" value="<?php echo $email; ?>">
                                        </div>
                                    </div>
                                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">
                                    <button type="submit" class="btn btn-outline-success col-md-12" name="operate" value="update" >Save Profile Details</button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reset Password</h5>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group col-md-12">
                                        <label for="password">Current Password</label>
                                        <input type="password" class="form-control" name="password" value="<?php echo $password; ?>">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id; ?>">
                                    <button type="submit" class="btn btn-outline-success col-md-12" name="operate" value="reset"> Reset Password </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-dark">
            <?php
            include 'webfooter.php';
            ?>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>

