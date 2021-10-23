<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';


if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "reset") {
    $email = null;
    $e = array();

    $email = clean_data($_POST['email']);

    if (empty($email)) {
        $e['email'] = "Email Can't be Empty";
    }

    //Email Validation
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "Invalid Email Address";
        }
    }

    if (!empty($email)) {
        $sql_e = "SELECT * FROM `tb_customers` WHERE `email`='$email'";
        $result_e = $conn->query($sql_e);
        $row_e = $result_e->fetch_assoc();
        $customer_id = $row_e['customer_id'];
        if ($result_e->num_rows > 0) {
            header("Location:email_verifyed.php?customer_id=$customer_id");
        } else {
            $e['email'] = "Please Register with us, Invalid Email Address";
        }
    }
}
?>



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


        <!-- Page Content -->
        <div class="row container-fluid">

            <img src="../Upload/cute-panda-forgot-password.jpg" alt="" style="width: 50%;"/>


            <div class="card w-50 border-0" >
                <div class="card-body" style="margin-top: 10%">
                    <h5 class="card-title  center-cart">Verify Your Email</h5>
                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" novalidate="">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Email address</label>
                            <input type="email" class="form-control" name="email" placeholder="Enter email" value="<?php echo @$email; ?>">
                            <div class="text-danger"><?php echo @$e['email']; ?></div>
                        </div>
                        <div class="form-group col">
                            <button type="submit" class="btn btn-primary col" name="operate" value="reset">Send Verification Email</button>
                        </div>
                    </form>
                </div>
            </div>


        </div>
        <!-- /.container -->

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>




