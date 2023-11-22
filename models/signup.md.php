<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST["register"])) {
        validate();
    }
}

function validate()
{
    $name_error = "";
    if (
        empty($_POST['first_name']) || empty($_POST['last_name']) ||
        empty($_POST['email']) || empty($_POST['adress']) ||
        empty($_POST['pwd']) || empty($_POST['pwd2'])
    ) {

        $name_error = "name is required";
        header('Location: ../?name_error=name is required');
        exit();
    }
}
