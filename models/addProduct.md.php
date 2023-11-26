<?php
include ("../config/db.php");


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_FILES["productImg"])) {
        checkFileError();
        insertProduct();
        header("location: ../pages/dashboard.php");
    }
}

function checkFileError(){
    switch ($_FILES['productImg']['error']) {
        case UPLOAD_ERR_OK:
            echo 'File is valid, and was successfully uploaded.';
            break;
        case UPLOAD_ERR_INI_SIZE:
            echo 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            break;
        case UPLOAD_ERR_FORM_SIZE:
            echo 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            break;
        case UPLOAD_ERR_PARTIAL:
            echo 'The uploaded file was only partially uploaded.';
            break;
        case UPLOAD_ERR_NO_FILE:
            echo 'No file was uploaded.';
            break;
        case UPLOAD_ERR_NO_TMP_DIR:
            echo 'Missing a temporary folder. Introduced in PHP 5.0.3.';
            break;
        case UPLOAD_ERR_CANT_WRITE:
            echo 'Failed to write file to disk. Introduced in PHP 5.1.0.';
            break;
        case UPLOAD_ERR_EXTENSION:
            echo 'A PHP extension stopped the file upload. PHP does not provide a way to ascertain which extension caused the file upload to stop; examining the list of loaded extensions with phpinfo() may help.';
            break;
        default:
            echo 'Unknown upload error';
            break;
    }
}
function insertProduct(){
    global $pdo;
    $tmp_name =  file_get_contents($_FILES['productImg']['tmp_name']);
    $productName = $_POST["productName"];
    $productPrice = $_POST["product_price"];
    $productDesc = $_POST["productDesc"];
    $category_id = $_POST["category"];

    $query = "INSERT INTO plant (plant_name, plant_desc, plant_price, plant_image, category_id) VALUES (:plant_name, :plant_desc, :plant_price, :plant_image, :category_id)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':plant_name', $productName, PDO::PARAM_STR);
    $stmt->bindParam(':plant_desc', $productDesc, PDO::PARAM_STR);
    $stmt->bindParam(':plant_price', $productPrice, PDO::PARAM_INT);
    $stmt->bindParam(':plant_image', $tmp_name, PDO::PARAM_LOB);
    $stmt->bindParam(':category_id', $category_id, PDO::PARAM_INT);

    $stmt->execute();
}