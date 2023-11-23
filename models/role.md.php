<?php
include ('../config/db.php');

if (isset($_POST["role"])){
    updateUserRole();
}

function updateUserRole(){
    global $pdo;
    $role_id ='';
    $userId = selectLastUser ();
    if ($_POST["role"] == "client"){
        $role_id = 1;
    }elseif ($_POST["role"] == "admin"){
        $role_id = 2;
    }

    $query = "update users set role_id = :role_id  where user_id = :user_id ;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam('role_id', $role_id, PDO::PARAM_INT);
    $stmt->bindParam('user_id', $userId, PDO::PARAM_INT);$stmt->execute();

    if ($stmt->execute()){
        //die("here is the role id ". $role_id);
        header("location: ../../pages/login.php");
    }else{
        die("failed to update role id homie !!!!");
    }
}

function selectLastUser (){
    global $pdo;
    $sql = "SELECT * FROM users ORDER BY user_id DESC LIMIT 1;";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row["user_id"];
}
