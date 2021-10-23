<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Include Database Connection
include '../conn.php';
?>

<?php
$res_address = $res_phone = $res_email = null;
$e = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == 'update-contact') {
    $res_address = clean_data($_POST['res_addres']);
    $res_phone = clean_data($_POST['res_phone']);
    $res_email = clean_data($_POST['res_email']);

    if (empty($res_address)) {
        $e['res_addres'] = "Restaurant Address Shoudn't Be Empty";
    }
    if (empty($res_phone)) {
        $e['res_phone'] = "Restaurant Phone Shoudn't Be Empty";
    }
    if (empty($res_email)) {
        $e['$res_email'] = "Restaurant Email Shoudn't Be Empty";
    }

    //Telephone Number validattion

    if (!empty($res_phone)) {
        $validtelephone = filter_var($res_phone, FILTER_SANITIZE_NUMBER_INT);
        $validtelephone = str_replace("-", "", $validtelephone);
        if (strlen($validtelephone) == 10) {
            $e['res_phone'] = $e['res_phone'] . "Please Set the Country Code '+94' at the Begining";
        }

        if (strlen($validtelephone) != 12 && strlen($validtelephone) < 12) {
            $e['res_phone'] = $e['res_phone'] . "Invalid Phone Number";
        }

        if (strlen($validtelephone) == 12) {
            $phonecode = substr($validtelephone, 0, 3);
            if ($phonecode != +94) {
                
            }
        }
    }

    //Email Validation

    if (!empty($res_email)) {
        if (!filter_var($res_email, FILTER_VALIDATE_EMAIL)) {
            $e['$res_email'] = "Invalid Email Address";
        }
    }
    
    if(empty($e)){
        $id=1;
        $sql = "UPDATE `tb_contact` SET `email`='$res_email',`telephone`='$res_phone',`address`='$res_address' WHERE `id`= '$id'";
        $r = $conn->query($sql);
        if ($r === TRUE) {
//            echo 'SUCCESS';
        } else {
            echo "Data Update Failed:" . $conn->error;
        }
    }
}
?>

<div class="card">
    <div class="card-header">
        Contact Details
    </div>
    <div class="card-body">
        <div class="row">
            <?php
            $csql_tb = "SELECT * FROM `tb_contact`";
            $cresult_tb = $conn->query($csql_tb);
            $cresult_tb->num_rows;
            if ($cresult_tb->num_rows > 0) {
                while ($crow = $cresult_tb->fetch_assoc()) {
//                                print_r($crow);
                    ?>
                    <div class="col">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Restaurant Info</h5>

                                <h6 class="card-title"><b>Address</b></h6>
                                <p class="card-text" value="<?php echo $crow['id'] ?>"><?php echo $crow['address'] ?></p>
                                <h6 class="card-title"><b>Phone Number</b></h6>
                                <p class="card-text" value="<?php echo $crow['id'] ?>"><?php echo $crow['telephone'] ?></p>
                                <h6 class="card-title"><b>Email</b></h6>
                                <p class="card-text" value="<?php echo $crow['id'] ?>"><?php echo $crow['email'] ?></p>

                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="inputAddress2">Address</label>
                                <input type="text" class="form-control" name="res_addres" value="<?php echo $crow['address'] ?>">             
                                <div class="text-danger"><?php echo @$e['res_addres']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="inputAddress">Phone Number</label>
                                <input type="text" class="form-control" name="res_phone" value="<?php echo $crow['telephone'] ?>">
                                <div class="text-danger"><?php echo @$e['res_phone']; ?></div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" name="res_email" value="<?php echo $crow['email'] ?>">
                                <div class="text-danger"><?php echo @$e['res_addres']; ?></div>
                            </div>            
                            <button type="submit" class="btn btn-primary" name="operate" value="update-contact">Update</button>
                        </form>
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>
<?php include '../footer.php'; ?>