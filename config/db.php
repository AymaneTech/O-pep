<?php

$dsn = "mysql:host=localhost; dbname=opep";
$username = "root";
$pd = "";
try {
    $pdo = new PDO($dsn, $username, $pd);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die ("connection to db failed homie !!! " . $e->getMessage());
}
