<?php
//session start
session_start();
//include helper page
include 'helper.php';
//include database connection
include 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $email = $password = null;
    $e = array();

    $email = clean_data($_POST['email']);
    $password = clean_data($_POST['password']);

    //empty validation
    if (empty($email)) {
        $e['email'] = "Email should not be empty..!";
    }
    if (empty($password)) {
        $e['password'] = "Password should not be empty..!";
    }
    //end-empty validation
    
    //advance validation
    
    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "Invalid Email Address";
        }
    }
    
    if (!empty($email)) {
        $sql = "SELECT * FROM `tb_employee` WHERE email='$email' AND status != 2";
        $result = $conn->query($sql);
        if ($result->num_rows != 1) {
            $e['email'] = "Invalid Email...!";
        }
    }
    if (empty($e)) {
        $sql = "SELECT * FROM tb_employee WHERE email='$email' AND password='" . sha1($password) . "'";
        $result = $conn->query($sql);
        if ($result->num_rows == 1) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['title'] = $row['title'];
                $_SESSION['full_name'] = $row['full_name'];
                $_SESSION['profile_img'] = $row['profile_image'];
                $_SESSION['user_id'] = $row['user_id'];
            }
            header('Location:dashboard.php');
        } else {
            $e['password'] = "Invalid Username or Password...!";
        }
    }
    //end-advance validation
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon-Login</title>

        <!-- Custom fonts for this template-->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

        <!-- Custom styles for this template-->
        <link href="css/sb-admin-2.min.css" rel="stylesheet">
        <link href="css/mystylesheet.css" rel="stylesheet" type="text/css"/>
    </head>

    <body class="bg-gradient-primary">

        <div class="container">

            <!-- Outer Row -->
            <div class="row justify-content-center">

                <div class="col-xl-10 col-lg-12 col-md-9">

                    <div class="card o-hidden border-0 shadow-lg my-5">
                        <div class="card-body p-0">
                            <!-- Nested Row within Card Body -->
                            <div class="row">
                                <div class="col-lg-6 d-none d-lg-block bg-login-image"></div> 
                                <div class="col-lg-6">
                                    <div class="p-5">
                                        <div class="text-center">
                                            <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                        </div>
                                        <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" >
                                            <div class="form-group">
                                                <input type="text" class="form-control form-control-user" id="email" placeholder="Enter Email..." name="email">
                                                <div class="text-danger"><?php echo @$e['email']; ?></div>
                                            </div>
                                            <div class="form-group">
                                                <input type="password" class="form-control form-control-user" id="password" placeholder="Password" name="password">
                                                <div class="text-danger"><?php echo @$e['password']; ?></div>
                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        </div>

        <!-- Bootstrap core JavaScript-->
        <script src="vendor/jquery/jquery.min.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="js/sb-admin-2.min.js"></script>

    </body>

</html>
