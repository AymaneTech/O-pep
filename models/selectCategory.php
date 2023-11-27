<?php
include("../config/db.php");

function selectCategory()
{
    global $pdo;
    $query = "SELECT * FROM category;";
    $stmt = $pdo->prepare($query);
    $stmt->execute();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        ?>
        <tr>
            <td><?=$row["category_id"]?></td>
            <td><?=$row["category_name"]?></td>
            <td><?=$row["category_desc"]?></td>
            <td>
                <a href="../models/deleteProduct.md.php?id=<?=$row["category_id"]?>">delete</a>
                <a href="../pages/update.php?id=<?=$row["category_id"]?>">Update</a>

            </td>
        </tr>
        <?php
    }
}
