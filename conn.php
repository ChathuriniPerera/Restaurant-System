<?php

$servername="localhost";
$username="root";
$password="";
$dbname="db_ceylon";

$conn= new mysqli($servername,$username,$password,$dbname);

if($conn->connect_error){
    die("Connection Failed : ".$conn_error);
}


?>
