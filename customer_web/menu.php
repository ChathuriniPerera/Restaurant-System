<?php
//Include config Connection
include '../config.php';

//Include Database Connection
include '../conn.php';

//cartstep1
session_start();

//cartstep3
$status = $description = $item_name = $item_id = $price = $item_image = null;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['item_id']) && $_POST['item_id'] != "") {

    $item_id = $_POST['item_id'];
    $sql = "SELECT * FROM `tb_menu` WHERE `item_id` = '$item_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $item_name = $row['item_name'];
            $description = $row['description'];
            $item_id = $row['item_id'];
            $price = $row['price'];
            $item_image = $row['item_image'];
        }
    }
    $cartArray = array(
        $item_id => array(
            'item_name' => $item_name,
            'item_id' => $item_id,
            'price' => $price,
            'quantity' => 1,
            'item_image' => $item_image)
    );

    if (empty($_SESSION["shopping_cart"])) {
        $_SESSION["shopping_cart"] = $cartArray;
        $status = "<div class='alert alert-danger'>Product is added to your cart!</div>";
    } else {
        $keys = array_keys($_SESSION["shopping_cart"]);
        if (in_array($item_id, $keys)) {
            $status = "<div class='alert alert-warning'>Product is already added to your cart!</div>";
        } else {
            $_SESSION["shopping_cart"] = $_SESSION["shopping_cart"] + $cartArray;
            $status = "<div class='box'>Product is added to your cart!</div>";
        }
    }
//    print_r($_SESSION["shopping_cart"]);
}
?>

<!DOCTYPE html>
<html lang="en">

    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Taste Of Ceylon Sri Lankan Foods-About</title>

        <!-- Bootstrap core CSS -->
        <link href="../web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template -->
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

    </head>

    <body class="col-sm-12">

        <?php
        include 'webnav.php';
        ?>

        <!-- Page Content -->

        <div class="jumbotron jumbotron-fluid ">
            <div class="container row">
                <div class="menu-company"> 
                    <h3 class="display-7 ">Taste Of Ceylon Sri Lanka</h3> 
                    <p class="lead">No 16, Galle Road, Kalamulla, Kaluthara </p>    
                </div>
                <div class="open-time"> 
                    <p class=""><div>
                        <div>
                            <?php
                            date_default_timezone_set("Asia/Colombo");
                            $current_time = strtotime(date("H:i"));
                            $close_time = strtotime('23:00');
                            $open_time = strtotime('09:00');
                            if ($current_time < $close_time && $current_time > $open_time) {
                                echo "Delivery is available until shop :" . "Open";
                            } else {
                                echo "Delivery is unavailable when shop :" . "Close";
                            }
                            $currentpage = $_SERVER['PHP_SELF'];
                            ?>
                        </div>                    </div></br>
                    </p>    
                </div>               
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div id="accordion">

                    <?php
                    //Cart step 4
                    if (!empty($_SESSION["shopping_cart"])) {
                        $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                        ?>
                        <a href="cart.php" ><i class="fas fa-cart-plus"></i> Your Cart [<span><?php echo $cart_count; ?>]</span></a>
                        <?php
                    }
                    ?>

                    <?php
                    //Cart step 2
                    $sql = "SELECT * FROM `tb_menu_category`";
                    $result_category = $conn->query($sql);
                    if ($result_category->num_rows > 0) {
                        while ($row_category = $result_category->fetch_assoc()) {
                            ?>  
                            <div class="card">
                                <div class="card-header" id="heading<?php echo $row_category['category_id']; ?>">
                                    <h2 class="mb-0">
                                        <button class = "btn btn-link btn-block text-left" type = "button" data-toggle = "collapse" data-target = "#category<?php echo $row_category['category_id'] ?>" aria-expanded = "true" aria-controls = "category<?php echo $row_category['category_id'] ?>">
                                            <?php echo $row_category['category']; ?>
                                        </button>
                                    </h2>
                                </div>

                                <div id="category<?php echo $row_category['category_id']; ?>" class="collapse" aria-labelledby="heading<?php echo $row_category['category_id'] ?>" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="card-group">
                                            <?php
                                            $sql_item = "SELECT * FROM `tb_menu` WHERE category_id='" . $row_category['category_id'] . "'";
                                            $result_item = $conn->query($sql_item);
                                            if ($result_item->num_rows > 0) {
                                                while ($row_item = $result_item->fetch_assoc()) {
                                                    $availability = $row_item['availability'];
                                                    ?>                                       
                                                    <div class="col-md-3">
                                                        <div class="card">
                                                            <img src="<?php echo SITE_URL; ?>/img/<?php echo $row_item['item_image']; ?>" class="card-img-top" alt="...">
                                                            <div class="card-body">
                                                                <h5 class="card-title"><?php echo $row_item['item_name']; ?></h5>
                                                                <p class="card-text"><?php echo $row_item['description']; ?>.</p>
                                                                <p class="card-text">Price : <?php echo "Rs. " . $row_item['price'] . "/="; ?></p>
                                                                <div>
                                                                    <form method='post' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>'>
                                                                        <input type='hidden' name='item_id' value="<?php echo $row_item['item_id']; ?>" />
                                                                        <?php if ($availability == 1) { ?>
                                                                            <button type='submit' class='col btn btn-outline-light'><img src="../icon/shopping-cart.png" alt="" class="align-right"></button>
                                                                        <?php } else{ ?> <div class="text-danger">OUT OF STOCK</div> <?PHP }?> 
                                                                    </form>
                                                                </div>
                                                            </div>                                                                                                                  
                                                        </div>
                                                    </div>
                                                    <?php
                                                }
                                            }
                                            ?>
                                            <?php
                                            //Cartstep 5 
                                            //echo $status;
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class="bg-dark">
            <?php
            include 'webfooter.php';
            ?>
        </footer>

        <!--         Bootstrap core JavaScript -->
        <script src="../web_template/jquery/jquery.min.js"></script>
        <script src="../web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>
