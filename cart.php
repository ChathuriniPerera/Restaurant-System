<?php
//Include Database Connection
include 'conn.php';

//Include config Connection
include 'config.php';

//cartstep1
session_start();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['action']) && $_POST['action'] == "change") {
    foreach ($_SESSION['shopping_cart'] as &$value) {

        if ($value['item_id'] === $_POST['item_id']) {
//            print_r($value);

            $value['quantity'] = $_POST['quantity'];
            echo '<br>';

            break; //stop the loop after we've found the product       
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['action']) && $_POST['action'] == "remove") {
    if (!empty($_SESSION["shopping_cart"])) {
        foreach ($_SESSION["shopping_cart"] as $key => $value) {
            if ($_POST['item_id'] == $key) {
                unset($_SESSION["shopping_cart"][$key]);
                $status = "<div class='alert alert-danger'>Product is removed from your cart!</div>";
            }
            if (empty($_SESSION["shopping_cart"])) {
                unset($_SESSION["shopping_cart"]);
            }
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['checkout']) && $_POST['checkout'] == "checkout") {
    if (isset($_SESSION['customer_id'])) {
        header("Location:customer_web/delivery_details.php");
    } else {
        header("Location:customer_web/customerlogin.php");
    }
}
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

        <style>
            .carousel-inner img {
                width: 100%;
                height: 91.55vh;
            }
        </style>
    </head>

    <body>

        <!-- Navigation -->
        <?php
        include 'customer_web/webnav.php';
        ?>

        <!-- Page Content -->
        <div class="container" style="margin-top: 70px;">

            <?php if (empty($_SESSION["shopping_cart"])) { ?>
                <img src="Upload/emptycart.png"  class="center-cart" alt=""/>
            <?php }
            ?>

            <?php
            if (!empty($_SESSION["shopping_cart"])) {

                $cart_count = count(array_keys($_SESSION["shopping_cart"]));
                ?>
                Your Cart <?php
                echo $cart_count;
            }
            ?>
            <?php
            if (isset($_SESSION["shopping_cart"])) {
//            print_r($_SESSION["shopping_cart"]);
                $total_price = 0;
                ?>
                <table class="table" >
                    <thead>
                    <td></td>
                    <td>ITEM NAME</td>
                    <td>QUANTITY</td>
                    <td>UNITE PRICE</td>
                    <td>ITEMS TOTAL</td>
                    </thead>

                    <tbody >
                        <?php
                        foreach ($_SESSION["shopping_cart"] as $product) {
                            ?>
                            <tr>
                                <td><img src="img/<?php echo $product['item_image']; ?> " width="50" height="40"/></td>
                                <td><?php echo $product['item_name']; ?></td>
                                <td>
                                    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">                 
                                        <!--                                to recognize which product-->
                                        <input type="hidden" name="item_id" value="<?php echo $product["item_id"]; ?>" />
                                        <!--                                to check does anything submitting in form-->
                                        <input type="hidden" name="action" value="change" />

                                        <select name="quantity" id="quantity" onchange="this.form.submit()">                                  
                                            <option <?php if ($product["quantity"] == 1) echo "selected"; ?> value="1" >1</option>
                                            <option <?php if ($product["quantity"] == 2) echo "selected"; ?> value="2" >2</option>
                                            <option <?php if ($product["quantity"] == 3) echo "selected"; ?> value="3" >3</option>
                                            <option <?php if ($product["quantity"] == 4) echo "selected"; ?> value="4" >4</option>
                                            <option <?php if ($product["quantity"] == 5) echo "selected"; ?> value="5" >5</option>
                                        </select>                             
                                    </form>
                                </td>
                                <td><?php echo "Rs." . $product["price"]; ?></td>
                                <td><?php echo "Rs." . $product["price"] * $product["quantity"]; ?></td>
                                <td>
                                    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post">
                                        <input  type="hidden" name="item_id" value="<?php echo $product["item_id"]; ?>"/>
                                        <input type="hidden" name="action" value="remove"/>
                                        <button type="submit" class="btn btn-outline-danger"><i class="far fa-trash-alt"></i></button>
                                    </form>  
                                </td>
                            </tr> 
                            <?php
                            $total_price += ($product["price"] * $product["quantity"]);
                        }
                        ?>
                        <tr>
                            <td colspan="5" align="right">
                                <strong>Total: <?php echo 'Rs. ' . number_format($total_price, 2); ?></strong>
                            </td>         
                        </tr>
                        <tr>
                            <td colspan="5"class="col" >
                                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                                    <button type="submit" class="col btn btn-outline-danger" name="checkout" value="checkout" >Proceed to Checkout</button>         
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
        <!-- /.container -->

        <!-- Footer -->
        <footer class="bg-dark">
            <?php
            include 'customer_web/webfooter.php';
            ?>
        </footer>

        <script>
            var i = 0;
            var txt = 'Lorem ipsum dummy text blabla.';
            var speed = 50000000000;

            function typeWriter() {
                if (i < txt.length) {
                    document.getElementById("demo").innerHTML += txt.charAt(i);
                    i++;
                    setTimeout(typeWriter, speed);
                }
            }
        </script>

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>