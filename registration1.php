<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<!-- content -->

<div class="container-fluid">
    <form id="register">
        <div class="form-group">
            <label for="first_name">First Name<small class="text-danger">*</small></label>
            <input type="text" class="form-control" id="first_name" name="first_name" >
        </div>
        <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name"  >
        </div>
        <div class="form-group">
            <label for="last_name">Address</label>
            <textarea id="address" name="address" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <?php
            $sql = "SELECT * FROM tb_district";
            $result = $conn->query($sql);
            ?>
            <label>District</label>
            <select name="district" id="district" class="form-control" onchange="loadDivSec(this.value)">
                <option value="">--Select a District--</option>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <option value="<?php echo $row['Dis_Code'] ?>"><?php echo $row['District'] ?></option>
                        <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group" id="div_sec">
            <?php
            $sql = "SELECT * FROM tb_divsecretariat";
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
        </div>
        <button type="button" class="btn btn-primary" name="operate" value="save" onclick="register()">Save</button>
        <div id="mytest" class="alert alert-danger mt-2" ></div>
        <input type="text" id="name" class="form-control">
    </form>
</div>


<!-- end-content -->

<?php include 'footer.php'; ?>

<script>
    function register() {

        var d = $("#register").serialize();
        $.ajax({
            type: 'POST',
            data: d,
            url: 'process.php',
            success: function (data) {
                $("#mytest").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });

    }

    function loadDivSec(dis_code) {
        var d = "dis_code=" + dis_code + "&";
        $.ajax({
            type: 'POST',
            data: d,
            url: 'load_div_sec.php',
            success: function (data) {
                $("#div_sec").html(data);
            },
            error: function (request, status, error) {
                alert(request.responseText);
            }
        });
    }

</script>