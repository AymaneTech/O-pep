<?php require("../config/db.php");
session_start();
$user_id =  $_SESSION["id"];
// =========================================================================
if (isset($_GET["id"])) {

    $id = intval($_GET["id"]);
    $query = "SELECT * FROM plant where category_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();
    $rows = $stmt->fetchAll();
// =========================================================================
} elseif (!(isset($_GET["id"]))) {
    // select plants
    global $pdo;
    $query = "SELECT * FROM plant;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    $rows = $stmt->fetchAll();
    if (!$stmt->execute()) {
        die("error");
    }
}
// =========================================================================
if(isset($_POST["btn-search"])){
   $rows= array_filter($rows ,fn($plant)=>$plant["plant_name"]==$_POST["Search"]);
}else{
    $rows= array_map(fn($plant)=> $plant,$rows);
}

// select categoriesx²
$catQuery = "SELECT * FROM category";
$catStmt = $pdo->prepare($catQuery);
$catStmt->execute();
$catRows = $catStmt->fetchAll();

// =========================================================================
// the function that fetch items gonna display on cart
function select_cart_elements() {
    $id = $_SESSION["id"];
    global $pdo;
    $query = "SELECT * FROM carts, plant, cart_plant
              WHERE cart_plant.cart_id = carts.cart_id
                AND cart_plant.plant_id = plant.plant_id
                AND carts.users_fk = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        return "cart is empty !!!";
    }
}
// =========================================================================
// this function calculates the total price of plants in cart
function cart_total(){
    global $pdo;
    $id = $_SESSION["id"];
    $query ="SELECT SUM(plant.plant_price) AS total_price
                FROM carts
                JOIN cart_plant ON cart_plant.cart_id = carts.cart_id
                JOIN plant ON cart_plant.plant_id = plant.plant_id
                WHERE carts.users_fk = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}


?>

<!DOCTYPE html>
<html lang="zxx">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>O'pep | home</title>
    <meta name="robots" content="index, follow" />
    <meta name="description"
        content="Pronia plant store bootstrap 5 template is an awesome website template for any home plant shop.">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS
    ============================================ -->

    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/font-awesome.min.css" />
    <link rel="stylesheet" href="assets/css/Pe-icon-7-stroke.css" />
    <link rel="stylesheet" href="assets/css/animate.min.css">
    <link rel="stylesheet" href="assets/css/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/css/nice-select.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css" />
    <link rel="stylesheet" href="assets/css/ion.rangeSlider.min.css" />

    <!-- Style CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
        .filter-links {
            border: 1px dashed #abd373;
            padding: 10px 15px;
            border-radius: 8px;
        }
    </style>

</head>

<body>
    <div class="preloader-activate preloader-active open_tm_preloader">
        <div class="preloader-area-wrap">
            <div class="spinner d-flex justify-content-center align-items-center h-100">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
    <div class="main-wrapper">

        <!-- Begin Main Header Area -->
        <header class="main-header-area">
            <div class="header-top bg-pronia-primary d-none d-lg-block">
                <div class="container py-2">
                    <div class="row align-items-center">
                        <div class="col-6">
                            <div class="header-top-left">
                                <span class="pronia-offer">HELLO EVERYONE! 25% Off All Products</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-middle py-30">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-12">
                            <div class="header-middle-wrap position-relative">
                                <div class="header-contact d-none d-lg-flex">
                                    <i class="pe-7s-call"></i>
                                    <a href="tel://+00-123-456-789">+00 123 456 789</a>
                                </div>
                                <a href="index-2.html" class="header-logo">
                                    <h2>O'pep</h2>
                                </a>
                                <div class="header-right">
                                    <ul>
                                        <li>
                                            <a href="#exampleModal" class="search-btn bt" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="pe-7s-search"></i>
                                            </a>
                                        </li>
                                        <li class="dropdown d-none d-lg-block">
                                            <button class="btn btn-link dropdown-toggle ht-btn p-0" type="button"
                                                id="settingButton" data-bs-toggle="dropdown" aria-label="setting"
                                                aria-expanded="false">
                                                <i class="pe-7s-users"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="settingButton">
                                                <form action="../models/logout.php" method="post">  
                                                    <li><button class="dropdown-item" type="submit" name="logout">Log out</button></li>
                                                </form>
                                                <li><a class="dropdown-item" href="login-register.html">Login |
                                                        Register</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="minicart-wrap me-3 me-lg-0">
                                            <a href="#miniCart" class="minicart-btn toolbar-btn">
                                                <i class="pe-7s-shopbag"></i>
                                                <span class="quantity">3</span>
                                            </a>
                                        </li>
                                        <li class="mobile-menu_wrap d-block d-lg-none">
                                            <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn pl-0">
                                                <i class="pe-7s-menu"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom d-none d-lg-block">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="main-menu position-relative">
                                <nav class="main-nav">
                                    <ul>
                                        <li class="drop-holder">
                                            <a href="index-2.html">Home</a>
                                        </li>
                                        <li class="megamenu-holder">
                                            <a href="shop.html">Shop</a>
                                        </li>
                                        <li class="drop-holder">
                                            <a href="blog.html">Blog</a>
                                        </li>
                                        <li>
                                            <a href="about.html">About Us</a>
                                        </li>
                                        <li>
                                            <a href="contact.html">Contact Us</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-sticky py-4 py-lg-0">
                <div class="container">
                    <div class="header-nav position-relative">
                        <div class="row align-items-center">
                            <div class="col-lg-3 col-6">

                                <a href="index-2.html" class="header-logo">
                                    <h2>O'pep</h2>
                                </a>

                            </div>
                            <div class="col-lg-6 d-none d-lg-block">
                                <div class="main-menu">
                                    <nav class="main-nav">
                                        <ul>
                                            <li class="drop-holder">
                                                <a href="index-2.html">Home</a>
                                            </li>
                                            <li class="megamenu-holder">
                                                <a href="shop.html">Shop</a>
                                            <li>
                                                <a href="contact.html">Contact Us</a>
                                            </li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-lg-3 col-6">
                                <div class="header-right">
                                    <ul>
                                        <li>
                                            <a href="#exampleModal" class="search-btn bt" data-bs-toggle="modal"
                                                data-bs-target="#exampleModal">
                                                <i class="pe-7s-search"></i>
                                            </a>
                                        </li>
                                        <li class="dropdown d-none d-lg-block">
                                            <button class="btn btn-link dropdown-toggle ht-btn p-0" type="button"
                                                id="stickysettingButton" data-bs-toggle="dropdown" aria-label="setting"
                                                aria-expanded="false">
                                                <i class="pe-7s-users"></i>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="stickysettingButton">
                                                <li><a class="dropdown-item" href="my-account.html">My account</a></li>
                                                <li><a class="dropdown-item" href="login-register.html">Login |
                                                        Register</a>
                                                </li>
                                            </ul>
                                        </li>
                                        <li class="minicart-wrap me-3 me-lg-0">
                                            <a href="#miniCart" class="minicart-btn toolbar-btn">
                                                <i class="pe-7s-shopbag"></i>
                                                <span class="quantity">3</span>
                                            </a>
                                        </li>
                                        <li class="mobile-menu_wrap d-block d-lg-none">
                                            <a href="#mobileMenu" class="mobile-menu_btn toolbar-btn pl-0">
                                                <i class="pe-7s-menu"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mobile-menu_wrapper" id="mobileMenu">
                <div class="offcanvas-body">
                    <div class="inner-body">
                        <div class="offcanvas-top">
                            <a href="#" class="button-close"><i class="pe-7s-close"></i></a>
                        </div>
                        <div class="header-contact offcanvas-contact">
                            <i class="pe-7s-call"></i>
                            <a href="tel://+00-123-456-789">+00 123 456 789</a>
                        </div>
                        <div class="offcanvas-user-info">
                            <ul class="dropdown-wrap">
                                <li class="dropdown dropdown-left">
                                    <button class="btn btn-link dropdown-toggle ht-btn" type="button"
                                        id="languageButtonTwo" data-bs-toggle="dropdown" aria-expanded="false">
                                        English
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="languageButtonTwo">
                                        <li><a class="dropdown-item" href="#">French</a></li>
                                        <li><a class="dropdown-item" href="#">Italian</a></li>
                                        <li><a class="dropdown-item" href="#">Spanish</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <button class="btn btn-link dropdown-toggle ht-btn usd-dropdown" type="button"
                                        id="currencyButtonTwo" data-bs-toggle="dropdown" aria-expanded="false">
                                        USD
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="currencyButtonTwo">
                                        <li><a class="dropdown-item" href="#">GBP</a></li>
                                        <li><a class="dropdown-item" href="#">ISO</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <button class="btn btn-link dropdown-toggle ht-btn p-0" type="button"
                                        id="settingButtonTwo" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="pe-7s-users"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="settingButtonTwo">
                                        <li><a class="dropdown-item" href="my-account.html">My account</a></li>
                                        <li><a class="dropdown-item" href="login-register.html">Login | Register</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="wishlist.html">
                                        <i class="pe-7s-like"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="offcanvas-menu_area">
                            <nav class="offcanvas-navigation">
                                <ul class="mobile-menu">
                                    <li class="menu-item-has-children">
                                        <a href="#">
                                            <span class="mm-text">Home
                                                <i class="pe-7s-angle-down"></i>
                                            </span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="index-2.html">
                                                    <span class="mm-text">Home One</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="index-3.html">
                                                    <span class="mm-text">Home Two</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">
                                            <span class="mm-text">Shop
                                                <i class="pe-7s-angle-down"></i>
                                            </span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="menu-item-has-children">
                                                <a href="#">
                                                    <span class="mm-text">Shop Layout
                                                        <i class="pe-7s-angle-down"></i>
                                                    </span>
                                                </a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        <a href="shop.html">
                                                            <span class="mm-text">Shop Default</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-grid-fullwidth.html">
                                                            <span class="mm-text">Shop Grid Fullwidth</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-right-sidebar.html">
                                                            <span class="mm-text">Shop Right Sidebar</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-list-fullwidth.html">
                                                            <span class="mm-text">Shop List Fullwidth</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-list-left-sidebar.html">
                                                            <span class="mm-text">Shop List Left Sidebar</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="shop-list-right-sidebar.html">
                                                            <span class="mm-text">Shop List Right Sidebar</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">
                                                    <span class="mm-text">Product Style
                                                        <i class="pe-7s-angle-down"></i>
                                                    </span>
                                                </a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        <a href="single-product.html">
                                                            <span class="mm-text">Single Product Default</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-group.html">
                                                            <span class="mm-text">Single Product Group</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-variable.html">
                                                            <span class="mm-text">Single Product Variable</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-sale.html">
                                                            <span class="mm-text">Single Product Sale</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-sticky.html">
                                                            <span class="mm-text">Single Product Sticky</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="single-product-affiliate.html">
                                                            <span class="mm-text">Single Product Affiliate</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li class="menu-item-has-children">
                                                <a href="#">
                                                    <span class="mm-text">Product Related
                                                        <i class="pe-7s-angle-down"></i>
                                                    </span>
                                                </a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        <a href="my-account.html">
                                                            <span class="mm-text">My Account</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="login-register.html">
                                                            <span class="mm-text">Login | Register</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="cart.html">
                                                            <span class="mm-text">Shopping Cart</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="wishlist.html">
                                                            <span class="mm-text">Wishlist</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="compare.html">
                                                            <span class="mm-text">Compare</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="checkout.html">
                                                            <span class="mm-text">Checkout</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">
                                            <span class="mm-text">Blog
                                                <i class="pe-7s-angle-down"></i>
                                            </span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li class="menu-item-has-children">
                                                <a href="#">
                                                    <span class="mm-text">Blog Holder
                                                        <i class="pe-7s-angle-down"></i>
                                                    </span>
                                                </a>
                                                <ul class="sub-menu">
                                                    <li>
                                                        <a href="blog.html">
                                                            <span class="mm-text">Blog Default</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a href="blog-listview.html">Blog List View</a>
                                                    </li>
                                                    <li>
                                                        <a href="blog-detail.html">Blog Detail</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="about.html">
                                            <span class="mm-text">About Us</span>
                                        </a>
                                    </li>
                                    <li class="menu-item-has-children">
                                        <a href="#">
                                            <span class="mm-text">Pages
                                                <i class="pe-7s-angle-down"></i>
                                            </span>
                                        </a>
                                        <ul class="sub-menu">
                                            <li>
                                                <a href="faq.html">
                                                    <span class="mm-text">Frequently Questions</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="404.html">
                                                    <span class="mm-text">Error 404</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <a href="contact.html">
                                            <span class="mm-text">Contact</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModal" aria-hidden="true">
                <div class="modal-dialog modal-fullscreen">
                    <div class="modal-content modal-bg-dark">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                data-tippy="Close" data-tippy-inertia="true" data-tippy-animation="shift-away"
                                data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="modal-search">
                                <span class="searchbox-info">Start typing and press Enter to search or ESC to
                                    close</span>
                                <form action="" method="post" class="hm-searchbox">
                                    <input type="text" name="Search" value="Search...">
                                    <button class="search-btn" name="btn-search" type="submit" aria-label="searchbtn">
                                        <i class="pe-7s-search"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="offcanvas-minicart_wrapper" id="miniCart">
                <div class="offcanvas-body">
                    <div class="minicart-content">
                        <div class="minicart-heading">
                            <h4 class="mb-0">Shopping Cart</h4>
                            <a href="#" class="button-close"><i class="pe-7s-close" data-tippy="Close"
                                    data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50"
                                    data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></a>
                        </div>
                        <ul class="minicart-list">
                            <?php
                            $cart_elements = select_cart_elements();
                            if ($cart_elements > 0){
                             foreach ($cart_elements as $cart_element) { ?>
                                <li class="minicart-product">
                                    <a class="product-item_remove" href="../models/addtoCart.php?id=<?php $cart_element["plant_id"]?>"><i class="pe-7s-close" data-tippy="Remove" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder"></i></a>
                                    <a href="single-product-variable.html" class="product-item_img">
                                        <img class="img-full" src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($cart_element['plant_image']);?>"
                                             alt="Product Image">
                                    </a>
                                    <div class="product-item_content">
                                        <a class="product-item_title" href="single-product-variable.html"><?= $cart_element["plant_name"] ?></a>
                                        <span class="product-item_quantity">1 x $<?= $cart_element["plant_price"];?></span>
                                    </div>
                                   <!-- <form action="../models/checkout.php" method="post">
                                        <input type="hidden" name="checked_plant_id" value="<?php// $cart_element["plant_id"] ?>" >
                                        <button type="submit" name="check_one">make order now</button>
                                    </form>-->
                                </li>
                            <?php }
                            } else{ ?>
                                <li class="minicart-product">
                                   <p>cart is empty</p>
                                 </li>
                          <?php  }?>
                        </ul>
                    </div>
                    <div class="minicart-item_total">
                        <span>Subtotal</span>
                        <span class="ammount">$<?php $total = cart_total();
                            echo $total["total_price"];?></span>
                    </div>
                    <div class="group-btn_wrap d-grid gap-2">
                        <form action="../models/checkout.php" method="post">
                            <input type="hidden" name="cart_id" value="<?=$_SESSION["cart_id"]; ?>">
                            <button name="checkout_all" class="btn btn-dark">Checkout</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="global-overlay"></div>
        </header>
        <!-- Main Header Area End Here -->

        <!-- Begin Slider Area -->
        <div class="slider-area">

            <!-- Main Slider -->
            <div class="swiper-container main-slider swiper-arrow with-bg_white">
                <div class="swiper-wrapper">
                    <div class="swiper-slide animation-style-01">
                        <div class="slide-inner style-1 bg-height" data-bg-image="assets/images/slider/bg/1-1.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 order-2 order-lg-1 align-self-center">
                                        <div class="slide-content text-black">
                                            <span class="offer">65% Off</span>
                                            <h2 class="title">New Plant</h2>
                                            <p class="short-desc">Pronia, With 100% Natural, Organic & Plant Shop.</p>
                                            <div class="btn-wrap">
                                                <a class="btn btn-custom-size xl-size btn-pronia-primary"
                                                    href="shop.html">Discover Now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-0 order-1 order-lg-2">
                                        <div class="inner-img">
                                            <div class="scene fill">
                                                <div class="expand-width" data-depth="0.2">
                                                    <img src="assets/images/slider/inner-img/1-1-524x617.png"
                                                        alt="Inner Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide animation-style-01">
                        <div class="slide-inner style-1 bg-height" data-bg-image="assets/images/slider/bg/1-1.jpg">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-6 order-2 order-lg-1 align-self-center">
                                        <div class="slide-content text-black">
                                            <span class="offer">65% Off</span>
                                            <h2 class="title">New Plant</h2>
                                            <p class="short-desc">Pronia, With 100% Natural, Organic & Plant Shop.</p>
                                            <div class="btn-wrap">
                                                <a class="btn btn-custom-size xl-size btn-pronia-primary"
                                                    href="shop.html">Discover Now</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-8 offset-md-2 offset-lg-0 order-1 order-lg-2">
                                        <div class="inner-img">
                                            <div class="scene fill">
                                                <div class="expand-width" data-depth="0.2">
                                                    <img src="assets/images/slider/inner-img/1-2-524x617.png"
                                                        alt="Inner Image">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Add Pagination -->
                <div class="swiper-pagination d-md-none"></div>

                <!-- Add Arrows -->
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
            </div>

        </div>
        <!-- Slider Area End Here -->

        <!-- Begin Shipping Area -->
        <div class="shipping-area section-space-top-100">
            <div class="container">
                <div class="shipping-bg">
                    <div class="row shipping-wrap">
                        <div class="col-lg-4 col-md-6">
                            <div class="shipping-item">
                                <div class="shipping-img">
                                    <img src="assets/images/shipping/icon/car.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h2 class="title">Free Shipping</h2>
                                    <p class="short-desc mb-0">Capped at $319 per order</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-4 mt-md-0">
                            <div class="shipping-item">
                                <div class="shipping-img">
                                    <img src="assets/images/shipping/icon/card.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h2 class="title">Safe Payment</h2>
                                    <p class="short-desc mb-0">With our payment gateway</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-6 mt-4 mt-lg-0">
                            <div class="shipping-item">
                                <div class="shipping-img">
                                    <img src="assets/images/shipping/icon/service.png" alt="Shipping Icon">
                                </div>
                                <div class="shipping-content">
                                    <h2 class="title">Best Services</h2>
                                    <p class="short-desc mb-0">Friendly & Supper Services</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Shipping Area End Here -->

        <!-- Begin Product Area -->
        <div class="product-area section-space-top-100">
            <div class="container">
                <div class="section-title-wrap">
                    <h2 class="section-title mb-0">Our Products</h2>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <ul class="nav product-tab-nav gap-2 tab-style-1" id="myTab" role="tablist">
                            <a href="http://localhost/O-pep/template" class="filter-links">view all</a>
                            <?php foreach ($catRows as $catRow) { ?>
                                <a class="filter-links"
                                    href="http://localhost/O-pep/template?id=<?= $catRow["category_id"] ?>">
                                    <?php echo $catRow ? $catRow["category_name"] : "null" ?>
                                </a>
                            <?php } ?>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="featured" role="tabpanel"
                                aria-labelledby="featured-tab">
                                <div class="product-item-wrap row">
                                    <?php foreach ($rows as $row) {
                                        ?>
                                        <div class="col-xl-3 col-md-4 col-sm-6">
                                            <div class="product-item">
                                                <div class="product-img">
                                                    <a href="shop.html">
                                                        <img class="primary-img"
                                                            src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['plant_image']); ?>"
                                                            alt="Product Images">
                                                    </a>
                                                    <div class="product-add-action">
                                                        <ul>
                                                            
                                                            <li>
                                                            <form action="../models/addtoCart.php" method="get">
                                                                <input type="hidden" name="plant_id" value="<?= $row["plant_id"]?>">
                                                                <button data-tippy="Add to cart" class="add-btn" style="border: none;background: #F4F4F4;"
                                                                    data-tippy-inertia="true"
                                                                    data-tippy-animation="shift-away" data-tippy-delay="50"
                                                                    data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                                    <i class="pe-7s-cart"></i>
                                                                </button>
                                                            </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="product-content">
                                                    <a class="product-name" href="shop.html">
                                                        <?= $row["plant_name"] ?>
                                                    </a>
                                                    <p>
                                                        <?= $row["plant_desc"] ?>
                                                    </p>
                                                    <div class="price-box pb-1">
                                                        <span class="new-price">$
                                                            <?= $row["plant_price"] ?>
                                                        </span>
                                                    </div>
                                                    <div class="rating-box">
                                                        <ul>
                                                            <li><i class="fa fa-star"></i></li>
                                                            <li><i class="fa fa-star"></i></li>
                                                            <li><i class="fa fa-star"></i></li>
                                                            <li><i class="fa fa-star"></i></li>
                                                            <li><i class="fa fa-star"></i></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php
                                    } ?>

                                </div>
                            </div>
                            <div class="tab-pane fade" id="bestseller" role="tabpanel" aria-labelledby="bestseller-tab">
                                <div class="product-item-wrap row">

                                </div>
                            </div>
                            <div class="tab-pane fade" id="latest" role="tabpanel" aria-labelledby="latest-tab">
                                <div class="product-item-wrap row">
                                    <div class="col-xl-3 col-md-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <a href="shop.html">
                                                    <img class="primary-img"
                                                        src="assets/images/product/medium-size/1-7-270x300.jpg"
                                                        alt="Product Images">
                                                    <img class="secondary-img"
                                                        src="assets/images/product/medium-size/1-8-270x300.jpg"
                                                        alt="Product Images">
                                                </a>
                                                <div class="product-add-action">
                                                    <ul>
                                                        
                                                        <li>
                                                            <a href="" data-tippy="Add to cart"
                                                                data-tippy-inertia="true"
                                                                data-tippy-animation="shift-away" data-tippy-delay="50"
                                                                data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                                <i class="pe-7s-cart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <a class="product-name" href="shop.html">Doublefile Viburnum</a>
                                                <div class="price-box pb-1">
                                                    <span class="new-price">$67.45</span>
                                                </div>
                                                <div class="rating-box">
                                                    <ul>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                        <li><i class="fa fa-star"></i></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Product Area End Here -->

        <!-- Begin Banner Area -->
        <div class="banner-area section-space-top-90">
            <div class="container">
                <div class="row g-min-30 g-4">
                    <div class="col-lg-8">
                        <div class="banner-item img-hover-effect">
                            <div class="banner-img">
                                <img src="assets/images/banner/1-1-770x300.jpg" alt="Banner Image">
                            </div>
                            <div class="banner-content text-position-left">
                                <span class="collection">Collection Of Cactus</span>
                                <h3 class="title">Pottery Pots & <br> Plant</h3>
                                <div class="button-wrap">
                                    <a class="btn btn-custom-size btn-pronia-primary" href="shop.html">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-item img-hover-effect">
                            <div class="banner-img">
                                <img src="assets/images/banner/1-2-370x300.jpg" alt="Banner Image">
                            </div>
                            <div class="banner-content text-position-center">
                                <span class="collection">New Collection</span>
                                <h3 class="title">Plant Port</h3>
                                <div class="button-wrap">
                                    <a class="btn btn-custom-size lg-size btn-pronia-primary" href="shop.html">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="banner-item img-hover-effect">
                            <div class="banner-img">
                                <img src="assets/images/banner/1-3-370x300.jpg" alt="Banner Image">
                            </div>
                            <div class="banner-content text-position-center">
                                <span class="collection">New Collection</span>
                                <h3 class="title">Plant Port</h3>
                                <div class="button-wrap">
                                    <a class="btn btn-custom-size lg-size btn-pronia-primary" href="shop.html">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="banner-item img-hover-effect">
                            <div class="banner-img">
                                <img src="assets/images/banner/1-4-770x300.jpg" alt="Banner Image">
                            </div>
                            <div class="banner-content text-position-left">
                                <span class="collection">Collection Of Cactus</span>
                                <h3 class="title">Hanging Pots & <br> Plant</h3>
                                <div class="button-wrap">
                                    <a class="btn btn-custom-size lg-size btn-pronia-primary" href="shop.html">Shop
                                        Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Banner Area End Here -->

        <!-- Begin Testimonial Area -->
        <div class="testimonial-area section-space-top-90 section-space-bottom-95">
            <div class="container-fluid">
                <div class="testimonial-bg" data-bg-image="assets/images/testimonial/bg/1-1-1820x443.jpg">
                    <div class="section-title-wrap">
                        <h2 class="section-title">What Say Client</h2>
                        <p class="section-desc mb-0">Contrary to popular belief, Lorem Ipsum is not simply random
                            text. It has roots in a piece of classical Latin literature
                        </p>
                    </div>
                </div>
                <div class="container custom-space">
                    <div class="swiper-container testimonial-slider with-bg">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide testimonial-item">
                                <div class="user-info mb-3">
                                    <div class="user-shape-wrap">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/user/1.png" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="user-content text-charcoal">
                                        <h4 class="user-name mb-1">Phoenix Baker</h4>
                                        <span class="user-occupation">Client</span>
                                    </div>
                                </div>
                                <p class="user-comment mb-6">Lorem ipsum dolor sit amet, conse adipisic elit, sed do
                                    eiusmod
                                    tempo
                                    incididunt ut labore et dolore. magna
                                </p>
                            </div>
                            <div class="swiper-slide testimonial-item">
                                <div class="user-info mb-3">
                                    <div class="user-shape-wrap">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/user/2.png" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="user-content text-charcoal">
                                        <h4 class="user-name mb-1">Phoenix Baker</h4>
                                        <span class="user-occupation">Client</span>
                                    </div>
                                </div>
                                <p class="user-comment mb-6">Lorem ipsum dolor sit amet, conse adipisic elit, sed do
                                    eiusmod
                                    tempo
                                    incididunt ut labore et dolore. magna
                                </p>
                            </div>
                            <div class="swiper-slide testimonial-item">
                                <div class="user-info mb-3">
                                    <div class="user-shape-wrap">
                                        <div class="user-img">
                                            <img src="assets/images/testimonial/user/3.png" alt="User Image">
                                        </div>
                                    </div>
                                    <div class="user-content text-charcoal">
                                        <h4 class="user-name mb-1">Phoenix Baker</h4>
                                        <span class="user-occupation">Client</span>
                                    </div>
                                </div>
                                <p class="user-comment mb-6">Lorem ipsum dolor sit amet, conse adipisic elit, sed do
                                    eiusmod
                                    tempo
                                    incididunt ut labore et dolore. magna
                                </p>
                            </div>
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination without-absolute"></div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Testimonial Area End Here -->

        <!-- Begin Footer Area -->
        <div class="footer-area" data-bg-image="assets/images/footer/bg/1-1920x465.jpg">
            <div class="footer-top section-space-top-100 pb-60">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="footer-widget-item">
                                <div class="footer-widget-logo">
                                    <a href="index-2.html">
                                        <h2>O'pep</h2>
                                    </a>
                                </div>
                                <p class="footer-widget-desc">Lorem ipsum dolor sit amet, consec adipisl elit, sed do
                                    eiusmod
                                    tempor
                                    <br>
                                    incidio ut labore et dolore magna.
                                </p>
                                <div class="social-link with-border">
                                    <ul>
                                        <li>
                                            <a href="#" data-tippy="Facebook" data-tippy-inertia="true"
                                                data-tippy-animation="shift-away" data-tippy-delay="50"
                                                data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                <i class="fa fa-facebook"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-tippy="Twitter" data-tippy-inertia="true"
                                                data-tippy-animation="shift-away" data-tippy-delay="50"
                                                data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                <i class="fa fa-twitter"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-tippy="Pinterest" data-tippy-inertia="true"
                                                data-tippy-animation="shift-away" data-tippy-delay="50"
                                                data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                <i class="fa fa-pinterest"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#" data-tippy="Dribbble" data-tippy-inertia="true"
                                                data-tippy-animation="shift-away" data-tippy-delay="50"
                                                data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                <i class="fa fa-dribbble"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 pt-40">
                            <div class="footer-widget-item">
                                <h3 class="footer-widget-title">Useful Links</h3>
                                <ul class="footer-widget-list-item">
                                    <li>
                                        <a href="#">About Pronia</a>
                                    </li>
                                    <li>
                                        <a href="#">How to shop</a>
                                    </li>
                                    <li>
                                        <a href="#">FAQ</a>
                                    </li>
                                    <li>
                                        <a href="#">Contact us</a>
                                    </li>
                                    <li>
                                        <a href="#">Log in</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 pt-40">
                            <div class="footer-widget-item">
                                <h3 class="footer-widget-title">My Account</h3>
                                <ul class="footer-widget-list-item">
                                    <li>
                                        <a href="#">Sign In</a>
                                    </li>
                                    <li>
                                        <a href="#">View Cart</a>
                                    </li>
                                    <li>
                                        <a href="#">My Wishlist</a>
                                    </li>
                                    <li>
                                        <a href="#">Track My Order</a>
                                    </li>
                                    <li>
                                        <a href="#">Help</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 pt-40">
                            <div class="footer-widget-item">
                                <h3 class="footer-widget-title">Our Service</h3>
                                <ul class="footer-widget-list-item">
                                    <li>
                                        <a href="#">Payment Methods</a>
                                    </li>
                                    <li>
                                        <a href="#">Money Guarantee!</a>
                                    </li>
                                    <li>
                                        <a href="#">Returns</a>
                                    </li>
                                    <li>
                                        <a href="#">Shipping</a>
                                    </li>
                                    <li>
                                        <a href="#">Privacy Policy</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 pt-40">
                            <div class="footer-contact-info">
                                <h3 class="footer-widget-title">Got Question? Call Us</h3>
                                <a class="number" href="tel://123-456-789">123 456 789</a>
                                <div class="address">
                                    <ul>
                                        <li>
                                            Your Address Goes Here
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="payment-method">
                                <a href="#">
                                    <img src="assets/images/payment/1.png" alt="Payment Method">
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="copyright">
                                <span class="copyright-text">© 2021 Pronia Made with <i
                                        class="fa fa-heart text-danger"></i> by
                                    <a href="https://hasthemes.com/" rel="noopener" target="_blank">HasThemes</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Footer Area End Here -->



        <!-- Begin Modal Area -->
        <div class="modal quick-view-modal fade" id="quickModal" data-bs-backdrop="static" data-bs-keyboard="false"
            tabindex="-1" aria-labelledby="quickModal" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            data-tippy="Close" data-tippy-inertia="true" data-tippy-animation="shift-away"
                            data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="modal-wrap row">
                            <div class="col-lg-6">
                                <div class="modal-img">
                                    <div class="swiper-container modal-slider">
                                        <div class="swiper-wrapper">
                                            <div class="swiper-slide">
                                                <a href="#" class="single-img">
                                                    <img class="img-full"
                                                        src="assets/images/product/large-size/1-1-570x633.jpg"
                                                        alt="Product Image">
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="#" class="single-img">
                                                    <img class="img-full"
                                                        src="assets/images/product/large-size/1-2-570x633.jpg"
                                                        alt="Product Image">
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="#" class="single-img">
                                                    <img class="img-full"
                                                        src="assets/images/product/large-size/1-3-570x633.jpg"
                                                        alt="Product Image">
                                                </a>
                                            </div>
                                            <div class="swiper-slide">
                                                <a href="#" class="single-img">
                                                    <img class="img-full"
                                                        src="assets/images/product/large-size/1-4-570x633.jpg"
                                                        alt="Product Image">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6 pt-5 pt-lg-0">
                                <div class="single-product-content">
                                    <h2 class="title">American Marigold</h2>
                                    <div class="price-box">
                                        <span class="new-price">$23.45</span>
                                    </div>
                                    <div class="rating-box-wrap">
                                        <div class="rating-box">
                                            <ul>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                                <li><i class="fa fa-star"></i></li>
                                            </ul>
                                        </div>
                                        <div class="review-status">
                                            <a href="#">( 1 Review )</a>
                                        </div>
                                    </div>
                                    <div class="selector-wrap color-option">
                                        <span class="selector-title border-bottom-0">Color</span>
                                        <select class="nice-select wide border-bottom-0 rounded-0">
                                            <option value="default">Black & White</option>
                                            <option value="blue">Blue</option>
                                            <option value="green">Green</option>
                                            <option value="red">Red</option>
                                        </select>
                                    </div>
                                    <div class="selector-wrap size-option">
                                        <span class="selector-title">Size</span>
                                        <select class="nice-select wide rounded-0">
                                            <option value="medium">Medium Size & Poot</option>
                                            <option value="large">Large Size With Poot</option>
                                            <option value="small">Small Size With Poot</option>
                                        </select>
                                    </div>
                                    <p class="short-desc">Lorem ipsum dolor sit amet, consectetur adipisic elit, sed do
                                        eiusmod
                                        tempo incid ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis
                                        nostru
                                        exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute
                                        irure
                                        dolor
                                        in reprehenderit in voluptate</p>
                                    <ul class="quantity-with-btn">
                                        <li class="quantity">
                                            <div class="cart-plus-minus">
                                                <input class="cart-plus-minus-box" value="1" type="text">
                                            </div>
                                        </li>
                                        <li class="add-to-cart">
                                            <a class="btn btn-custom-size lg-size btn-pronia-primary"
                                                href="cart.html">Add to
                                                cart</a>
                                        </li>
                                        <li class="wishlist-btn-wrap">
                                            <a class="custom-circle-btn" href="wishlist.html">
                                                <i class="pe-7s-like"></i>
                                            </a>
                                        </li>
                                        <li class="compare-btn-wrap">
                                            <a class="custom-circle-btn" href="compare.html">
                                                <i class="pe-7s-refresh-2"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <ul class="service-item-wrap pb-0">
                                        <li class="service-item">
                                            <div class="service-img">
                                                <img src="assets/images/shipping/icon/car.png" alt="Shipping Icon">
                                            </div>
                                            <div class="service-content">
                                                <span class="title">Free <br> Shipping</span>
                                            </div>
                                        </li>
                                        <li class="service-item">
                                            <div class="service-img">
                                                <img src="assets/images/shipping/icon/card.png" alt="Shipping Icon">
                                            </div>
                                            <div class="service-content">
                                                <span class="title">Safe <br> Payment</span>
                                            </div>
                                        </li>
                                        <li class="service-item">
                                            <div class="service-img">
                                                <img src="assets/images/shipping/icon/service.png" alt="Shipping Icon">
                                            </div>
                                            <div class="service-content">
                                                <span class="title">Safe <br> Payment</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal Area End Here -->
        <!-- Begin Scroll To Top -->
        <a class="scroll-to-top" href="#">
            <i class="fa fa-angle-double-up"></i>
        </a>
        <!-- Scroll To Top End Here -->

    </div>

    <!-- Global Vendor, plugins JS -->

    <!-- JS Files
    ============================================ -->

    <script src="assets/js/vendor/bootstrap.bundle.min.js"></script>
    <script src="assets/js/vendor/jquery-3.6.0.min.js"></script>
    <script src="assets/js/vendor/jquery-migrate-3.3.2.min.js"></script>
    <script src="assets/js/vendor/jquery.waypoints.js"></script>
    <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>
    <script src="assets/js/plugins/wow.min.js"></script>
    <script src="assets/js/plugins/swiper-bundle.min.js"></script>
    <script src="assets/js/plugins/jquery.nice-select.js"></script>
    <script src="assets/js/plugins/parallax.min.js"></script>
    <script src="assets/js/plugins/jquery.magnific-popup.min.js"></script>
    <script src="assets/js/plugins/tippy.min.js"></script>
    <script src="assets/js/plugins/ion.rangeSlider.min.js"></script>
    <script src="assets/js/plugins/mailchimp-ajax.js"></script>
    <script src="assets/js/plugins/jquery.counterup.js"></script>

    <!--Main JS (Common Activation Codes)-->
    <script src="assets/js/main.js"></script>

</body>


<!-- Mirrored from htmldemo.net/pronia/pronia/ by HTTrack Website Copier/3.x [XR&CO'2014], Sun, 26 Nov 2023 20:49:07 GMT -->

</html>