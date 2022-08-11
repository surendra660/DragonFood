<?php
require('adminSessionCheck.php');
require('connect.php');

if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

$cid = $_GET['id'];

$qry = "SELECT * FROM customer_reg WHERE CUSTOMER_REG_ID='$cid' ";
$send = oci_parse($conn, $qry);
$result = oci_execute($send);
$row = oci_fetch_assoc($send);
$fname = $row['CUSTOMER_FNAME'];
$lname = $row['CUSTOMER_LNAME'];
$uname = $row['CUSTOMER_USERNAME'];
$email = $row['CUSTOMER_EMAIL'];
$password = $row['CUSTOMER_PASSWORD'];
$dob = $row['CUSTOMER_DOB'];
$gender = $row['CUSTOMER_GENDER'];

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
                            <a href="adminManageProfile.php" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Manage Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageTrader.php" class="nav-link">
                                <i class="nav-icon fa fa-users"></i>
                                <p>
                                    Manage Trader
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageCustomer.php" class="nav-link active">
                                <i class="nav-icon fa fa-users "></i>
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
                            <h4 class="m-0">Update Customer Profile</h4>
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
                    <form action="adminUpdateCustomer.php" class="col-lg-6 offset-lg-3" method="POST">
                        <input type="hidden" value="<?= $cid ?>" name="id">
                        <div class=" form-group row justify-content-center">
                            <label for="fname" class="col-sm-3 col-form-label">First Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="fname" class="form-control" id="fname" value="<?= $fname ?>">
                            </div>
                            <div class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['fn'])) {
                                                                                echo $errors['fn'];
                                                                            }
                                                                            ?></div>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="lname" class="col-sm-3 col-form-label">Last Name</label>
                            <div class="col-sm-6">
                                <input type="text" name="lname" class="form-control" id="lname" value="<?= $lname ?>">
                            </div>
                            <span class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['ln'])) {
                                                                                echo $errors['ln'];
                                                                            }
                                                                            ?></span>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="uname" class="col-sm-3 col-form-label">Username</label>
                            <div class="col-sm-6">
                                <input type="text" name="uname" class="form-control" id="uname" value="<?= $uname ?>">
                            </div>
                            <span class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['un'])) {
                                                                                echo $errors['un'];
                                                                            }
                                                                            ?></span>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="email" class="col-sm-3 col-form-label">Email</label>
                            <div class="col-sm-6">
                                <input type="email" class="form-control" id="email" name="email" value="<?= $email ?>">
                            </div>
                            <span class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['e'])) {
                                                                                echo $errors['e'];
                                                                            }
                                                                            ?></span>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="password" class="col-sm-3 col-form-label">Password</label>
                            <div class="col-sm-6">
                                <input type="password" class="form-control" id="password" name="password" value="<?= $password ?>">
                            </div>
                            <span class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['p'])) {
                                                                                echo $errors['p'];
                                                                            }
                                                                            ?></span>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="dob" class="col-sm-3 col-form-label">DOB</label>
                            <div class="col-sm-6">
                                <input type="date" name="dob" class="form-control" id="dob" value="<?= date('Y-m-d', strtotime($dob)) ?>">
                            </div>
                            <span class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['dob'])) {
                                                                                echo $errors['dob'];
                                                                            }
                                                                            ?></span>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="gender" class="col-sm-3 col-form-label">Gender</label>
                            <div class="col-sm-6">
                                <Select type="text" class="form-control" id="gender" name="gender">
                                    <option value="">Choose</option>
                                    <option <?= $gender == 'male' ? 'selected' : '' ?> value="male">Male</option>
                                    <option <?= $gender == 'female' ? 'selected' : '' ?> value="female">Female</option>
                                    <option <?= $gender == 'other' ? 'selected' : '' ?> value="other">Other</option>
                                </Select>
                            </div>
                            <span class="col-sm-6 offset-sm-3 text-danger"><?php if (isset($errors['g'])) {
                                                                                echo $errors['g'];
                                                                            }
                                                                            ?></span>
                        </div>
                        <div class="form-group row justify-content-center">
                            <label for="update" class="col-sm-3 col-form-label"></label>
                            <div class="col-sm-6">
                                <button type="submit" name="submit" class="btn btn-warning">Update</button>
                                <!-- <button onclick="event.preventDefault(); window.location.href='deleteCustomer.php';" class="btn btn-danger">Delete</button> -->
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