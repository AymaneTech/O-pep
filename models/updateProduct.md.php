<?php
include('../config/db.php');
function selectProductToUpdate()
{
    global $pdo;
    $id = $_GET['id'];
    $query = "SELECT * FROM plant where plant_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    header("location: ../pages/update.php");
    return $stmt->fetch(PDO::FETCH_ASSOC);
} 