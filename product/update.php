<?php include_once("../layout/header.php");?>

<?php
 include_once("../database/connection.php");

 $productId = $_GET['id'];
 $productQuery = "select product.*, category.name as category_name from product left join category on product.category_id = category.id where product.id=?";
 $Res = $pdo->prepare($productQuery);
 $Res->execute([$productId]);

 $product = $Res->fetch(PDO::FETCH_ASSOC);

 $categoryQuery = "select id,name from category order by created_at desc";
 $categoryRes = $pdo->prepare($categoryQuery);
 $categoryRes->execute();

 $categories = $categoryRes->fetchAll(PDO::FETCH_ASSOC);

?>

 <div class="container">
    <a href="./list.php" class="ms-5 mb-4 btn btn-sm bg-black text-white rounded">Back</a>
    <form method="post" enctype="multipart/form-data">
        <div class="row">
        <div class="col-10 offset-1"> 
                    <div class="row">
                        <div class="col-4">
                            <img src="../image/<?php echo $product['image']; ?>" id="output" class="w-100">
                            <input type="file" name="image" id="" class="form-control mt-3" onchange="LoadFile(event)">
                        </div>
                        <div class="col">
                           <div class="mb-2">
                            <input type="text" name="name" value="<?php echo $_POST['name']?? $product['name'] ;?>" class="form-control" placeholder="Enter product name...">
                            <?php

                            if(isset($_POST['btnUpdate'])){
                                $nameStatus = $_POST['name'] == ""? false:true;
                                echo $nameStatus ? "" : "<small class='text-danger'>Name is required!</small>";
                            }
                        
                            ?>
                        </div>
                        <div class="mb-2">
                            <input type="number" name="price" value="<?php echo $_POST['price']?? $product['price'] ;?>" class="form-control" placeholder="Enter product price...">
                            <?php

                            if(isset($_POST['btnUpdate'])){
                                $priceStatus = $_POST['price'] == ""? false:true;
                                echo $priceStatus ? "" : "<small class='text-danger'>Price is required!</small>";
                            }
                            
                            ?>
                        </div>
                        <div class="mb-2">
                            <textarea name="description" rows="10" cols="30" class="form-control" placeholder="Enter product description..."><?php echo $_POST['description']?? $product['description'] ;?></textarea>
                            <?php

                            if(isset($_POST['btnUpdate'])){
                                $descriptionStatus = $_POST['description'] == ""? false:true;
                                echo $descriptionStatus ? "" : "<small class='text-danger'>Description is required!</small>";
                            }
                            
                            ?>
                        </div>
                        <div class="mb-2">
                            <select name="categoryId" class="form-select">

                                <?php
                                foreach($categories as $item){
                                    echo '<option value="'.$item['id'].'"'.($item['id'] == $product['category_id']? 'selected' : '').' >'.$item['name'].'</option>';
                                }
                                
                                ?>
                            </select>
                            <?php

                            if(isset($_POST['btnUpdate'])){
                                $categoryIdStatus = $_POST['categoryId'] == ""? false:true;
                                echo $categoryIdStatus ? "" : "<small class='text-danger'>categoryId is required!</small>";
                            }
                            
                            ?>
                            
                        </div>
                        <input type="submit" name="btnUpdate" value="Create" class="btn btn-primary w-100"> 
                        </div>
                    </div>
        </div>
    </div>
    </form>
 </div>


<?php

    if(isset($_POST['btnUpdate'])){
        if($nameStatus && $priceStatus && $descriptionStatus){
            if($_FILES['image']['name'] == ""){
                $updateQuery = "update product set name=? ,price=?, description=?, category_id=? where id=?";
                $updateRes = $pdo->prepare($updateQuery);
                $updateRes->execute([$_POST['name'],$_POST['price'],$_POST['description'],$_POST['categoryId'],$productId]);
                header("Location:list.php");
            }else{
                //delete the old image and store new image
                $oldImageName = $product['image'];
                unlink("../image/".$oldImageName);

                $imageName = uniqid()."_KMS_".  $_FILES['image']['name'];
                $tmpName = $_FILES['image']['tmp_name'];
                $targetFile = "../image/".$imageName;
                move_uploaded_file($tmpName,$targetFile);

                $updateQuery = "update product set name=? ,image=?, price=?, description=?, category_id=? where id=?";
                $updateRes = $pdo->prepare($updateQuery);
                $updateRes->execute([$_POST['name'],$imageName,$_POST['price'],$_POST['description'],$_POST['categoryId'],$productId]);
               
            }
            header("Location:list.php");
        }
    }
?>



<?php include_once("../layout/footer.php");?>