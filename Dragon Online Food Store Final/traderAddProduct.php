<?php
require('traderSessionCheck.php');
require('connect.php');
$errors = array();


if (isset($_SESSION['errors'])) {
    $errors = $_SESSION['errors'];
    unset($_SESSION['errors']);
}

if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    unset($_SESSION['message']);
}

$qry = 'SELECT * FROM category ORDER BY category_name';
$send = oci_parse($conn, $qry);
oci_execute($send);
oci_fetch_all($send, $categories, null, null, OCI_FETCHSTATEMENT_BY_ROW);

//FETCHING DATA FROM SESSION
$tid = $_SESSION['trader']['TRADER_REG_ID'];

$qry2 = "SELECT * FROM shop WHERE trader_reg_id = '$tid' ";
$send = oci_parse($conn, $qry2);
oci_execute($send);
oci_fetch_all($send, $shops, null, null, OCI_FETCHSTATEMENT_BY_ROW);

if (isset($_POST['submit'])) {
    $pname = trim($_POST['pname']);
    $desc = trim($_POST['desc']);
    $price = trim($_POST['price']);
    $qty = trim($_POST['qty']);    
    $shop = trim($_POST['shop']);
    $cat = trim($_POST['category']);

    //product name
    if (!empty($pname)) {
        if (strlen($pname) > 32) {
            $errors['sn'] = "Maximum character is 32";
        } else {
            $pname = $pname;
        }
    } else {
        $errors['pn'] = "Shop Name is required";
    }

    //description
    if (!empty($desc)) {
        if (strlen($desc) > 224) {
            $errors['d'] = "Maximum character is 224";
        } else {
            $desc = $desc;
        }
    } else {
        $errors['d'] = "Shop Name is required";
    }

    //category
    if (!empty($cat)) {
        $cat = $cat;
    } else {
        $errors['c'] = "Category is required";
    }

    //price
    if (!empty($price)) {
        if (is_numeric($price)) {
            $price = $price*100;
        } else {
            $errors['p'] = "Price must be numeric";
        }
    } else {
        $errors['p'] = "Price is required";
    }

    //quantity
    if (!empty($qty)) {
        if (is_numeric($qty)) {
            $qty = $qty;
        } else {
            $errors['q'] = "Quantity must be numeric";
        }
    } else {
        $errors['q'] = "Quantity is required";
    }

    //image1
    if (file_exists($_FILES['img1']["tmp_name"])) {

        $allowed_image_extension = array(
            "png",
            "jpg",
            "jpeg"
        );

        // Get image file extension
        $file_extension = pathinfo($_FILES['img1']["name"], PATHINFO_EXTENSION);

        // Validate file input to check if is with valid extension
        if (!in_array($file_extension, $allowed_image_extension)) {
            $errors['img1'] = "Upload valid images. Only PNG and JPEG are allowed.";
        }    // Validate image file size
        else {
            $fileinfo = getimagesize($_FILES['img1']["tmp_name"]);
            $width = $fileinfo[0];
            $height = $fileinfo[1];

            if (($_FILES['img1']["size"] > 2000000)) {
                $errors['img1'] = "Image size exceeds 2MB.";
            }    // Validate image file dimension
            else if ($width > "250" || $height > "250") {
                $errors['img1'] = "Image dimension should be within 300X200.";
            }
        }
    } else {
        $errors['img1'] = "Product Image 1 is required.";
    }

    //image2 
    if (file_exists($_FILES['img2']["tmp_name"])) {

        $allowed_image_extension = array(
            "png",
            "jpg",
            "jpeg"
        );

        // Get image file extension
        $file_extension = pathinfo($_FILES['img2']["name"], PATHINFO_EXTENSION);

        // Validate file input to check if is with valid extension
        if (!in_array($file_extension, $allowed_image_extension)) {
            $errors['img2'] = "Upload valid images. Only PNG and JPEG are allowed.";
        }    // Validate image file size
        else {
            $fileinfo = getimagesize($_FILES['img2']["tmp_name"]);
            $width = $fileinfo[0];
            $height = $fileinfo[1];

            if (($_FILES['img2']["size"] > 2000000)) {
                $errors['img2'] = "Image size exceeds 2MB.";
            }    // Validate image file dimension
            else if ($width > "250" || $height > "250") {
                $errors['img2'] = "Image dimension should be within 300X200.";
            }
        }
    } else {
        $errors['img2'] = "Product Image 2 is required.";
    }

    //shop
    if(!empty($shop)){
        $shop=$shop;
    }
    else{
        $errors['s'] = "Shop is required.";
    }

    //inserting
    if (count($errors) == 0) {

        $target = 'uploads/products/' . basename($_FILES["img1"]["name"]);

        if (move_uploaded_file($_FILES['img1']["tmp_name"], $target)) {
            $productImage1 = $target;
        } else {
            $errors['img1'] = "Problem in uploading image files.";
        }

        $target = 'uploads/products/' . basename($_FILES["img2"]["name"]);
        if (move_uploaded_file($_FILES['img2']["tmp_name"], $target)) {
            $productImage2 = $target;
        } else {
            $errors['img2'] = "Problem in uploading image files.";
        }

        $qry = "INSERT INTO products (TRADER_REG_ID, SHOP_ID, CATEGORY_ID, PRODUCT_TITLE, PRODUCT_DESC, PRODUCT_PRICE, PRODUCT_QTY, PRODUCT_IMG1, PRODUCT_IMG2)
        VALUES ('$tid', '$shop', '$cat', '$pname', '$desc', '$price', '$qty', '$productImage1', '$productImage2')";
        
        $send = oci_parse($conn, $qry);
        $result = oci_execute($send);

        if (!$result) {
            $message = ['message' => "Error inserting data: " . oci_error($send)['message'], 'color' => "danger"];
        } else {
            $message = ['message' => "Product added successfully", 'color' => "success"];
        }        
        $_SESSION['message'] = $message;
    } else {
        $_SESSION['errors'] = $errors;
    }
    header('Location: traderAddProduct.php');
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DOFS | Add Product</title>

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
                    <a href="traderAddProduct.php" class="nav-link active">Add Product</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="traderOrdersToBeDelivered.php" class="nav-link">Orders to be delivered</a>
                </li>
                <li class="nav-item d-none d-sm-inline-block">
                    <a href="traderDeliveredOrders.php" class="nav-link">Delivered Orders</a>
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
                            <a href="traderAddProduct.php" class="nav-link active">
                                <i class="nav-icon fa fa-gift"></i>
                                <p>
                                    Add Product
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderOrdersToBeDelivered.php" class="nav-link">
                                <i class="nav-icon fa fa-shopping-cart"></i>
                                <p>
                                  Orders To Be Delivered
                                </p>                                
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="traderDeliveredOrders.php" class="nav-link">
                                <i class="nav-icon fa fa-shopping-cart"></i>
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
                            <h1 class="m-0">Add Product</h1>
                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="dashboardTrader.php">Home</a></li>
                                <li class="breadcrumb-item active">Add Product</li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <form method="POST" action="" enctype="multipart/form-data">
                    <?php
                    if (isset($message)) {
                        echo "<div class='col-sm-6 alert alert-" . $message['color'] . "'><b>" . $message['message'] . "</b></div><br>";
                    }
                    ?>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Product Name : </label>
                        <div class="col-sm-6">
                            <input type="text" name="pname" class="form-control" id="pname" required>
                        </div>
                        <?php if (isset($errors['pn'])) {
                            echo '<span class="col-sm-6 text-danger">' . $errors['pn'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Category : </label>
                        <div class="col-sm-3">
                            <select name="category">
                                <?php
                                foreach ($categories as $category) { ?>
                                    <option value="<?= $category['CATEGORY_ID'] ?>"><?= $category['CATEGORY_NAME'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($errors['c'])) {
                            echo '<span class="col-sm-6 text-danger">' . $errors['c'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Description : </label>
                        <div class="col-sm-6">
                            <textarea type="text" name="desc" rows=4 class="form-control" id="desc" required></textarea>
                        </div>
                        <?php if (isset($errors['d'])) {
                            echo '<span class="col-sm-6 text-danger">' . $errors['d'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Price : </label>
                        <div class="col-sm-3">
                            <input type="text" name="price" class="form-control" id="price" required>
                        </div>
                        <?php if (isset($errors['p'])) {
                            echo '<span class="col-sm-6 text-danger">' . $errors['p'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Quantity : </label>
                        <div class="col-sm-3">
                            <input type="text" name="qty" class="form-control" id="qty" required>
                        </div>
                        <?php if (isset($errors['q'])) {
                            echo '<span class="col-sm-6 text-danger">' . $errors['q'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Images : </label>
                        <div class="col-sm-3">
                            <input type="file" name="img1" class="form-control" id="file" required>
                            <?php if (isset($errors['img1'])) {
                                echo '<span class="col-sm-6 text-danger">' . $errors['img1'] . '</span>';
                            }
                            ?>
                            <input type="file" name="img2" class="form-control" id="file" required>
                            <?php if (isset($errors['img2'])) {
                                echo '<span class="col-sm-6 text-danger">' . $errors['img2'] . '</span>';
                            }
                            ?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="Name" class="col col-form-label">Shop : </label>
                        <div class="col-sm-3">
                            <select name="shop">
                                <?php
                                foreach ($shops as $shop) { ?>
                                    <option value="<?= $shop['SHOP_ID'] ?>"><?= $shop['SHOP_NAME'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <?php if (isset($errors['s'])) {
                            echo '<span class="col-sm-6 text-danger">' . $errors['s'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-6">
                            <button type="submit" name="submit" class="btn btn-primary">Add Product</button>
                        </div>
                    </div>
                </form>
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