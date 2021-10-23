<?php
include 'email/mail.php';

$to="chathuisha1994@gmail.com";
$to_name="Miss.Ishadi";

$subject="Verification of Your Registration";
$body="<h1 style='color:green'>Welcome to SMART IT</h1>";
$body.="<p>To verify your registration click on the below link</p>";
$body.="<p><a href='http://localhost/liveLankaTours/verify.php?code=234567'>VERIFY</a></p>";

send_email($to,$to_name,$subject,$body);

