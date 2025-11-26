<?php include_once("../layout/header.php")?>
<?php
include_once("../database/connection.php");

$productQuery = "select id,name from category order by created_at desc";
$productRes = $pdo->prepare($productQuery);
$productRes->execute();

$categories = $productRes->fetchAll(PDO::FETCH_ASSOC);
//echo "<pre>";

//print_r ($categories);




?>

<div class="container">
    <div class="row">
        <div class="col-8 offset-2">
            <a href="list.php" class="btn btn-primary mb-3">List Page</a>
            <div class="card">
                <div class="card-body">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="mb-2">
                            <div class="d-flex justify-content-center">
                                <img class="w-25 mb-3 text-center" id="output"> 
                            </div>
                            <input type="file" name="image" id="" class="form-control" onchange="LoadFile(event)">
                            <?php

                                if(isset($_POST['btnCreate'])){
                                    $fileStatus = $_FILES['image']['name'] == ""? false:true;
                                    echo $fileStatus ? "" : "<small class='text-danger'>File is required!</small>";
                                }
                            
                            ?>
                        </div>    
                        <div class="mb-2">
                            <input type="text" name="name" value="<?php echo $_POST['name'] ?? "" ;?>" class="form-control" placeholder="Enter product name...">
                            <?php

                            if(isset($_POST['btnCreate'])){
                                $nameStatus = $_POST['name'] == ""? false:true;
                                echo $nameStatus ? "" : "<small class='text-danger'>Name is required!</small>";
                            }
                        
                            ?>
                        </div>
                        <div class="mb-2">
                            <input type="number" name="price" value="<?php echo $_POST['price'] ?? "" ;?>" class="form-control" placeholder="Enter product price...">
                            <?php

                            if(isset($_POST['btnCreate'])){
                                $priceStatus = $_POST['price'] == ""? false:true;
                                echo $priceStatus ? "" : "<small class='text-danger'>Price is required!</small>";
                            }
                            
                            ?>
                        </div>
                        <div class="mb-2">
                            <textarea name="description" rows="10" cols="30" class="form-control" placeholder="Enter product description..."><?php echo $_POST['description'] ?? "" ;?></textarea>
                            <?php

                            if(isset($_POST['btnCreate'])){
                                $descriptionStatus = $_POST['description'] == ""? false:true;
                                echo $descriptionStatus ? "" : "<small class='text-danger'>Description is required!</small>";
                            }
                            
                            ?>
                        </div>
                        <div class="mb-2">
                            <select name="categoryId" class="form-select">
                                <option value="">Choose category</option>
                                <?php
                                foreach($categories as $item){
                                    echo '<option value="'.$item['id'].'" '.(isset($_POST['categoryId']) && $_POST['categoryId'] == $item['id'] ? 'selected' : '') .'>'.$item['name'].'</option>';
                                }
                                
                                ?>
                            </select>
                            <?php

                            if(isset($_POST['btnCreate'])){
                                $categoryIdStatus = $_POST['categoryId'] == ""? false:true;
                                echo $categoryIdStatus ? "" : "<small class='text-danger'>categoryId is required!</small>";
                            }
                            
                            ?>
                            
                        </div>
                        <input type="submit" name="btnCreate" value="Create" class="btn btn-primary w-100"> 
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php



if (isset($_POST['btnCreate'])){
    if($fileStatus && $nameStatus && $priceStatus && $descriptionStatus && $categoryIdStatus){

    $imageName = uniqid()."_KMS_".$_FILES['image']['name'];
    $tmpName = $_FILES['image']['tmp_name'];

    $targetFile = "../image/" . $imageName;

    move_uploaded_file($tmpName,$targetFile);

        $productQuery = "insert into product (name,description,image,price,category_id) values (?,?,?,?,?)";
        $productRes = $pdo->prepare($productQuery);
        $productRes->execute([$_POST['name'],$_POST['description'],$imageName,$_POST['price'],$_POST['categoryId']]);


        header("Location:list.php");


    }


}

?>


<?php include_once("../layout/footer.php")?>