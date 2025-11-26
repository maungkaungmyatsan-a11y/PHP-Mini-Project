<?php include_once("../layout/header.php");?>

<?php
 include_once("../database/connection.php");

 $productId = $_GET['id'];
 $productQuery = "select product.*, category.name as category_name from product left join category on product.category_id = category.id where product.id=?";
 $Res = $pdo->prepare($productQuery);
 $Res->execute([$productId]);

 $product = $Res->fetch(PDO::FETCH_ASSOC);

?>

<div class="container">
    <a href="./list.php" class="ms-5 mb-4 btn btn-sm bg-black text-white rounded">Back</a>
    <div class="row">
        <div class="col-10 offset-1"> 
            <div class="row">
                <div class="col-4">
                    <img src="../image/<?php echo $product["image"]; ?>" class="w-100">
                </div>
                <div class="col">
                    <h3><?php echo $product['name']; ?></h3>
                    <h5 class="text-muted"><?php echo $product['description']; ?></h5><hr>
                    <h5><?php echo $product['price']; ?> mmk</h5>
                    Category Name - <span class="text-danger"><?php echo $product['category_name']; ?></span><hr>
                    Created Date : - <span class="text-muted"><?php echo date("d/m/Y",strtotime($product['created_at']));?></span>   
                    <div class="mt-5">
                        <a href="./update.php?id=<?php echo $product['id'];?>" class="btn btn-sm btn-primary rounded shadow-sm me-2">Update </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once("../layout/footer.php");?>