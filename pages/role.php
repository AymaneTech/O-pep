<?php
include(__DIR__ . '/../includes/header.php');
//include('../includes/header.php');
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: ./index.php");
    unset($_SESSION["username"]);
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head> 

<body>
    <section class="main-content h-100 py-5">
        <h1 class="primary-heading text-white fw-bold text-center p-5">
            Choose your role from here
        </h1>
        <div class="role-cards d-flex justify-content-center gap-5 pt-5 mt-5">
            <div class="card p-5 d-flex flex-column align-items-center">
                <img src="../assets/images/teamwork.png" alt="user icon">
                <h2 class="user-role pt-3">
                    I want to bye
                </h2>
                <form action="../models/role.md.php/" method="POST">
                    <input type="hidden" name="role" value="client">
                    <button class="role-link" type="submit" name="">client</button>
                </form>
            </div>
            <div class="card p-5 d-flex flex-column align-items-center">
                <img src="../assets/images/user.png" alt="user icon">
                <h2 class="user-role pt-3">
                    I am admin
                </h2>
                <form action="../models/role.md.php/" method="POST">
                    <input type="hidden" name="role" value="admin">
                    <button class="role-link" type="submit" name="">Admin</button>
                </form>
            </div>
        </div>
    </section>
</body>

</html>