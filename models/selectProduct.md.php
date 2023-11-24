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
                <a href="#editEmployeeModal" class="edit" data-toggle="modal"><i class="material-icons"
                                                                                 data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                <a href="#deleteEmployeeModal" class="delete" data-toggle="modal"><i
                        class="material-icons" data-toggle="tooltip" title="Delete">&#xE872;</i></a>
            </td>
        </tr>
<?php
    }
}