<?php include_once("../layout/header.php")?>
<?php require_once("../database/connection.php");?>
        <?php
        $query = "select id,name from category where id=?";
        $res = $pdo->prepare($query);
        $res->execute([$_GET['id']]);

        $category = $res->fetch(PDO::FETCH_ASSOC);

        ?>

<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        <input type="text" name="categoryName" class=" mb-2 form-control" placeholder="Enter Category Name..." value="<?php echo $_POST['categoryName'] ?? $category['name'];?>">
                         <?php

                        if(isset($_POST['btnUpdate'])){
                            $categoryStatus = $_POST['categoryName'] == ""? false:true;
                            echo $categoryStatus ? "" : "<small class='text-danger'>Category name is required!</small>";
                        }
                        
                        ?>
                        
                        <input type="submit" name="btnUpdate" value="Create" class="btn w-100 btn-primary rounded shadow-sm">
                    </form>
                </div>
            </div>
        </div>    
    </div>
</div>
<?php

if(isset($_POST['btnUpdate'])){
    if($categoryStatus){
        
        $updateQuery = "update category set name=? where id=?";
        $updateRes = $pdo->prepare($updateQuery);
        $updateRes->execute([$_POST['categoryName'],$_GET['id']]);

        header("Location:create.php");
    }
}

?>


<?php include_once("../layout/footer.php")?>