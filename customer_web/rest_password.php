<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';
?>

<?php
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
}
?>

<?php
$c_id = $new_password = $confirm_password = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "reset") {
    echo $c_id = clean_data($_POST['customer_id']);
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
            header("Location:customerlogin.php");
        } else {
            echo "Data Update Failed:" . $conn->error;
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


        <!-- Page Content -->

        <div class="card " style="margin-top: 10px">

            <div class="card-body">
                <div class="row">
                    <img src="../Upload/security-concept.jpg" alt="" width="40%"/>
                    <div class="col-6">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Reset Password</h5>
                                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                                    <div class="form-group col-md-12">
                                        <label for="password">New Password</label>
                                        <input type="password" class="form-control" name="new_password">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="password">Confirm Password</label>
                                        <input type="password" class="form-control" name="confirm_password">
                                    </div>
                                    <input type="hidden" name="customer_id" id="customer_id" value="<?php echo @$customer_id; ?>">
                                    <button type="submit" class="btn btn-outline-success col-md-12" name="operate" value="reset"> Reset Password </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>

