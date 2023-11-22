<?php
include("../config/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["register"])) {
        validate();
    }
}

function validate()
{
    $first_name = filter_input(INPUT_POST, "first_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $last_name = filter_input(INPUT_POST, "last_name", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $adress = filter_input(INPUT_POST, "adress", FILTER_SANITIZE_SPECIAL_CHARS);
    $pwd = $_POST['pwd'];
    $pwd2 = $_POST['pwd2'];

    if (!$first_name || !$last_name || !$email || !$adress) {
        header('Location: ../?error_msg=incorrect_information');
        exit();
    } elseif (empty($pwd) || empty($pwd2)) {
        header('Location: ../?error_msg=empty_password');
        exit();
    } elseif ($pwd !== $pwd2) {
        header('Location: ../?error_msg=passwords_not_equal');
        exit();
    } else {
        $hashedPwd = hashing_func($pwd);
        insertUserInfo($first_name, $last_name, $email, $hashedPwd, $adress);
    }
}

function hashing_func($password)
{
    $options = ['cost' => 12];
    return password_hash($password, PASSWORD_BCRYPT, $options);
}

function insertUserInfo($first_name, $last_name, $email, $hashedPwd, $adress)
{
    global $pdo; 

    $query = "INSERT INTO users (first_name, last_name, email, password, adresse) VALUES (?, ?, ?, ?, ?);";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(1, $first_name, PDO::PARAM_STR);
    $stmt->bindParam(2, $last_name, PDO::PARAM_STR);
    $stmt->bindParam(3, $email, PDO::PARAM_STR);
    $stmt->bindParam(4, $hashedPwd, PDO::PARAM_STR);
    $stmt->bindParam(5, $adress, PDO::PARAM_STR);
    

    if ($stmt->execute()) {
        header('Location: ../?success_msg=registration_successful');
        exit();
    } else {
        header('Location: ../?error_msg=registration_failed');
        exit();
    }
}
