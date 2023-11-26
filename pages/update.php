<?php
include("../config/db.php");
function selectProductToUpdate()
{
    $id = $_GET['id'];
    global $pdo;
    $query = "SELECT * FROM plant where plant_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
$row = selectProductToUpdate();
function insertUpdatedProduct()
{
    global $pdo;
    $id = $_GET['id'];
    $tmp_name = file_get_contents($_FILES['productImg']['tmp_name']);
    $query = "UPDATE plant SET plant_name = :pname, plant_desc = :pdesc, plant_price = :pprice, category_id = :category_id, plant_image = :plant_image  where  plant_id = :id;";
    $stmt = $pdo->prepare($query);

    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':pname', $_POST["plant_name"], PDO::PARAM_STR);
    $stmt->bindParam(':pdesc', $_POST["plant_desc"], PDO::PARAM_STR);
    $stmt->bindParam(':pprice', $_POST["plant_price"], PDO::PARAM_INT);
    $stmt->bindParam(':category_id', $_POST["category"], PDO::PARAM_INT);
    $stmt->bindParam(':plant_image', $tmp_name, PDO::PARAM_LOB);

    $stmt->execute();
    header('location: ../pages/dashboard.php');
    exit();
}

$catQuery = "SELECT * FROM category;";
$stmt = $pdo->prepare($catQuery);
$stmt->execute();

if (isset($_POST["update_form"])) {
    insertUpdatedProduct();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- styling files -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500&display=swap" rel="stylesheet">

    <link href="https://fonts.googleapis.com/css?family=Source+Serif+Pro:400,600&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="../assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">

    <!-- Style -->
    <link rel="stylesheet" href="../assets/css/update.css">
    <!-- CDN Links -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Add this inside the head tag of your HTML file -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/110/three.min.js"></script>
    <title>Document</title>
</head>

<body>
    <div class="container-fluid px-1 py-5 mx-auto">
        <div class="row d-flex justify-content-center">
            <div class="col-xl-7 col-lg-8 col-md-9 col-11 text-center">
                <h3>Request a Demo</h3>
                <p class="blue-text">Just answer a few questions<br> so that we can personalize the right experience for
                    you.</p>
                <div class="card">
                    <h5 class="text-center mb-4">Powering world-class companies</h5>
                    <form class="form-card" action="" method="post" enctype="multipart/form-data">
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Plant name<span
                                        class="text-danger">*</span></label>
                                <input type="text" value="<?= isset($_GET["id"]) ? $row["plant_name"] : 'nothing' ?>"
                                    id="fname" name="plant_name" placeholder="Enter plant name">
                            </div>
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Plant description<span
                                        class="text-danger">*</span></label>
                                <input type="text" value="<?= $row["plant_desc"] ?>" id="lname" name="plant_desc"
                                    placeholder="Enter plant description">
                            </div>
                        </div>
                        <div class="row justify-content-between text-left">
                            <div class="form-group col-sm-6 flex-column d-flex">
                                <label class="form-control-label px-3">Price<span class="text-danger">*</span></label>
                                <input type="text" id="text" value="<?= $row["plant_price"] ?>" name="plant_price"
                                    placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="category">category</label>
                                <select id="category" name="category">
                                    <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) { ?>
                                        <option value="<?= $row["category_id"] ?>">
                                            <?= $row["category_name"] ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Image</label>
                                <input name="productImg" type="file" class="form-control" required>
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="form-group col-sm-6">
                                <button type="submit" name="update_form" class="btn-block btn-primary">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>