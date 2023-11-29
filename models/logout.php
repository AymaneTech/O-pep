<?php
if(isset($_POST["logout"])){
    session_start();
    if(session_unset()){
        header("location: ../models/login.php");
    }
}