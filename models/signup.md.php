<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    if (isset($_POST["register"])) {
        $firstName = filter_input(INPUT_POST, "username",
        FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    }
}