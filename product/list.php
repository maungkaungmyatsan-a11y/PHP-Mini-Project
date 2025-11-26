<?php include_once("../layout/header.php");?>

<?php 

include_once("../database/connection.php");

$productQuery = "select product.id, product.name, product.price, product.created_at, product.image, category.name as category_name from product left join category on product.category_id = category.id order by product.created_at desc";
$productRes = $pdo->prepare($productQuery);
$productRes->execute();
$products = $productRes->fetchAll(PDO::FETCH_ASSOC);




?>



<div class="container">
    <div class="row">
        <div class="col-10 offset-1">
            <?php
            foreach($products as $item){
                echo '<div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-3">
                            <img src="../image/'.$item['image'].'" class="w-100">
                        </div>
                        <div class="col">
                            <h3>'.$item['name'].'</h3>
                            <h5>'.$item['price'].' mmk</h5>
                            Category Name - <span class="text-danger">'.$item['category_name'].'</span>
                            Created Date : - <span class="text-muted">'.date('d/m/Y',strtotime($item['created_at'])).'</span>
                            <div class="mt-3">
                            <a href="./details.php?id='.$item['id'].'" class="btn btn-sm rounded btn-secondary shadow-sm me-2">Details</a>
                            <a href="./update.php?id='.$item['id'].'" class="btn btn-sm rounded btn-primary shadow-sm me-2">Update</a>
                            <a href="./delete.php?id='.$item['id'].'&oldImage='.$item['image'].'" class="btn btn-sm rounded btn-danger shadow-sm me-2">Delete</a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>';
            }
            ?>
        </div>
    </div>
</div>
<?php include_once("../layout/footer.php");?>