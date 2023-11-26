<?php
include('../config/db.php');

if(isset($_POST["update_form"])){
    insertUpdatedProduct();
}

function insertUpdatedProduct(){
    global $pdo;
    $tmp_name =  file_get_contents($_FILES['productImg']['tmp_name']);
    $query = "UPDATE plant SET plant_name = :pname, plant_desc = :pdesc, plant_price = :pprice, category_id = :category_id where  plant_id = :id;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pname', $_POST["plant_name"], PDO::PARAM_STR);
    $stmt->bindParam(':pdesc', $_POST["plant_desc"], PDO::PARAM_STR);
    $stmt->bindParam(':pprice', $_POST["plant_price"], PDO::PARAM_INT);
    $stmt->bindParam(':category_id', $_POST["category"], PDO::PARAM_INT);
    $stmt->bindParam(':plant_image', $tmp_name, PDO::PARAM_LOB);

    $stmt->execute();
    header('location: ../pages/dashboard.php');
    exit();
}