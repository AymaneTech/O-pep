<?php
include("../config/db.php");
$email = $_POST["email"];
$passwordLogin = $_POST["password"];

if (isset($_POST["login-btn"])) {
    validate($email);
}

function validate($email)
{
    global $row;
    if (empty($_POST['email']) || empty($_POST["password"])) {
        header('location: ../pages/login.php');
    } else {
        $row = checkAccountExisting($email);
        if (password_verify($_POST["password"], $row["password"])){
            if ($row["role_id"]==1){

                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $row["password"];
                $_SESSION["role"] = $row["role_id"];
                $_SESSION["id"] = $row["user_id"];

                header("location: ../template");
            }else if($row["role_id"]==2){

                session_start();
                $_SESSION["email"] = $email;
                $_SESSION["password"] = $_POST["password"];
                $_SESSION["role"] = $row["role_id"];
                $_SESSION["id"] = $row["user_id"];

                header("location: ../pages/dashboard.php");
            }

        }else {
            header("location: ../pages/login.php?error=password incorrect");
        }
    }
}

function checkAccountExisting($email)
{
    global $pdo;
    $query = "SELECT * FROM users WHERE email = :email;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row;
}

