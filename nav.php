<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <!-- <div class="sidebar-brand-icon rotate-n-15"> -->
        <div><img src="<?php echo SITE_URL; ?>/icon/nav.png" height="75px" width="225px"></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0s">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="<?php echo SITE_URL; ?>dashboard.php">
            <img src="<?php echo SITE_URL; ?>/icon/pattern-design.png" width="15px" height="15px">
            <span>Dashboard</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Nav Item - Pages Collapse Menu -->

    <?php
    $sql_parent = "SELECT * FROM tb_user_module LEFT JOIN tb_module ON tb_user_module.module_id=tb_module.module_id WHERE tb_user_module.user_id='" . $_SESSION['user_id'] . "' AND LENGTH(tb_user_module.module_id)=2";
    $result_parent = $conn->query($sql_parent);
    ?>

    <?php
    if ($result_parent->num_rows > 0) {
        while ($row_parent = $result_parent->fetch_assoc()) {
            ?>
            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item active">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapse<?php echo $row_parent['id']; ?>" aria-expanded="true" aria-controls="collapse<?php echo $row_parent['id']; ?>">
<!--                    <i class="fa fa-user-plus" aria-hidden="true"></i>-->
                    <span><?php echo $row_parent['description']; ?></span>
                </a>
                <div id="collapse<?php echo $row_parent['id']; ?>" class="collapse" aria-labelledby="heading<?php echo $row_parent['description']; ?>" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <?php
                        $sql_sub = "SELECT * FROM tb_user_module LEFT JOIN tb_module ON tb_user_module.module_id=tb_module.module_id WHERE tb_user_module.user_id='" . $_SESSION['user_id'] . "' AND LENGTH (tb_user_module.module_id)=4 AND SUBSTR(tb_user_module.module_id,1,2)='" . $row_parent['module_id'] . "'";
                        $result_sub = $conn->query($sql_sub);
                        if ($result_sub->num_rows > 0) {
                            while ($row_sub = $result_sub->fetch_assoc()) {
                                ?>
                                <?php
                                $path = SITE_URL . $row_sub['module'] . "/" . $row_sub['view'] . ".php";
                                ?>
                                <a class="collapse-item" href="<?php echo $path; ?>"><?php echo $row_sub['description'] ?></a>
                                <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </li>



            <!-- Divider -->
            <hr class="sidebar-divider d-none d-md-block">
            <?php
        }
    }
    ?>
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

            <!-- Sidebar Toggle (Topbar) -->
            <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>

            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - Search Dropdown (Visible Only XS) -->


                <!-- Nav Item - Alerts -->


                <!-- Nav Item - Messages -->


                <div class="topbar-divider d-none d-sm-block"></div>

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION['full_name']; ?></span>
                        <img class="img-profile rounded-circle" src="<?php echo SITE_URL; ?>Upload/<?php echo $_SESSION['profile_img']; ?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
