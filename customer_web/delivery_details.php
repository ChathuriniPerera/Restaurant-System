
<?php
//time zone set 
date_default_timezone_set("Asia/Colombo");

//Include Database Connection
include '../conn.php';

//Include config Connection
include '../config.php';

//Include config Connection
include '../helper.php';

//cartstep1
session_start();

$contact_name = $phone_number = $email = $date = $day = $time = $house_number = $street_address = $city = $payment_method = $total = $created = $check_discount = $current_time = $discount = $net_price = null;

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


if (isset($_SESSION['customer_id'])) {
    $customer_id = clean_data($_SESSION['customer_id']);
} else {
    header("Location:customerlogin.php");
}

if (!empty($customer_id)) {
    $sql = "SELECT * FROM `tb_customers` WHERE customer_id='$customer_id'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $customer_id = $row['customer_id'];
            $contact_name = $row['first_name'] . " " . $row['last_name'];
            $phone_number = $row['phone_number'];
            $email = $row['email'];
        }
    }
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "place_order") {

    $e = array();

    $contact_name = clean_data($_POST['contact_name']);
    $phone_number = clean_data($_POST['phone_number']);
    $email = clean_data($_POST['email']);
    $date = clean_data($_POST['delivery_date']);
    $day = date('l', strtotime($date));
    $time = clean_data($_POST['time']);
    $house_number = clean_data($_POST['house_name']);
    $street_address = clean_data($_POST['street_name']);
    $city = clean_data($_POST['city_name']);
    $total = clean_data($_SESSION['sub_total']);
    $created = date('Y-m-d h:i');
    $current_time = date('G:i', strtotime('+1 hours'));
    $discount = clean_data($_SESSION['discount']);
    $net_price = clean_data($_SESSION['net_price']);

    if (isset($_POST['pay_type'])) {
        $payment_method = $_POST['pay_type'];
    }

    //empty validation
    if (empty($contact_name)) {
        $e['contact_name'] = "Contact Name Shouldn't be Empty";
    }
    if (empty($payment_method)) {
        $e['pay_type'] = "Payment Method Shouldn't be Empty";
    }
    if (empty($phone_number)) {
        $e['phone_number'] = "Phone Number Shouldn't be Empty";
    }
    if (empty($email)) {
        $e['email'] = "Email Shouldn't be Empty";
    }
    if (empty($house_number)) {
        $e['house_name'] = "Delivery Address Shouldn't be Empty";
    }
    if (empty($street_address)) {
        $e['street_name'] = "Street Address Shouldn't be Empty";
    }
    if (empty($city)) {
        $e['city_name'] = "City Name Shouldn't be Empty";
    }
    if (empty($date)) {
        $e['delivery_date'] = "Date Shouldn't be Empty";
    }
    if (empty($time)) {
        $e['time'] = "Time Shouldn't be Empty";
    }

    //Check available delivery dates
    if (!empty($date)) {
        $sql_date = "SELECT * FROM `tb_holiday` WHERE date = '$date'";
        $result_date = $conn->query($sql_date);
        if ($result_date->num_rows == 1) {
            $e['delivery_date'] = "Taste of Ceylon on a holiday";
        }
    }

    if (!empty($date)) {
        $sql_mdate = "SELECT * FROM `tb_maintanance` WHERE date = '$date'";
        $result_mdate = $conn->query($sql_mdate);
        $row_m = $result_mdate->fetch_assoc();
        $mdate = $row_m['date'];
        $stime = $row_m['start_time'];
        $etime = $row_m['end_time'];
        if ($mdate >= 1) {
            if ($time > $stime && $time < $etime) {
                $e['time'] = "Taste of Ceylon under Maintanance on this time" . "</br>" . "Please select time before $stime or after $etime";
            }
        }
    }

    //Check available delivery times
    if (!empty($time) && !empty($day)) {
        $sql = "SELECT * FROM `tb_calender` WHERE '$time' BETWEEN `open_time` AND close_time AND day= '$day'";
        $timevalidate = $conn->query($sql);
        if ($timevalidate->num_rows <= 0) {
            $e['time'] = "Check our Opening hours from Contact Us page..";
        }
    }

    if (!empty($time) && !empty($date)) {
        if (($time <= $current_time ) && ($date == date('Y-m-d'))) {
            $e['time'] = "Order Sholud Place Beetween Minimum One Hour Duration";
        }
    }

    //Telephone Number validattion
    if (!empty($phone_number)) {
        $validtelephone = filter_var($phone_number, FILTER_SANITIZE_NUMBER_INT);
        $validtelephone = str_replace("-", "", $validtelephone);
        if (strlen($validtelephone) == 10) {
            $e['phone_number'] = "Please Set the Country Code '+94' at the Begining";
        }

        if (strlen($validtelephone) != 12 && strlen($validtelephone) < 12) {
            $e['phone_number'] = "Invalid Phone Number";
        }

        if (strlen($validtelephone) == 12) {
            $phonecode = substr($validtelephone, 0, 3);
            if ($phonecode != +94) {
                
            }
        }
    }

    //Email Validation

    if (!empty($email)) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $e['email'] = "Invalid Email Address";
        }
    }

//    print_r($_SESSION['shopping_cart']);
//    print_r($_SESSION['customer_id']);
//    print_r($_SESSION['total_price']);
    //Insert Order Details into databasediamond
    if (empty($e)) {

        $order = "INSERT INTO `tb_order`(`customer_id`, `contact_name`, `phone_number`, `email`, `delivery_date`, `time`, `house_number`, `street_address`, `city_name`, `pay_method`, `total_price`, `discount`, `net_total`, `created`)
                                VALUES ('$customer_id','$contact_name','$phone_number','$email','$date','$time', '$house_number', '$street_address', '$city', '$payment_method','$total', '$discount', '$net_price', '$created')";
        $result_order = $conn->query($order);
        if ($result_order === TRUE) {
            
        } else {
            echo "Data Insert Failed:" . $conn->error;
        }

        $sql_order_id = "SELECT MAX(`order_id`) AS order_id FROM `tb_order`";
        $result_id = $conn->query($sql_order_id);
        $row = $result_id->fetch_assoc();
        foreach ($_SESSION["shopping_cart"] as $items) {
            $item_price = $items["price"] * $items["quantity"];
            $order_item = "INSERT INTO `tb_order_item`(`order_id`, `item_id`, `quantity`, `unit_price`, `item_total`)
                    VALUES ('" . $row['order_id'] . "','" . $items['item_id'] . "','" . $items['quantity'] . "','" . $items['price'] . "','$item_price')";
            $result_items = $conn->query($order_item);
            if ($result_items === TRUE) {
                header("Location:order_success.php?order_id=$row[order_id]");
            } else {
                echo "Data Insert Failed:" . $conn->error;
            }
        }
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

        <title>Taste Of Ceylon Sri Lankan Foods-Services</title>

        <!-- Bootstrap core CSS -->
        <link href="../web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>

        <!-- Custom styles for this template -->
        <link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="../css/mywebstyle.css" rel="stylesheet" type="text/css"/>

        <!--Google Fonts-->
        <link href="https://fonts.googleapis.com/css2?family=Patrick+Hand&display=swap" rel="stylesheet">

    </head>

    <body>

        <!-- Navigation -->
        <?php
        include 'webnav.php';
        ?>

        <!-- Page Content -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="text-center"><b>LET'S CONFIRM YOUR ORDER</b></h4>
                        </div>
                        <div class="card-body">
                            <span style="color: brown"><i class="fas fa-clipboard-check"></i>  Please confirm all the details in below form are TRUE</span>
                            <form class="user" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" novalidate> 
                                <div class="form-group">
                                    <label ><b>Contact Name</b></label>
                                    <input type="text" class="form-control form-control-user" placeholder="Contact Name" name="contact_name" value="<?php echo $contact_name; ?>">
                                    <div class="text-danger"><?php echo @$e['contact_name']; ?></div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label ><b>Phone Number</b></label>
                                        <input type="text" class="form-control form-control-user" placeholder="Phone Number" name="phone_number" value="<?php echo $phone_number; ?>">                                      
                                        <div class="text-danger"><?php echo @$e['phone_number']; ?></div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label ><b>Email address</b></label>
                                        <input type="email" class="form-control form-control-user" placeholder="Email..." name="email" value="<?php echo $email; ?>">                                       
                                    </div>
                                    <div class="text-danger"><?php echo @$e['email']; ?></div>
                                </div>
                                <span style="color: brown"><i class="fas fa-exclamation"></i> Please Set Date and Time Correctly</span>
                                <div class="row">
                                    <div class="form-group col-6">
                                        <label ><b>Delivery Date</b></label>
                                        <input type="date" class="form-control form-control-user" name="delivery_date" min="<?php echo date('Y-m-d'); ?>" max="<?php echo date("Y-m-d", strtotime("30 days")); ?>" value="<?php echo $date; ?>">
                                        <div class="text-danger"><?php echo @$e['delivery_date']; ?></div>
                                    </div>
                                    <div class="form-group col-6">
                                        <label ><b>Time</b></label>
                                        <input type="time" class="form-control form-control-user" name="time" max="<?php echo date("h:i:sa"); ?>" value="<?php echo $time; ?>"> 
                                        <div class="text-danger"><?php echo @$e['time']; ?></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col"> 
                                        <label><b>Home Number Address</b></label>
                                        <input class="form-control" rows="3" name="house_name" placeholder="11-D," value="<?php echo $house_number; ?>">
                                        <div class="text-danger"><?php echo @$e['house_name']; ?></div>
                                    </div>
                                    <div class="form-group col">
                                        <label><b>Street Address</b></label>
                                        <input class="form-control" rows="3" name="street_name" placeholder="Street Name," value="<?php echo $street_address; ?>">
                                        <div class="text-danger"><?php echo @$e['street_name']; ?></div>
                                    </div>
                                    <div class="form-group col">
                                        <label><b>City Address</b></label>
                                        <select id="inputState" class="form-control" name="city_name" value="<?php echo $city; ?>">
                                            <option value="">---</option>
                                            <option value="Kalamulla South Katukurunda" <?php if ($city == 'Kalamulla South Katukurunda') { ?> selected<?php } ?>>Kalamulla South Katukurunda
                                            </option>
                                            <option value="Kalamulla North Katukurunda" <?php if ($city == 'Kalamulla North Katukurunda') { ?> selected <?php } ?>>Kalamulla North Katukurunda
                                            </option>
                                            <option value="Kalamulla East Katukurunda" <?php if ($city == 'Kalamulla East Katukurunda') { ?> selected <?php } ?>>Kalamulla East Katukurunda</option>
                                            <option value="Kalamulla Convent Katukurunda" <?php if ($city == 'Kalamulla Convent Katukurunda') { ?> selected <?php } ?>>Kalamulla Convent Katukurunda
                                            </option>
                                            <option value="Uswatta" <?php if ($city == 'Uswatta') { ?> selected <?php } ?>>Uswatta</option>
                                            <option value="Ethgama East" <?php if ($city == 'Ethgama East') { ?> selected <?php } ?>>Ethgama East
                                            </option>
                                        </select>
                                        <div class="text-danger"><?php echo @$e['city_name']; ?></div>
                                    </div>
                                </div>
                                <div class="row form-group">
                                    <label  class=" col-4"><B>Payment Method</b></label>
                                    <div class="form-check col-4">
                                        <input class="form-check-input" type="radio" name="pay_type" id="cash" value="Cash Payment">
                                        <label class="form-check-label" for="">
                                            Cash On Delivery
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="pay_type" id="card" value="Card Payment">
                                        <label class="form-check-label" for="">
                                            Card Payment
                                        </label>
                                    </div>
                                    <div class="text-danger"><?php echo @$e['pay_type']; ?></div>
                                </div>
                                <span style="color: brown"><i class="fas fa-asterisk"></i> Make Sure About Delivery Date & Time</span>
                                <button type="submit button" name="operate" value="place_order" class="btn btn-outline-danger btn-user btn-block" data-toggle="tooltip" data-placement="bottom" title="All the Orders will Deliver within 40 Minutes After Confirmation">Confirm and Place Order</button>
                            </form>
                        </div>
                        <div class="card-footer text-muted">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="container" style="margin-top:60px;">
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
                                            <td><img src="../img/<?php echo $product['item_image']; ?> " width="50" height="40"/></td>
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
                                        </tr> 
                                        <?php
                                        $total_price += ($product["price"] * $product["quantity"]);
                                        $_SESSION['sub_total'] = $total_price;
                                    }
                                    ?>
                                    <tr>
                                        <td colspan="5" align="right">
                                            <strong>Total: <?php echo 'Rs. ' . number_format($total_price, 2); ?></strong>
                                        </td>         
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right">
                                            <?php
                                            $check_discount = date('F');
                                            $sql_discount = "SELECT * FROM `tb_discount` WHERE month = '$check_discount'";
                                            $result_discount = $conn->query($sql_discount);
                                            $row_discount = $result_discount->fetch_assoc();
                                            $discount = $row_discount['discount'];
                                            $discount = $total_price * ($discount / 100);
                                            $_SESSION['discount'] = $discount;
                                            ?>
                                            <strong>Discount: <?php echo 'Rs. ' . number_format($discount, 2); ?></strong>
                                        </td>         
                                    </tr>
                                    <tr>
                                        <td colspan="5" align="right">
                                            <?php
                                            $net_price = $total_price - $discount;
                                            $_SESSION['net_price'] = $net_price;
                                            ?>
                                            <strong>Payable Amount: <?php echo 'Rs. ' . number_format($net_price, 2); ?></strong>
                                        </td>         
                                    </tr>
                                </tbody>
                            </table>
                            <?php
                        }
                        ?>
                    </div>
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

        <!-- Bootstrap core JavaScript -->
        <script src="web_template/jquery/jquery.min.js"></script>
        <script src="web_template/bootstrap/js/bootstrap.bundle.min.js"></script>

    </body>

</html>