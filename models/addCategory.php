<?php
include("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if(isset($_POST["categoryName"])){
        insertCategory();
        header("location: ../pages/cat_admin.php");
    }
}
function insertCategory()
{
    global $pdo;
    $categoryName = $_POST["categoryName"];
    $categoryDesc = $_POST["categoryDesc"];

    $query = "INSERT INTO category (category_name, category_desc) VALUES (:category_name, :category_desc);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':category_name', $categoryName, PDO::PARAM_STR);
    $stmt->bindParam(':category_desc', $categoryDesc, PDO::PARAM_STR);

    $stmt->execute();
}