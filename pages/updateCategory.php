<?php
include("../config/db.php");
function selectCatToUpdate()
{
    $id = $_GET['id'];
    global $pdo;
    $query = "SELECT * FROM category where category_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
$row = selectCatToUpdate();
function insertUpdatedCat()
{
    global $pdo;
    
    $categoryName = $_POST["category_name"];
    $categoryDesc = $_POST["category_desc"];

    $id = $_GET['id'];
    $query = "UPDATE category SET category_name = :catName, category_desc = :catDesc where  category_id = :id;";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->bindParam(':catName', $categoryName, PDO::PARAM_STR);
    $stmt->bindParam(':catDesc', $categoryDesc, PDO::PARAM_STR);

    $stmt->execute();
    header('location: ../pages/cat_admin.php');
    exit();
}

$catQuery = "SELECT * FROM category;";
$stmt = $pdo->prepare($catQuery);
$stmt->execute();

if (isset($_POST["update_cat"])) {
    
    insertUpdatedCat();
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
                            <div class="form-group flex-column d-flex">
                                <label class="form-control-label px-3">category name<span
                                        class="text-danger">*</span></label>
                                <input type="text" value="<?= isset($_GET["id"]) ? $row["category_name"] : 'nothing' ?>"
                                    id="fname" name="category_name" placeholder="Enter category name">
                            </div>
                            <div class="form-group flex-column d-flex">
                                <label class="form-control-label px-3">category description<span
                                        class="text-danger">*</span></label>
                                <input type="text" value="<?= $row["category_desc"] ?>" id="lname" name="category_desc"
                                    placeholder="Enter category description">
                            </div>
                        </div>
                        
                        <div class="row justify-content-end">
                            <div class="form-group col-sm-6">
                                <button type="submit" name="update_cat" class="btn-block btn-primary">Update</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

</body>

</html>