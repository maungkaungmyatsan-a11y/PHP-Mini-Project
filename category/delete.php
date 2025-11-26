<?php

require_once("../database/connection.php");

$id = $_REQUEST['id'];
$query = "delete from category where id=?";
$res = $pdo->prepare($query);
$res->execute([$id]);

header("Location:create.php");


?>