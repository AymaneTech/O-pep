<?php
include("../models/selectProduct.md.php");
include('../config/db.php');
session_start();
if(empty($_SESSION["email"])){
    header("Location: ./index.php");
}


global $pdo;
$query = "SELECT * FROM category";
$stmt = $pdo->prepare($query);
$stmt->execute();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap CRUD Data Table for Database with Modal Form</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- css links-->
    <script src="../assets/js/dashboard.js"></script>
    <link rel="stylesheet" href="../assets/css/dashboard.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</head>

<body>
        <div class="row">
            <section class="menu-section">
                <div class="border-bottom rounded">
                    <div class=" mx-auto | img-box">
                        <h3 class="text-white">o'pep</h3>
                    </div>
                </div>
                <div class="list-group list-group-flush">
                    <a href="./cat_admin.php" class="list-group-item bg-transparent rounded text-white">CATEGORIES</a>
                    <a href="./dashboard.php" class="list-group-item bg-transparent rounded text-white">PLANTES</a>
                    <a href="./login.php"
                        class="list-group-item bg-transparent border-bottom rounded text-white">Disconnect</a>
                </div>
            </section>

            <div class="col-9 table-responsive overflow-hidden mt-0">
                <div class="table-title py-5">
                    <div class="row text-center">
                        <div class="col-sm-6">
                            <h2>Manage <b>Products</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Add new product</span></a>
                        </div>
                    </div>
                </div>
                <div class="table-wrapper">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Plant Image</th>
                                <th>Plant name</th>
                                <th>Plant description</th>
                                <th>plant price</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            selectProduct();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <!-- Edit Modal HTML -->
    <div id="addEmployeeModal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="../models/addProduct.md.php" method="POST" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h4 class="modal-title">Add new product</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input name="productName" id="name" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Price</label>
                            <input name="product_price" type="text" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>product description</label>
                            <textarea name="productDesc" class="form-control" required></textarea>
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
                            <label>image</label>
                            <input name="productImg" type="file" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="button" class="btn btn-default" data-dismiss="modal" value="Cancel">
                        <button type="submit" class="btn btn-success">add</button </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>


</html>