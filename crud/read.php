<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Read and display page</title>
</head>
<body>
    <div class="container">
    <h1>WELCOME TO READ AND DISPLAY PAGE</h1>

    </div>
    <?php
    require_once'../include/connect/dbcon.php';
    session_start();
    if(isset($_SESSION["UserName"])){
        echo '<h3>login success, welcome -'.$_SESSION['UserName'].'</h3>';
    echo'<br/><br/><a href="/prj/home.php">Home</a>';
    echo'<br/><br/><a href="dropdown.php">sample dropdown menu</a>';
    echo'<br/><br/><a href="logout.php">logout</a>';

    }else{
        header("localtion:index.php");
    }
    ?>
    <br>

    <form action="create.php" method="post">
    <input type="hidden" name="id">    
    UserName: <input type="text" name="User" required placeholder="Username">
    PassWord: <input type="password" name="Pass" required placeholder="Password">
    FullName: <input type="text" name="Fname" required placeholder="Fullname">
    <input type="submit" name="insert" value="save">
    </form>
    <form action="search.php" method="post">
        Search: <input type="text" name="Id" required placeholder="Enter data here">
        <input type="submit" name="Find" value="search">
    </form>
    <br>
    <?php

    $pdoQuery= "SELECT * FROM tbuser";
    $pdoResult = $pdo->prepare($pdoQuery);
    $pdoResult->execute();
echo "<table border='2' cellpadding='7'>";
echo "<tr>";
echo "<th>ID</th>";
echo "<th>UserName</th>";
echo "<th>Password</th>";
echo "<th>FullName</th>";
echo "<th>Action</th>";
echo "</tr>";
while ($row=$pdoResult->fetch(PDO::FETCH_ASSOC)) {
extract($row); 
echo "<tr>";
echo "<td>$id</td>";
echo "<td>$UserName</td>"; 
echo "<td>$PassWord</td>";
echo "<td>$FullName</td>";
echo "<td><a href='update.php?id=$id';>Edit</a> <a href='delete.php?id=$id'; ?>Delete</a></td>"; 
echo "</tr>";
}
    ?>
</body>
</html>