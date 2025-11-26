<?php include_once("../layout/header.php")?>
<?php include_once("../database/connection.php")?>

<div class="container">
    <div class="row">
        <div class="col-4">
            <div class="card">
                <div class="card-body">
                    <form action="" method="post">
                        <input type="text" name="categoryName" class=" mb-2 form-control" placeholder="Enter Category Name...">
                        <?php

                        if(isset($_POST['btnCreate'])){
                            $categoryStatus = $_POST['categoryName'] == ""? false:true;
                            echo $categoryStatus ? "" : "<small class='text-danger'>Category name is required!</small>";
                        }
                        
                        ?>
                        <input type="submit" name="btnCreate" value="Create" class="btn w-100 btn-primary rounded shadow-sm">
                    </form>
                </div>
            </div>

            <?php

            if(isset($_POST['btnCreate'])){
                if ($categoryStatus){
                    $categoryName = $_POST['categoryName'];

                    $createQuery = "insert into category (name) values (?)";
                    $createRes = $pdo->prepare($createQuery);
                    $createRes->execute([$categoryName]);

                    header("Location:create.php");
                }
            }
            ?>
        </div>
        <div class="col">
            
            <?php
                $categoryListQuery = "select id,name from category order by created_at desc";
                $listRes = $pdo->prepare($categoryListQuery);
                $listRes->execute();

                $categories = $listRes->fetchAll(PDO::FETCH_ASSOC);
               
                
                
                foreach($categories as $item){
                     $cateName = $item['name'];
                     $id =$item['id'];

                    echo "<div class='card mb-3'>
                            <div class='card-body'>
                                <div class='row'>
                                    <div class='col-9 mt-1 ms-4'>$cateName</div>
                                    <div class='col'>
                                        <a href='delete.php?id=$id' class='text-decoration-none'>
                                            <button class='btn btn-danger btn-sm rounded shadow-sm'>Delete</button>
                                        </a>
                                        <a href='update.php?id=$id' class='text-decoration-none'>
                                            <button class='btn btn-secondary btn-sm rounded shadow-sm'>Update</button>
                                        </a>
                                        
                                    </div>
                                </div>
                            </div>
                          </div>";
                }
                ?>  
        </div>
    </div>


</div>
<?php include_once("../layout/footer.php")?>