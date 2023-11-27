<?php
include ("../config/db.php");

session_start();
$plant_id = $_GET["plant_id"];
$user_id = $_SESSION["id"];
checkCartExisting($user_id);
function checkCartExisting($user_id){
    global $pdo;
    $query = "SELECT cart_id FROM carts WHERE users_fk = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $cart_id = $stmt->fetch(PDO::FETCH_ASSOC);
    return $cart_id;
}

function create_cartPlant($cart_id,$plant_id){
    global $pdo;
    $query = "INSERT INTO cart_plant (cart_id, plant_id) VALUES (:cart_id, :plant_id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $stmt->bindParam(':plant_id', $plant_id, PDO::PARAM_INT);
    $stmt->execute();
}
function add_plant_to_cart($user_id, $plant_id){
    $cart_id = checkCartExisting($user_id);
    if ($cart_id > 0) {
        create_cartPlant($cart_id,$plant_id);
    } else {
        // addJustPlant();
        create_cartPlant($cart_id,$plant_id);
    }
}