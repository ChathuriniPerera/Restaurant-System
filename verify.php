<?php session_start(); ?>
<?php include "config.php"; ?>
<?php include 'conn.php'; ?>
<?php include 'helper.php'; ?>

<?php include 'email/mail.php'; ?>

<?php //echo $_GET['code']; ?>

<div class="card">
    <div class="card-body">
        <div class="card mt-4" >
            <p></p>
            <p align="center"><img src="img/login.png" width="10%" alt="..." ></p>
            <p align="center" style="color:#004085; font-size:30px;">Your Account has been Successfully Activated...!</p>
            <p align="center" style="color:#10707f; font-size:20px;">Welcome to LIve Lanka Tours. Please click the following link and log-in to your account.</p>
            <p align="center"><?php
// echo $_GET['user_id'];




if (isset($_GET['user_id'])) {
    //$con = new mysqli("localhost" , "databaseuers" , "databasepassword" , "databasename");
    $query = "update user set status='1' where sha1(user_id)='" . $_GET['user_id'] . "';";
    if ($conn && $conn->query($query))
        echo '<span><br><button><a href="http://localhost/llt/email-verification/LoginORRegister.php">Log-in Now</a></button></span>';
    $conn->close();
}
?></p>

            <p></p>
        </div>
    </div>
</div>