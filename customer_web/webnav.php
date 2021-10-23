<!-- Bootstrap core CSS -->
<link href="../web_template/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom styles for this template -->
<link href="../vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="../css/mywebstyle.css" rel="stylesheet">


<!-- Navigation -->
<nav class="navbar navbar-expand-lg navbar-dark my-nav-bg ">
    <div class="container">
        <div class="open-time">
            <?php
            date_default_timezone_set("Asia/Colombo");
            $current_time = strtotime(date("H:i"));
            $close_time = strtotime('23:00');
            $open_time = strtotime('09:00');
            if ($current_time < $close_time && $current_time > $open_time) {
                echo "Open";
            } else {
                echo "Close";
            }
            $currentpage = $_SERVER['PHP_SELF'];
            ?>
        </div>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
                <?php
                $sql = "SELECT * FROM `tb_webpages` ORDER BY `id`";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $page = "/tocadmin/" . $row['view'];
                        ?>
                        <li class = "nav-item <?php
                        if ($currentpage == $page) {
                            echo 'active';
                        }
                        ?>">
                                <?php
                                $display_name = $row['display_name'];
                                $view = $row['view'];
                                if (isset($_SESSION['customer_id'])) {
                                    if ($row['display_name'] == 'Login') {
                                        $display_name = 'Logout';
                                        $view = 'customer_web/customer_logout.php';
                                    } else {
                                        $display_name = $row['display_name'];
                                        $view = $row['view'];
                                    }
                                }
                                ?>  
                            <a class = "nav-link" href = "<?php echo SITE_URL . $view; ?>"><?php echo $display_name; ?></a>
                        </li><?php
                    }
                }
                ?>
            </ul>
        </div>
    </div>
</nav>