<?php session_start(); ?>
<?php include 'config.php'; ?>
<?php
if(!isset($_SESSION['user_id'])){
    header('Location:'.SITE_URL.'login.php');
}
?>

<?php include 'helper.php'; ?>
<?php include 'conn.php'; ?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon </title>
            <link  rel="shortcut icon" type="image/png" href="<?php echo SITE_URL; ?>/img/meal.png">
       
        <!-- Custom fonts for this template-->
        <link href="<?php echo SITE_URL; ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="<?php echo SITE_URL; ?>/css/mystylesheet.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template-->
        <link href="<?php echo SITE_URL; ?>/css/sb-admin-2.min.css" rel="stylesheet">

    </head>

    <body id="page-top">

        <!-- Page Wrapper -->
        <div id="wrapper">