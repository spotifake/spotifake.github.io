<?php 

try {
    $pdoConnect = new PDO("mysql:host=localhost;dbname=sampledb","root","");
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("error".$e->getMessage());
}
?>