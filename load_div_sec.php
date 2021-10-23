<?php
include 'conn.php';
?>

<?php
$dis_code = $_POST['dis_code'];
$sql = "SELECT * FROM tb_divsecretariat WHERE Dis_Code='$dis_code'";
$result = $conn->query($sql);
?>
<label>Div. Sec.</label>
<select name="divsecretariat" id="divsecretariat" class="form-control">
    <option value="">--Select a Div. Sec.--</option>
<?php
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
            <option value="<?php echo $row['DivSec_Code'] ?>"><?php echo $row['DivSecretariat'] ?></option>
            <?php
        }
    }
    ?>
</select>