<?php
include ("../config/db.php");

session_start();
$plant_id = (int)$_GET["plant_id"];
$user_id = $_SESSION["id"];

// this function check if this client  already have a cart
function checkCartExisting($user_id){
    global $pdo;
    $query = "SELECT cart_id FROM carts WHERE users_fk = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $cart_id = $stmt->fetch(PDO::FETCH_COLUMN);
    return $cart_id;
}
// we use this cart when the client already have a cart
function already_have_cart($cart_id,$plant_id){
    global $pdo;
    $query = "INSERT INTO cart_plant (cart_id, plant_id) VALUES (:cart_id, :plant_id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':cart_id', $cart_id, PDO::PARAM_INT);
    $stmt->bindParam(':plant_id', $plant_id, PDO::PARAM_INT);
    if($stmt->execute()){
        echo "i insert by already_have acart";
    }else{
        echo "query not executed";
    }
}

// and this function work when the user have no cart we create for him a cart
function create_cart_for_user(){
    try {
        global $pdo;
        $plant_id = (int)$_GET["plant_id"];
        $user_id = $_SESSION["id"];            $query = "INSERT INTO carts (car_amount,plant_fk, users_fk)  VALUES (1,:plant_fk, :user_fk)";
            $stmt = $pdo->prepare($query);
            $stmt->bindParam(':plant_fk', $plant_id, PDO::PARAM_INT);
            $stmt->bindParam(':user_fk', $user_id, PDO::PARAM_INT);
            $stmt->execute();
            echo "Insertion successful";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }

}
// and this is the function that decide wich function will work depending the result of check car existing function
function main_fuction($user_id, $plant_id){
    $cart_id = checkCartExisting($user_id);
    if ($cart_id > 0) {
        already_have_cart($cart_id, $plant_id);
    } else {
        create_cart_for_user();
    }
    header("location: ../template?status=added successfly to cart");
}
main_fuction($user_id, $plant_id);
