<?php
include('../config/db.php');
if (isset($_GET["id"])) {
    deleteCategory();
}
function deleteCategory()
{
    global $pdo;
    $id = $_GET['id'];
    $query = "DELETE FROM category where category_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    header('location: ../pages/cat_admin.php');
}