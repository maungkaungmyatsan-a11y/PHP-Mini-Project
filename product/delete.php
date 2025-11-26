<?php
require_once("../database/connection.php");

//getting data from url method
echo "<pre>";

print_r($_GET);

$id = $_GET['id'];
$oldImage = $_GET['oldImage'];





// // getting data from database method
// $productQuery = "select image from product where id=?";
// $productRes = $pdo->prepare($productQuery);
// $productRes->execute([$id]);

// $product = $productRes->fetch(PDO::FETCH_ASSOC);

unlink("../image/".$oldImage);

$query = "delete from product where id=?";
$res = $pdo->prepare($query);
$res->execute([$id]);

header("Location:list.php");

?>