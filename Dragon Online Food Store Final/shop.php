<?php
session_set_cookie_params(3600, '/; samesite=None', $_SERVER['HTTP_HOST'], true, true);
require_once('connect.php');
session_start();

$sort = $_GET['sort'] ?? '';
$category = $_GET['category'] ?? '';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';
$search= $_GET['search'] ?? '';

$sql = "SELECT * FROM PRODUCTS WHERE PRODUCT_TITLE LIKE '%$search%'";
if (!empty($min) || !empty($max)) {
    if (!empty($min) && !empty($max)) {
        $sql = $sql . " AND PRODUCT_PRICE BETWEEN " . $min * 100 . " AND " . $max * 100;
    } else if (!empty($min)) {
        $sql = $sql . " AND PRODUCT_PRICE >= " . $min * 100;
    } else if (!empty($max)) {
        $sql = $sql . " AND PRODUCT_PRICE <= " . $max * 100;
    }    
}
if (!empty($category)) {
    $sql = $sql . " AND CATEGORY_ID = " . $category;
}

if (!empty($sort)) {
    if ($sort == 'name') {
        $sql = $sql . " ORDER BY PRODUCT_TITLE";
    } else if ($sort == 'price') {
        $sql = $sql . " ORDER BY PRODUCT_PRICE";
    }
}
$send = oci_parse($conn, $sql);
oci_execute($send);
if (!$send) {
    die("Database error: " . oci_error($send));
}
oci_fetch_all($send, $products, null, null, OCI_FETCHSTATEMENT_BY_ROW);
$cart = $_SESSION['user']['cart'] ?? [];
$cartCount = count($cart);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>DOFS - Search</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/fonts/ionicons.min.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/Footer-Basic.css">
    <link rel="stylesheet" href="assets/css/Navigation-with-Search.css">
    <link rel="stylesheet" href="assets/css/Projects-Horizontal.css">
    <link rel="stylesheet" href="https://fontawesome.com/v4.7.0/assets/font-awesome/css/font-awesome.css">
    <link rel="stylesheet" href="assets/css/search_product.css">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.2/css/all.min.css">
</head>

<body>
    <nav class="navbar navbar-light navbar-expand-md navigation-clean-search">
        <div class="container"><a class="navbar-brand" href="#"><img src="Logo.png" width="60" height="60"></a><button data-bs-toggle="collapse" class="navbar-toggler" data-bs-target="#navcol-1"><span class="visually-hidden">Toggle navigation</span><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="navbar-nav">
                    <li class="nav-item"><a class="nav-link" href="home.php">Home</a></li>
                    <li class="nav-item"></li>
                    <li class="nav-item"><a class="nav-link active" href="shop.php">Shop</a></li>
                    <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
                    <li class="nav-item"><a class="nav-link" href="traderRegister.php">Be a Seller</a></li>
                    <li class="nav-item">
                        <form class="d-flex input-group w-auto">
                            <input name="search" class="form-control rounded" placeholder="Search" aria-label="Search" aria-describedby="search-addon" />
                            <button class="input-group-text border-0" id="search-addon">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </li>
                </ul>
                <?php if (isset($_SESSION['user']['CUSTOMER_USERNAME'])) { ?>
                    <a class="btn btn-danger ms-auto fa fa-sign-out-alt" role="button" href="customerLogout.php" style="margin: 0px;">&nbsp;Logout</a>
                <?php } else { ?>
                    <a class="btn btn-secondary ms-auto fa fa-sign-in-alt" role="button" href="signin.php" style="margin: 0px;">&nbsp;Sign in</a>
                <?php } ?>
                <a class="btn btn-secondary fa fa-user" role="button" href="register.php" style="margin: 4px;">&nbsp;Register</a>
                <a class="btn btn-secondary fa fa-shopping-cart" role="button" href="cart.php">&nbsp;Cart <?= $cartCount ?></a>
            </div>
        </div>
    </nav>
    <!------ Include the above in your HEAD tag ---------->
    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <form action="">

                    <div class="card">
                        <article class="filter-group">
                            <header class="card-header">
                                <h6 class="title">Sort</h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_1">
                                <div class="card-body">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="sort" value="name" <?= $sort == 'name' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Name
                                        </div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="sort" value="price" <?= $sort == 'price' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Price
                                        </div>
                                    </label>
                                </div> <!-- card-body.// -->
                            </div>
                        </article> <!-- filter-group  .// -->
                        <article class="filter-group">
                            <header class="card-header">

                                <h6 class="title">Categories</h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_2">
                                <div class="card-body">
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="category" value="1" <?= $category == '1' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Bakery</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="category" value="2" <?= $category == '2' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Butcher</div>
                                    </label>

                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="category" value="3" <?= $category == '3' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Delicatessen</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="category" value="4" <?= $category == '4' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Fishmonger</div>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input type="radio" name="category" value="5" <?= $category == '5' ? ' checked' : '' ?> class="custom-control-input">
                                        <div class="custom-control-label" style="float: left;">Greengrocer</div>
                                    </label>
                                </div> <!-- card-body.// -->

                            </div>
                        </article> <!-- filter-group .// -->
                        <article class="filter-group">
                            <header class="card-header">
                                <!-- <a href="#" data-toggle="collapse" data-target="#collapse_3" aria-expanded="true" class=""> -->

                                <h6 class="title">Price range </h6>
                                </a>
                            </header>
                            <div class="filter-content collapse show" id="collapse_3">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label>Min</label>
                                            <input class="form-control" name="min" placeholder="£ 0" type="number" value="<?= $min ?>" min="0">
                                        </div>
                                        <div class="form-group text-right col-md-6">
                                            <label>Max</label>
                                            <input class="form-control" name="max" placeholder="£ 1,000" type="number" value="<?= $max ?>" min="0">
                                        </div><br>
                                    </div> <!-- form-row.// -->
                                    <button class="btn btn-block btn-primary" style="background-color: black;">Apply</button>
                                </div><!-- card-body.// -->
                            </div>
                        </article> <!-- filter-group .// -->
                </form>
            </aside>
            <main class="col-md-9">

                <div class="row">
                    <?php foreach ($products as $product) { ?>
                        <div class="col-md-4">
                            <figure class="card card-product-grid">
                                <div class="img-wrap">
                                    <img src="<?= $product['PRODUCT_IMG1'] ?>" style="width:100%;" class="img-fluid">

                                </div> <!-- img-wrap.// -->
                                <figcaption class="info-wrap">
                                    <div class="fix-height">
                                        <a href="product.php?id=<?= $product['PRODUCT_ID'] ?>" class="title"><?= $product['PRODUCT_TITLE'] ?></a>

                                        <div class="price-wrap mt-2">
                                            <span class="price"><b>&pound; <?= number_format(($product['PRODUCT_PRICE'] / 100), 2) ?></b></span>
                                        </div> <!-- price-wrap.// -->
                                    </div>
                                    <a href="addcart.php?id=<?= $product['PRODUCT_ID'] ?>" class="btn btn-block btn-warning">Add to cart </a>
                                </figcaption>
                            </figure>
                        </div>
                    <?php } ?>
                    <!-- col.// -->
                    <!-- row end.// -->
                    <nav class="mt-4" aria-label="Page navigation sample">
                        <ul class="pagination justify-content-center">
                            <li class="page-item disabled"><a class="page-link" href="#">Previous</a></li>
                            <li class="page-item active"><a class="page-link" href="#">1</a></li>
                            <li class="page-item"><a class="page-link" href="#">2</a></li>
                            <li class="page-item"><a class="page-link" href="#">3</a></li>
                            <li class="page-item"><a class="page-link" href="#">Next</a></li>
                        </ul>
                    </nav>
                </div>
            </main>
        </div>
    </div>

    <footer class="footer-basic">
        <div class="social"><a href="#"><i class="icon ion-social-instagram"></i></a><a href="#"><i class="icon ion-social-twitter"></i></a><a href="#"><i class="icon ion-social-facebook"></i></a></div>
        <p class="copyright">Dragon Online Food Store © 2020</p>
    </footer>
</body>

</html>