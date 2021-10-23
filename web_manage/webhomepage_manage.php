<?php ob_start(); ?>
<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<?php
//Include Database Connection
include '../conn.php';
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "GET") {
    $Product_id = @$_GET['id'];
}
//Carausal Image Change
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "update") {
    $Product_id = $slider_image = null;
    $e = array();

    $Product_id = clean_data($_POST['product_id']);

    //File/Image Upload
    if (empty($e)) {
        $target_dir = "../Upload/";
        //../uploads/myphoto.jpg
        $target_file = $target_dir . basename($_FILES["slider_image"]["name"]);
        $uploadOK = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["slider_image"]['tmp_name']);
        if ($check !== false) {
            $uploadOK = 1;
        } else {
            $e['slider_image'] = "File is not an Image.";
            $uploadOK = 0;
        }

        if (file_exists($target_file)) {
            $e['slider_image'] = "Sorry File Already Exists.";
            $uploadOK = 0;
        }
        if ($_FILES["slider_image"]["size"] > 50000000) {
            $e['slider_image'] = "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['slider_image'] = "Sorry, Only JPG,JPeG,PNG,pdf & GIF are Allowed";
            $uploadOK = 0;
        }
        if ($uploadOK == 0) {
            
        } else {
            if (move_uploaded_file($_FILES["slider_image"]["tmp_name"], $target_file)) {
                $Item_Image = basename($_FILES["slider_image"]["name"]);
            } else {
                echo $_FILES['slider_image']['error'];
                //$e['slider_image'] = "Sorry,there was an error uploading your file.";
            }
        }
    }
    if (empty($e)) {
        $sql_menu = "UPDATE `tb_carousal` SET `product_image`='$Item_Image' WHERE `product_id`='$Product_id'";
        $result_menu = $conn->query($sql_menu);
        if ($result_menu === TRUE) {
            echo 'Data Insert Success..';
        } else {
            echo "Data Insert Failed:" . $conn->error;
        }
    }
}
?>


<div class="card">
    <div class="card-header">
        Website Banner
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <?php
                    $sql_tb = "SELECT * FROM `tb_carousal` WHERE `product_id` = '$Product_id'";
                    $result_tb = $conn->query($sql_tb);
                    $result_tb->num_rows;
                    if ($result_tb->num_rows > 0) {
                        while ($row = $result_tb->fetch_assoc()) {
                            ?>
                            <?php @$Product_id = $row['product_id'] ?>
                            <img src="../Upload/<?php echo @$row['product_image']; ?>" class="img-thumbnail"> 
                            <?php
                        }
                    }
                    ?>
                </div>               
                <label for="slider_image">Slider Image</label>
                <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                      enctype="multipart/form-data">
                    <div class="form-inline">
                        <input type="file" class="form-control" id="slider_image" name="slider_image"
                               placeholder="Select Slider Image">
                        <div class="text-danger"><?php echo @$e['slider_image']; ?></div>
                        <input type="hidden" name="product_id" id="product_id" value="<?php echo $Product_id; ?>">
                        <button type="submit" name="operate" value="update" class="btn btn-primary"><i class="fas fa-pen-alt"></i></button>                    
                    </div>
                </form>
            </div>
            <div class="col">
                <blockquote class="blockquote mb-0">
                    <?php
                    $sql_tb = "SELECT * FROM `tb_carousal`";
                    $result_tb = $conn->query($sql_tb);
                    $result_tb->num_rows;
                    ?>
                    <table class="table table-dark">
                        <thead>
                            <tr>
                                <th scope="col">Carousal Id</th>
                                <th scope="col">Description</th>
                                <th scope="col">Image Name</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result_tb->num_rows > 0) {
                                while ($row = $result_tb->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td><?php echo $row['product_id']; ?></td>
                                        <td><?php echo $row['description']; ?></td> 
                                        <td><?php echo $row['product_image']; ?></td> 
                                        <td><a href="<?php echo SITE_URL; ?>web_manage/webhomepage_manage.php?id=<?php echo $row['product_id']; ?>" class="btn btn-primary"><i class="fas fa-upload"></i></a></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </blockquote>
            </div>
        </div>
    </div>
</div>


<?php ob_end_flush() ?>
<?php include '../footer.php'; ?>
