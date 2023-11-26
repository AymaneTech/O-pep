<?php
include('../config/db.php');

if(isset())
$id = $_GET['id'];
function selectProductToUpdate()
{
    global $pdo;
    $query = "SELECT * FROM plant where plant_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
} 
function insertUpdatedProduct(){
    global $pdo;
    $query = "UPDATE plant SET plant_name = :pname, plant_desc = :pdesc, plant_price = :pprice, plnat_image = :pimage, category_id = :category_id where  plant_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':pname', $productName, PDO::PARAM_STR);
    $stmt->bindParam(':pdesc', $productDesc, PDO::PARAM_STR);
    $stmt->bindParam(':pprice', $productPrice, PDO::PARAM_INT);
    $stmt->bindParam(':pimage', $tmp_name, PDO::PARAM_LOB);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    $stmt->execute();
}