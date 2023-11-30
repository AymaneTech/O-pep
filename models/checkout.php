<?php
include("../config/db.php");
session_start();

if(isset($_POST["checkout_all"])){
    insert_all_order();
}elseif(isset($_POST["check_one"])){
    insert_one_order();
}
function insert_one_order(){

}

function insert_all_order(){
    global $pdo;
    $cart_id = $_SESSION["cart_id"];
    $query = "INSERT INTO orders (pivot_fk) values (:cart_id);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(":cart_id", $cart_id, PDO::PARAM_INT);
    $stmt->execute();
    header("location: ../template?msg=checkout success");
}

