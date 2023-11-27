<?php
include ("../../config/db.php");
print_r($_POST);
insertProduct();
function insertProduct()
{
    global $pdo;
    $query = "SELECT * FROM plant;";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            ?>
            <div class="col-xl-3 col-md-4 col-sm-6">
                                        <div class="product-item">
                                            <div class="product-img">
                                                <a href="shop.html">
                                                    <img class="primary-img" src="assets/images/product/medium-size/1-1-270x300.jpg" alt="Product Images">
                                                    <img class="secondary-img" src="assets/images/product/medium-size/1-2-270x300.jpg" alt="Product Images">
                                                </a>
                                                <div class="product-add-action">
                                                    <ul>                                
                                                        <li class="quuickview-btn" data-bs-toggle="modal" data-bs-target="#quickModal">
                                                            <a href="#" data-tippy="Quickview" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                                <i class="pe-7s-look"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="cart.html" data-tippy="Add to cart" data-tippy-inertia="true" data-tippy-animation="shift-away" data-tippy-delay="50" data-tippy-arrow="true" data-tippy-theme="sharpborder">
                                                                <i class="pe-7s-cart"></i>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-content">
                                                <a class="product-name" href="shop.html"><?=$row["plant_name"]?></a>
                                                <div class="price-box pb-1">
                                                    <span class="new-price">$<?=$row["plant_price"]?></span>
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
        }
    }
}