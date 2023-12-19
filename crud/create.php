
<?php

// if (isset($_SESSION['insert'])) {
//     try {
//         $pdo = new PDO("mysql:host=localhost:3307;dbname=dbtest","root","root");
//         $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
//     } catch (PDOException $e) {
//         echo$e->getMessage();
//         exit();
//     }
// $User = $_POST['User'];
// $Pass = $_POST['Pass'];
// $Fname = $_POST['Fname'];

// $pdoQuery = "INSERT INTO tbuser (UserName, PassWord, FullName) VALUES (:User,:Pass,:Fname)";

// $pdoResult = $pdo->prepare($pdoQuery);
// $pdoResult->bindParam(':User',$User);
// $pdoResult->bindParam(':Pass',$Pass);
// $pdoResult->bindParam(':Fname',$Fname);


// if ($pdoResult->execute()) {
//     $pdoQuery = "SELECT * FROM tbuser";
//     $pdoResult= $pdo->prepare($pdoQuery);
//     $pdoResult->execute();
//     while ($row = $pdoResult->fetch()) {
//         echo $row['id']."|". $row['UserName']."|". $row['PassWord']."|".$row['FullName']."<br/>";
//     }
//     header("location: read.php");
//     exit;

// } else {
//     echo'data not inserted';
// }
// }
// $pdo = null;
?>
<?php
if(isset($_POST['insert']))
{
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=dbtest","root","root");

        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
     catch (PDOException $exc) {
        echo $exc->getMessage();
        exit();
    }
    $id = $_POST['id'];
    $User = $_POST['User'];
    $Pass = $_POST['Pass'];
    $FName = $_POST['Fname'];

    $pdoquery = "INSERT INTO `tbuser`(`UserName`, `PassWord`, `FullName`) Values (:User,:Pass,:FName)";
    $pdoResult = $pdo->prepare($pdoquery);
    $pdoExec = $pdoResult->execute(array(":User"=>$User, ":Pass"=>$Pass,"FName"=>$FName));

    if($pdoExec)
    {
        $pdoquery = 'SELECT * FROM tbuser';
        $pdoResult = $pdo->prepare($pdoquery);
        $pdoResult->execute();
        while ($row = $pdoResult->fetch()){
            echo $row['id'] . " | " .$row['UserName'] . " | " .$row['PassWord'] . " | " .
            $row['FullName'] . "<br />";           
        }
        header("Location: read.php");
        exit;

    } else {
        echo 'Data Not Found';
    }
}
$pdo = null;
?>
