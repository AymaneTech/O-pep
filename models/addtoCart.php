<?php
include ("../config/db.php");
checkCartExisting();
function checkCartExisting(){
    global $pdo;
    session_start();
    $user_id = $_SESSION["id"];
    $query = "SELECT * FROM carts WHERE users_fk = :user_id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam("user_id", $user_id, PDO::PARAM_STR);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($row > 1){
        addPlant_id
    }else{

    }
}