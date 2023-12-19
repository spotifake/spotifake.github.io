<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>search page</title>
</head>
<body>
    <div class="conatiner">
    <h1>welcome to prj</h1>
    </div>

</body>
</html>
<?php
session_start();
if(isset($_SESSION["UserName"])){
    echo '<h3>login success, welcome -'.$_SESSION['UserName'].'</h3>';
echo'<br/><br/><a href="/prj/home.php">Home</a>';
echo'<br/><br/><a href="dropdown.php">sample dropdown menu</a>';
echo'<br/><br/><a href="logout.php">logout</a>';

}else{
    header("localtion:index.php");
}

$id = "";
$UserName = "";
$PassWord = "";
$FullName = "";

if (isset($_POST['Find'])) {
    try {
        $pdo = new PDO("mysql:host=localhost:3307;dbname=dbtest","root","root");
        $pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        echo$e->getMessage();
        exit();
    }

    $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
    if ($id !== false and $id !== null) {
$pdoQuery = "SELECT FROM tbuser WHERE id = :id";
$pdoResult = $pdo->prepare($pdoQuery);
$pdoExec = $pdoResult->execute(array(':id'=>$id));

echo "<table border='2' cellpadding='7'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>UserName</th>";
echo "<th>Password</th>";
echo "<th>FullName</th>";
echo "<th>Action</th>";
echo "</tr>";
if ($pdoExec) {
    if ($pdoResult->rowCount()>0) {
        while ($row=$pdoResult->fetch(PDO::FETCH_ASSOC)) {
            extract($row); 
            echo "<tr>";
            echo "<td>$id</td>";
            echo "<td>$UserName</td>"; 
            echo "<td>$Password</td>";
            echo "<td>$FullName</td>";
            echo "<td><a href='update.php?id=$id';>Edit</a> <a href='delete.php?id=$id'; ?>Delete</a></td>"; 
            echo "</tr>";
        }
    } else {
        echo '<br><br><br><br><br>';
        echo "no data";
    }
    
}
}else {
    echo '<br><br><br><br><br>';
        echo "invalid id";
}
$pdo = null;
    }
    

?>