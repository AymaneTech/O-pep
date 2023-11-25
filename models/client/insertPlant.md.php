<?php
include ("../../config/db.php");
insertProduct();
function insertProduct()
{
    global $pdo;
    $query = "SELECT * FROM plant;";
    $stmt = $pdo->prepare($query);
    if ($stmt->execute()) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {

        }
    }
}