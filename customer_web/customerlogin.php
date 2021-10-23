<?php
session_start();
ob_start();

//Include config Connection
include '../helper.php';

//Include config Connection
include '../config.php';

//Include Database Connection
include '../conn.php';

//Customer Log In
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "login") {
    $log_email = $log_password = null;
    $e = array();

    $log_email = clean_data($_POST['log_email']);
    $log_password = clean_data($_POST['log_password']);

    //empty validation
    if (empty($log_email)) {
        $e['log_email'] = "Email should not be empty..!";
    }
    if (empty($log_password)) {
        $e['log_password'] = "Password should not be empty..!";
    }
    //end empty validation
    //Email Validation

    if (!empty($log_email)) {
        if (!filter_var($log_email, FILTER_VALIDATE_EMAIL)) {
            $e['log_email'] = "Invalid Email Address";
        }
    }


    if (!empty($log_email)) {
        $sql = "SELECT * FROM `tb_customers` WHERE email='$log_email' AND status != '1'";
        $result = $conn->query($sql);
        if ($result->num_rows != 1) {
            $e['log_email'] = "Invalid Email...!";
        }
    }

    if (empty($e)) {

        $logsql = "SELECT * FROM `tb_customers` WHERE email='$log_email' AND password='" . sha1($log_password) . "'";
        $result = $conn->query($logsql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['customer_id'] = $row['customer_id'];
            }
            header("Location:../index.php");
        } else {
            $e['log_password'] = "Invalid Username or Password...!";
        }
    }
    //end-advance validation
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
        <div class="card cus_login" style="width: 30rem;" >
            <div class="card-header">
                <h4 class="text-center"><b>LET'S START YOUR ORDER</b></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        <div class="card text-center">
                            <h5><b>SIGN IN</b></h5>
                            <div class="card-body">
                                <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-user" id="log_email" placeholder="Enter Email..." name="log_email">
                                        <div class="text-danger"><?php echo @$e['log_email']; ?></div>
                                    </div>
                                    <div class="form-group">
                                        <input type="password" class="form-control form-control-user" id="log_password" placeholder="Password" name="log_password">
                                        <div class="text-danger"><?php echo @$e['log_password']; ?></div>
                                    </div>                                 
                                    <button type="submit" name="operate" value="login" class="btn btn-outline-danger btn-user btn-block">Login</button>
                                    <div class="form-group">
                                        <div class="custom-control">
                                            <a href="enter_email.php"><u>Forgotten  Password</u></a>
                                        </div>
                                    </div>
                                    <a type="button" class="btn btn-outline-primary" href="customer_register.php">Register with Us</a>
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

