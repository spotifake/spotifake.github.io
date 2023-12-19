<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>add and display</title>
</head>
<body>
<div class="conatiner">
    <h1>welcome to prj</h1>
    </div>
</body>
</html>
<?php
require_once('../include/connect/dbcon.php');

if (isset($_GET['id'])) {
$pdoQuery = "DELETE FROM tbuser WHERE id = :id";
$pdoResult = $pdo->prepare($pdoQuery);
$pdoResult->execute(array(':id'=>$_GET['id']));
header("loaction:read.php");
}else{
    echo"invalid request";
}
$pd0 = null;
?>