<?php
//Include Database Connection
include 'conn.php';

//Include config Connection
include 'config.php';


//cartstep1
session_start();
?>
<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon Sri Lankan Foods</title>

        <!-- Bootstrap core CSS -->
        <link href="web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="css/mywebstyle.css" rel="stylesheet">

        <!--Google Fonts-->
        <link href="https://fonts.googleapis.com/css2?family=Parisienne&display=swap" rel="stylesheet">


    </head>

    <body >

        <?php
        include 'customer_web/webnav.php';
        ?>

        <!-- Page Content -->
        <div class="container-fluid">
            <!-- Heading Row -->
            <div class="row align-items-center">
                <div>
                    <?php
                    $sql = "SELECT * FROM tb_carousal";
                    $result = $conn->query($sql);
                    ?>
                    <div id="demo" class="carousel slide" data-ride="carousel">

                        <!-- Indicators -->
                        <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                            <li data-target="#demo" data-slide-to="1" onclick="test();"></li>
                          
                        </ul>

                        <!-- The slideshow -->
                        <div class="carousel-inner">
                            <?php if ($result->num_rows > 0) { ?>
                                <?php
                                $i = 0;
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <div class="carousel-item <?php if ($i == 0) { ?> active <?php } ?>">
                                        <img src="Upload/<?php echo $row['product_image'] ?>" alt="...">                                       
                                        <div class="carousel-caption">
                                            <div class="container">
                                                <h1 id="brand">Taste Of Ceylon</h1>
<!--                                                <p id="type-stye"><span class="typed-text"></span><span class="cursor">&nbsp;</span></p>-->
                                            </div>
                                        </div> 
                                    </div>
                                    <?php
                                    $i++;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container -->

        <!-- /.container -->



        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="js/dynamicweb.js" type="text/javascript"></script>
        <script>
                                function test() {
                                    type();
                                }
        </script>

    </body>

</html>