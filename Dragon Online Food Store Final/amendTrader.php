<?php
require('adminSessionCheck.php');
require('connect.php');

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

$tid = $_GET['id'];
$qry = "SELECT * FROM trader_reg WHERE TRADER_REG_ID='$tid' ";
$send = oci_parse($conn, $qry);
$result = oci_execute($send);
$row = oci_fetch_assoc($send);

$uname = $row['TRADER_USERNAME'];
$password = $row['TRADER_PASSWORD'];
$fname = $row['CONTACT_NAME'];
$email = $row['CONTACT_EMAIL'];
$contact = $row['CONTACT_NUMBER'];
$street = $row['TRADER_STREET'];
$district = $row['TRADER_DISTRICT'];
$city = $row['TRADER_CITY'];
$province = $row['TRADER_PROVINCE'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DFOS | Dashboard</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- JQVMap -->
    <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="dist/css/adminlte.min.css">
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
    <!-- Daterange picker -->
    <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
    <!-- summernote -->
    <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <!-- <li class="nav-item d-none d-sm-inline-block">
                    <a href="index3.html" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="#" class="nav-link">Contact</a>
                </li> -->
            </ul>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="index3.html" class="brand-link">
                <img src="logo.png" alt="DFOS logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Dragon OFS </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="logo.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">Ujjwal Ranamagar</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar">
                                <i class="fas fa-search fa-fw"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="dashboard.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageProfile.php" class="nav-link ">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Manage Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageTrader.php" class="nav-link active">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Manage Trader
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageCustomer.php" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Manage Customer
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminReports.php" class="nav-link">
                                <i class="nav-icon fa fa-file"></i>
                                <p>
                                    Reports
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminLogout.php" class="nav-link">
                                <i class="nav-icon fa fa-power-off"></i>
                                <p>
                                    Logout
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h4 class="m-0">Update Trader Profile</h4>
                        </div>
                    </div><!-- /.row -->
                </div>
                <div class="col-sm-6">
                    <h1 class="m-0">Ujjwal Ranamagar</h1>
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <form method="POST" action="adminUpdateTrader.php" class="col-lg-6 offset-lg-3">
                        <input type="hidden" name='id' value="<?= $tid ?>">
                        <div class="form-group row justify-content-center">
                            <label for="uname" class="col-sm-2 col-form-label">Username</label>
                            <div class="col-sm-6">
                                <input type="text" name="uname" class="form-control" id="uname" value="<?= $uname ?>" required>
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['un'])) {
                                                                                echo $errors['un'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="password" class="col-sm-2 col-form-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" name="password" class="form-control" id="password" value="<?= $password ?>" required>
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['pa'])) {
                                                                                echo $errors['pa'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="fullname" class="col-sm-2 col-form-label">Full Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="fullname" class="form-control" id="fullname" value="<?= $fname ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['fn'])) {
                                                                                echo $errors['fn'];
                                                                            }
                                                                            ?></div>
                        </div>                        
                        <div class="form-group row justify-content-center">
                            <label for="email" class="col-sm-2 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['e'])) {
                                                                                echo $errors['e'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="contact" class="col-sm-2 col-form-label">Contact</label>
                            <div class="col-sm-6">
                                <input type="text" name="contact" class="form-control" id="contact" value="<?= $contact ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['c'])) {
                                                                                echo $errors['c'];
                                                                            }
                                                                            ?></div>
                        </div>                        
                        <div class="form-group row justify-content-center">
                            <label for="street" class="col-sm-2 col-form-label">Street</label>
                            <div class="col-sm-6">
                                <input type="text" name="street" class="form-control" id="street" value="<?= $street ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['s'])) {
                                                                                echo $errors['s'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="district" class="col-sm-2 col-form-label">District</label>
                            <div class="col-sm-6">
                                <input type="text" name="district" class="form-control" id="district" value="<?= $district ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['d'])) {
                                                                                echo $errors['d'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="city" class="col-sm-2 col-form-label">City</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="city" name="city" value="<?= $city ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['ct'])) {
                                                                                echo $errors['ct'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="province" class="col-sm-2 col-form-label">Province</label>
                            <div class="col-sm-6">
                                <input type="text" class="form-control" id="province" name="province" value="<?= $province ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-2 text-danger"><?php if (isset($errors['p'])) {
                                                                                echo $errors['p'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="save" class="col-sm-2 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" name="submit" class="btn btn-warning">Update</button>
                            </div>
                        </div>
                    </form>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Copyright &copy; 2021 <a href="#">Dragon Online Food Store</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 2.1.1
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- ChartJS -->
    <script src="plugins/chart.js/Chart.min.js"></script>
    <!-- Sparkline -->
    <script src="plugins/sparklines/sparkline.js"></script>
    <!-- JQVMap -->
    <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
    <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
    <!-- jQuery Knob Chart -->
    <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
    <!-- daterangepicker -->
    <script src="plugins/moment/moment.min.js"></script>
    <script src="plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- Summernote -->
    <script src="plugins/summernote/summernote-bs4.min.js"></script>
    <!-- overlayScrollbars -->
    <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
    <!-- AdminLTE App -->
    <script src="dist/js/adminlte.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="dist/js/demo.js"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    <script src="dist/js/pages/dashboard.js"></script>
</body>

</html>