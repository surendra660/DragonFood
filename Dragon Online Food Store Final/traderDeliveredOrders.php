<?php
require('traderSessionCheck.php');
require('connect.php');

$tid = $_SESSION['trader']['TRADER_REG_ID'];

// query to display shops
$qry = "SELECT products.product_id, category.category_name, products.product_price, products.product_title,products.product_qty, products.product_desc, shop.shop_name
FROM products INNER JOIN category ON category.category_id = products.category_id INNER JOIN shop ON shop.shop_id = products.shop_id
WHERE products.trader_reg_id = '$tid'"; 

$send = oci_parse($conn, $qry);
oci_execute($send);
oci_fetch_all($send, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DOFS | Delivered Orders</title>

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

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="logo.png" alt="DFOS" height="60" width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="dashboardTrader.php" class="nav-link">Home</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="traderAddShop.php" class="nav-link">Add Shop</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="traderAddProduct.php" class="nav-link">Add Product</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="traderOrdersToBeDelivered.php" class="nav-link">Orders to be delivered</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="traderDeliveredOrders.php" class="nav-link active">Delivered Orders</a>
                </li>
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
                <img src="logo.png" alt="DOFS Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Dragon OFS</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="logo.png" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block"><?=$_SESSION['trader']['TRADER_USERNAME']?></a>
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
                        <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                        <li class="nav-item">
                            <a href="dashboardTrader.php" class="nav-link">
                                <i class="nav-icon fas fa-th"></i>
                                <p>
                                    Dashboard
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderManageProfile.php" class="nav-link">
                                <i class="nav-icon fa fa-user"></i>
                                <p>
                                    Manage Profile
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderAddShop.php" class="nav-link">
                                <i class="nav-icon fa fa-store-alt"></i>
                                <p>
                                   Add Shop
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderAddProduct.php" class="nav-link">
                                <i class="nav-icon fa fa-gift"></i>
                                <p>
                                   Add Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderOrdersToBeDelivered.php" class="nav-link">
                                <i class="nav-icon fa fa-gift"></i>
                                <p>
                                  Orders To Be Delivered
                                </p>                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderDeliveredOrders.php" class="nav-link active">
                                <i class="nav-icon fa fa-gift"></i>
                                <p>
                                    Delivered Orders
                                </p>                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="http://127.0.0.1:8080/apex/f?p=4550:1:15303101184209:::::" class="nav-link">
                                <i class="nav-icon fa fa-file"></i>
                                <p>
                                    Report
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="logout.php" class="nav-link">
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
                            <h1 class="m-0">Orders To Be Delivered</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboardTrader.php">Home</a></li>
                                <li class="breadcrumb-item active">Delivered Orders</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">                
                <br>
                <div class="text-center">
                    <h4>Pending Orders</h4>
                </div>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>   
                            <th scope="col">NAME</th>                     
                            <th scope="col">CATEGORY</th>                            
                            <th scope="col">DESCRIPTION</th>
                            <th scope="col">PRICE</th>
                            <th scope="col">QUANTITY</th>
                            <th scope="col">SHOP</th>
                            <th scope="col">ACTION</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($products as $product) {
                        ?>
                            <tr>
                                <td><?= $product['PRODUCT_ID'] ?></td>
                                <td><?= $product['PRODUCT_TITLE'] ?></td>
                                <td><?= $product['CATEGORY_NAME'] ?></td> 
                                <td><?= $product['PRODUCT_DESC'] ?></td>
                                <td>&pound; <?= number_format(($product['PRODUCT_PRICE'])/100,2) ?></td>
                                <td><?= $product['PRODUCT_QTY'] ?></td>
                                <td><?= $product['SHOP_NAME'] ?></td>
                                <td><a href="traderUpdateProduct.php?id=<?= $product['PRODUCT_ID'] ?>">Update</a><br><a href="traderDeleteProduct.php?id=<?= $product['PRODUCT_ID'] ?>" style="color: red">Delete</a></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
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
        $.widget.bridge('uibutton', $.ui.button);
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