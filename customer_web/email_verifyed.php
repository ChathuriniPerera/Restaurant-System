<?php
//Include Database Connection
include '../conn.php';

//Include helper Connection
include '../helper.php';

//Include config Connection
include '../config.php';

include '../email/mail.php';
?>

<?php
if (isset($_GET['customer_id'])) {
    $customer_id = $_GET['customer_id'];
    $sql = "SELECT * FROM `tb_customers` WHERE customer_id = '$customer_id'";
//    print_r($sql);
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contact_name = $row['first_name'] . " " . $row['last_name'];
            $phone_number = $row['phone_number'];
            $email = $row['email'];
            $delivery_address = $row['address'];
        }
    }

    $body = null;
    $customer_id = ($customer_id);
    $to = $email;
    $toname = $contact_name;
    $subject = "Reset Password";
    $body .= "<h1>Welcome $contact_name</h1>";
    $body .= "<h3>Click on Below link to Reset Password</h3>";
    $body .= "<a href='http://localhost/tocadmin/customer_web/rest_password.php?customer_id=$customer_id'>CONFIRM EMAIL</a>";
    $body .= "<h4> For Further Information Please Contact Us </h4>";
    $body .= "<h4> Phone Number : +94342265770</h4>";

    send_email($to, $toname, $subject, $body);
}//else part eken error page load karanna
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
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

        <!--Google Fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Hind:wght@300;500&display=swap" rel="stylesheet">

    </head>

    <body>

        <!-- Page Content -->
        <div class="container-fluid" >
            <img src="../Upload/mail-sent-concept.jpg" alt="" width="45%" style="margin-left: 300px"/>
            <span class="top-middle text-dark" style="margin-top: -5%">Password Reset Verification Email has Mail to You</span>
            <span class="top-middle text-dark" style="margin-top: 350px">Thank You</span>
        </div>

        <!-- /.container -->

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>

