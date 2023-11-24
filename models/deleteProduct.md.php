<?php
include ('../config/db.php');

if(isset($_GET["id"])){
    deleteProduct();
}
function deleteProduct(){
    global $pdo;
    $id = $_GET['id'];
    $query = "DELETE FROM plant where plant_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('location: ../pages/dashboard.php');
}