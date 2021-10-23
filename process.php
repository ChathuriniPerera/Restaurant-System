<?php
//echo "First Name : ".$_POST['first_name'];

include 'conn.php';
$fname = $_POST['first_name'];
$lname = $_POST['last_name'];
$add = $_POST['address'];

$sql = "INSERT INTO `tb_registration`(`first_name`, `last_name`, `address`) VALUES ('$fname','$lname','$add')";
$conn->query($sql);

$sql = "SELECT * FROM tb_registration";
$result = $conn->query($sql);
?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Address</th>
        </tr>
    </thead>
    <tbody>
        <?php if ($result->num_rows > 0) { ?>
            <?php while ($row = $result->fetch_assoc()) { ?>
                <tr>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['address']; ?></td>
                </tr>
            <?php }
        } ?>
    </tbody>
</table>
