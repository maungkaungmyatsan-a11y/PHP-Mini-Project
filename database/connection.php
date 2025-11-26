<?php

try{
    $pdo = new PDO("mysql:host=localhost;dbname=php_mini_project","root","");
   
}catch(PDOException $e){
    echo "PDO Errors =>" . $e ;
}

?>