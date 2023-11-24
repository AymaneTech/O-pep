<?php
include ("../config/db.php");

function selectProduct(){
    global $pdo;
    $query =  ("SELECT * FROM plant;");
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        ?>
        <tr>
            <td>
                <span class="custom-checkbox">
                    <img src="data:image/jpg;charset=utf8;base64,<?php echo base64_encode($row['plant_image']); ?>"  class="product-image" alt="product image"/>
                </span>
            </td>
            <td><?=$row["plant_name"]?></td>
            <td><?=$row["plant_desc"]?></td>
            <td><?=$row["plant_price"]?></td>
            <td>
                <a href="../models/deleteProduct.md.php?id=<?=$row["plant_id"]?>">delete</a>
                <a href="../models/updateProduct.md.php?id=<?=$row["plant_id"]?>">Update</a>
                <a href="#edEmployeerModal" class="edit" data-toggle="modal"><i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                <!--<a href="#deleteEmployeeModal" class="delete" data-toggle="modal">
                    <i class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i>
                </a>-->
                <!--<form action="../models/deleteProduct.md.php" method="post">
                    <input type="hidden"  name="product_id" value="">
                    <button type="submit" name="delete">Delete</button>
                    <button type="submit" name="update">update</button>
                </form>-->
            </td>
        </tr>
<?php
    }
}