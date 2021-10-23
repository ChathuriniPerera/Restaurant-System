<!--include header-->
<?php include '../header.php'; ?>
<!--include navigation-->
<?php include '../nav.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == "POST" && @$_POST['operate'] == "save") {
    $Item_Name = $Category = $Category_id = $Description = $Price = $Item_Image = null;

    $e = array();

    $Category = clean_data($_POST['category']);
    $Item_Name = clean_data($_POST['item_name']);
    $Description = clean_data($_POST['description']);
    $Price = clean_data($_POST['price']);

    //Empty Validation
    if (empty($Category)) {
        $e['category'] = "Category sholudn't be empty";
    }
    if (empty($Item_Name)) {
        $e['item_name'] = "Item Name sholudn't be empty";
    }
    if (empty($Description)) {
        $e['description'] = "Description sholudn't be empty";
    }
    if (empty($Price)) {
        $e['price'] = "Price sholudn't be empty";
    }

//File/Image Upload
    if (empty($e)) {
        $target_dir = "../img/";
        //../uploads/myphoto.jpg
        $target_file = $target_dir . basename($_FILES["item_image"]["name"]);
        $uploadOK = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $check = getimagesize($_FILES["item_image"]['tmp_name']);
        if ($check !== false) {
            $uploadOK = 1;
        } else {
            $e['item_image'] = "File is not an Image.";
            $uploadOK = 0;
        }

        if (file_exists($target_file)) {
            $e['item_image'] = "Sorry File Already Exists.";
            $uploadOK = 0;
        }
        if ($_FILES["item_image"]["size"] > 5000000) {
            $e['item_image'] = "Sorry, your file is too large.";
            $uploadOK = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $e['item_image'] = "Sorry, Only JPG,JPeG,PNG,pdf & GIF are Allowed";
            $uploadOK = 0;
        }
        if ($uploadOK == 0) {
            
        } else {
            if (move_uploaded_file($_FILES["item_image"]["tmp_name"], $target_file)) {
                $Item_Image = basename($_FILES["item_image"]["name"]);
            } else {
                $e['item_image'] = "Sorry,there was an error uploading your file.";
            }
        }
    }

    if (empty($e)) {
        $sql_menu = "INSERT INTO `tb_menu`(`item_name`, `category_id`, `description`, `price`, `item_image`) VALUES ('$Item_Name','$Category','$Description','$Price','$Item_Image')";
        $result_menu = $conn->query($sql_menu);
        if ($result_menu === TRUE) {
//            echo 'Data Insert Success..';
            $Item_Name = $Category = $Category_id = $Description = $Price = $Item_Image = null;
        } else {
            echo "Data Insert Failed:" . $conn->error;
        }
    }
}
?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">
                Add Menu Items
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="post"
                  enctype="multipart/form-data">
                <div class="card-body">
                    <div class="form-row ">
                        <div class="form-group col-md-4">
                            <label for="category">Category</label>
                            <select id="category" class="form-control" name="category">
                                <option value="">Choose...</option>
                                <?php
                                $sql_3 = "SELECT * FROM `tb_menu_category`";
                                $result_3 = $conn->query($sql_3);
                                if ($result_3->num_rows > 0) {
                                    while ($row_3 = $result_3->fetch_assoc()) {
                                        ?><option value="<?php echo $row_3['category_id']; ?>" <?php if (@$Category == $row_3['category_id']) { ?> selected <?php } ?>><?php echo $row_3['category']; ?></option> 
                                        <?php
                                    }
                                }
                                ?>          
                            </select>
                            <div class="text-danger"><?php echo @$e['category']; ?></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="item_name">Item Name</label>
                            <input type="text" class="form-control" id="item_name" name="item_name" placeholder="Item Name" value="<?php echo @$Item_Name; ?>">
                            <div class="text-danger"><?php echo @$e['item_name']; ?></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="description">Description</label>
                            <input type="text" class="form-control"  id="description" name="description" placeholder="Description" value="<?php echo @$Description; ?>">
                            <div class="text-danger"><?php echo @$e['description']; ?></div>
                        </div>
                    </div>
                    <div class="form-row ">                      
                        <div class="form-group col-md-4">
                            <label for="price">Price</label>
                            <input type="text" class="form-control" id="price" name="price" placeholder="Price" value="<?php echo @$Price; ?>">
                            <div class="text-danger"><?php echo @$e['price']; ?></div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="item_image">Select Item Image</label>
                            <input type="file" class="form-control-file" id="item_image" name="item_image">
                            <div class="text-danger"><?php echo @$e['item_image']; ?></div>
                        </div>
                        <div class="form-group col-md-4">
                            <button type="submit" name="operate" value="save" class="btn btn-primary">Add Item</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="row">
    <div class="col">
        <div id="accordion">
            <?php
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
                                            ?>    
                                            <div class="col-md-3">
                                                <div class="card">
                                                    <img src="<?php echo SITE_URL; ?>/img/<?php echo $row_item['item_image']; ?>" class="card-img-top" alt="...">
                                                    <div class="card-body">
                                                        <h5 class="card-title"><?php echo $row_item['item_name']; ?></h5>
                                                        <p class="card-text"><?php echo $row_item['description']; ?>.</p>
                                                        <p class="card-text"><?php echo "Rs. " . $row_item['price'] . "/="; ?></p>
<!--                                                        <a class="btn btn-primary"><i class="fas fa-eraser"></i></a>-->
                                                        <a href="<?php echo SITE_URL; ?>menu_items/edit_menu.php?item_id=<?php echo $row_item['item_id']; ?>" class="btn btn-primary"><i class="fas fa-pen-alt"></i></a> 
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
                    </div>
                    <?php
                }
            }
            ?>
        </div>
    </div>

</div>
<?php include '../footer.php'; ?>

