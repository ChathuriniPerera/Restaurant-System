<?php
//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';
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

        <!-- Navigation -->
        <?php
        include 'webnav.php';
        ?>

        <!-- Page Content -->

        <div class="container-fluid col-sm-6">
            <div class="text-center contact-pg">
                <h4 class="card-title">Taste Of Ceylon Sri Lanka</h4>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="card-body">
                            <h5 class="card-title">Opening Hours</h5>
                            <?php
                            $sql = "SELECT * FROM `tb_calender`";
                            $result = $conn->query($sql);
                            $result->num_rows;
                            ?>
                            <table class="table table-sm table-borderless table-hover" >

                                <tbody>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        while ($row = $result->fetch_assoc()) {
                                            ?>
                                            <tr>
                                                <td><?php echo $row['day']; ?></td>
                                                <td><?php echo $row['open_time'] . "-" . $row['close_time']; ?></td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>                      
                    </div>
                    <div class="col-sm-6">                       
                        <div class="card-body text-left">
                            <h5 class="card-title">Contact</h5>                                
                            <?php
                            $csql_tb = "SELECT * FROM `tb_contact`";
                            $cresult_tb = $conn->query($csql_tb);
                            $cresult_tb->num_rows;
                            if ($cresult_tb->num_rows > 0) {
                                while ($crow = $cresult_tb->fetch_assoc()) {
//                                print_r($crow);
                                    ?>
                                    <h6 class="card-title">Address</h6>
                                    <p class="card-text" value="<?php echo $crow['id'] ?>"><?php echo $crow['address'] ?></p>
                                    <h6 class="card-title">Phone Number</h6>
                                    <p class="card-text" value="<?php echo $crow['id'] ?>"><?php echo $crow['telephone'] ?></p>
                                    <h6 class="card-title">Email</h6>
                                    <p class="card-text" value="<?php echo $crow['id'] ?>"><?php echo $crow['email'] ?></p>
                                    <a type="button" class="btn btn-outline-danger" href="menu.php">Order Now</a>
                                    <?php
                                }
                            }
                            ?>
                        </div>                       
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
          <footer class="bg-dark">
            <?php
            include 'webfooter.php';
            ?>
        </footer>

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>