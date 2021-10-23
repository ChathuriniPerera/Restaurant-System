<?php
session_start();
ob_start();

//Include config Connection
include '../helper.php';

//Include config Connection
include '../config.php';

//Include Database Connection
include '../conn.php';


//Customer Register 
$fisrt_name = $last_name = $phone_number = $email = $address = $reg_password = $confirm_password = null;

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "register") {

    $e = array();

    $fisrt_name = clean_data($_POST['first_name']);
    $last_name = clean_data($_POST['last_name']);
    $phone_number = clean_data($_POST['phone_number']);
    $email = clean_data($_POST['email']);
    $address = clean_data($_POST['address']);
    $reg_password = clean_data($_POST['reg_password']);
    $confirm_password = clean_data($_POST['confirm_password']);

    //empty validation
    if (empty($fisrt_name)) {
        $e['first_name'] = "First Name Shouldn't be Empty";
    }
    if (empty($last_name)) {
        $e['last_name'] = "Last Name Shouldn't be Empty";
    }
    if (empty($phone_number)) {
        $e['phone_number'] = "Phone Number Shouldn't be Empty";
    }
    if (empty($email)) {
        $e['email'] = "Email Shouldn't be Empty";
    }
    if (empty($address)) {
        $e['address'] = "Address Shouldn't be Empty";
    }
    if (empty($reg_password)) {
        $e['reg_password'] = "Password Shouldn't be Empty";
    }
    if (empty($confirm_password)) {
        $e['confirm_password'] = "Confirm Password Shouldn't be Empty";
    }

    //Telephone Number validattion

    if (!empty($telephone)) {
        $validtelephone = filter_var($telephone, FILTER_SANITIZE_NUMBER_INT);
        $validtelephone = str_replace("-", "", $validtelephone);
        if (strlen($validtelephone) == 10) {
            $e['telephone'] = $e['telephone'] . "Please Set the Country Code '+94' at the Begining";
        }

        if (strlen($validtelephone) != 12 && strlen($validtelephone) < 12) {
            $e['telephone'] = $e['telephone'] . "Invalid Phone Number";
        }

        if (strlen($validtelephone) == 12) {
            $phonecode = substr($validtelephone, 0, 3);
            if ($phonecode != +94) {
                
            }
        }
    }

    //Email Validation

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "Invalid Email Address";
        }
    }

    //password strength check validation
    if (!empty($reg_password)) {
        $passlength = strlen($reg_password);
        $uppercase = preg_match('@[A-Z]@', $reg_password);
        $number = preg_match('@[0-9]@', $reg_password);
        $specialChar = preg_match('@[^\w]@', $reg_password);

        if ($passlength < 8) {
            $e['reg_password'] = @$e['reg_password'] . "Password must be at least 8 characters in length." . "<br>";
        }
        if ($uppercase == 0) {
            $e['reg_password'] = @$e['reg_password'] . "Password must include at least one uppercase letter." . "<br>";
        }
        if ($number == 0) {
            $e['reg_password'] = @$e['reg_password'] . "Password must include at least one number." . "<br>";
        }
        if ($specialChar == 0) {
            $e['reg_password'] = @$e['reg_password'] . "Password must include at least one special chatacter.";
        }
    }

    //Confirm_password
    if (!empty($confirm_password)) {
        if ($confirm_password != $reg_password) {
            $e['confirm_password'] = "Password are not matched...";
        }
    }

    //Check alredy existing email and phone number
    $sql_check = "SELECT `email` , `phone_number` FROM `tb_customers`";
    $result_check = $conn->query($sql_check);
    if ($result_check->num_rows > 0) {
        while ($row = $result_check->fetch_assoc()) {
            $check_email = $row['email'];
            $check_phone = $row['phone_number'];
            if ($check_email == $email) {
                $e['email'] = "Email Address Already Exsisting";
            }
            if ($check_phone == $phone_number) {
                $e['phone_number'] = "Phone Number Already Exsisting";
            }
        }
    }

    //Insert Data Into Database
    if (empty($e)) {
        $sql_register = "INSERT INTO `tb_customers`(`first_name`, `last_name`, `phone_number`, `email`, `address`, `password`, `status`)
                                        VALUES ('$fisrt_name' , '$last_name' , '$phone_number' , '$email' , '$address', '" . sha1($reg_password) . "', '0')";
        $result_register = $conn->query($sql_register);
        if ($result_register === TRUE) {
            $customer_id = $conn->insert_id;
            $_SESSION['customer_id'] = $customer_id;
            echo "Data Insert";
            header("Location:delivery_details.php");
        } else {
            echo "Data Insert Failed:" . $conn->error;
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

        <title>Taste Of Ceylon Sri Lankan Foods-Services</title>

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
        <div class="card col-12" >
            <div class="card-header">
                <h4 class="text-center"><b>LET'S BECOME A MEMBER</b></h4>
            </div>
            <div class="card-body">                
                <a type="button" class="btn btn-outline-danger" href="customerlogin.php"><i class="far fa-hand-point-left"></i> Login</a>
                <div class="col">
                    <div class="card cus_register col-6">
                        <div class='card-header text-center'><h5>Customer Details Form</h5></div>
                        <div class="card-body">
                            <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                                <div class="form-row">
                                    <div class="form-group col-6">
                                        <label for="">First Name</label>
                                        <input type="text" class="form-control form-control-user" id="first_name" placeholder="First Name" name="first_name" value="<?php echo "$fisrt_name"; ?>">
                                        <div class="text-danger"><?php echo @$e['first_name']; ?></div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="">Last Name</label>
                                        <input type="text" class="form-control form-control-user" id="last_name" placeholder="Last Name" name="last_name" value="<?php echo "$last_name"; ?>">
                                        <div class="text-danger"><?php echo @$e['last_name']; ?></div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="">Phone Number</label>
                                    <input type="text" class="form-control form-control-user" id="phone_number" placeholder="Phone Number" name="phone_number" value="<?php echo "$phone_number"; ?>">
                                    <div class="text-danger"><?php echo @$e['phone_number']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Email address</label>
                                    <input type="email" class="form-control form-control-user" id="email" placeholder="Enter Email..." name="email" value="<?php echo "$email"; ?>">
                                    <div class="text-danger"><?php echo @$e['email']; ?></div>
                                </div>
                                <div class="form-group">
                                    <label for="">Address</label>
                                    <textarea type="text" class="form-control form-control-user" id="address" placeholder="Enter Street Address" name="address" value=""></textarea>
                                    <div class="text-danger"><?php echo @$e['']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label for="">Password</label>
                                        <input type="password" class="form-control form-control-user" id="reg_password" placeholder="Password" name="reg_password" value="<?php echo "$reg_password"; ?>">
                                        <div class="text-danger"><?php echo @$e['reg_password']; ?></div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="">Confirm Password</label>
                                        <input type="password" class="form-control form-control-user" id="confirm_password" placeholder="Re-Enter Password" name="confirm_password" value="<?php echo "$confirm_password"; ?>">
                                        <div class="text-danger"><?php echo @$e['confirm_password']; ?></div>
                                    </div>
                                </div>
                                <button type="submit" name="operate" value="register" class="btn btn-outline-danger btn-user btn-block">Register with Us</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-muted">

        </div>
    </div>
    <!-- /.container -->

    <!-- Bootstrap core JavaScript -->
    <script src="web_template/jquery/jquery.min.js"></script>
    <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

</body>

</html>
<?php
ob_end_flush();
?>

