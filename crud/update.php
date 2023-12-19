<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>welcome to prj</title>
</head>
<body>
    <div class="conatiner">
    <h1>welcome to prj</h1>
    </div>
    <!-- php -->
    <?php
    require_once('../include/connect/dbcon.php');
    session_start();
    if(isset($_SESSION["UserName"])){
        echo '<h3>login success, welcome -'.$_SESSION['UserName'].'</h3>';
    echo'<br/><br/><a href="/prj/home.php">Home</a>';
    echo'<br/><br/><a href="dropdown.php">sample dropdown menu</a>';
    echo'<br/><br/><a href="logout.php">logout</a>';

    }else{
        header("localtion:index.php");
    }

    if (!empty($_POST['modify'])) {
        $UserName = htmlspecialchars($_POST['User']);
        $PassWord = htmlspecialchars($_POST['Pass']);
        $FullName = htmlspecialchars($_POST['Fname']);

        $pdoQuery = $pdo->prepare("UPDATE tbuser SET UserName = :User, PassWord = :Pass, FullName = :Fname WHERE id = :id");
        $pdoResult = $pdoQuery->execute(array(":User"=>$UserName,":Pass"=>$PassWord,":Fname"=>$FullName, ':id'=> $_GET['id']));

        if($pdoResult){
            header("location:read.php");
        }
    }

    $pdoQuery= $pdo->prepare("SELECT * FROM tbuser WHERE id = :id");
    $pdoQuery->execute(array(':id'=>$_GET['id']));
    $pdoResult = $pdoQuery->fetchAll();
    $pdo = null;
    ?>
    <br>
    <form action="update.php?id=<?php echo $_GET['id'];?>" method="post">
    <input type="hidden" name="id">    
    UserName: <input type="text" name="User" value="<?php echo $pdoResult[0]['UserName'];?>" required placeholder="Username"> <br><br>
    PassWord: <input type="password" name="Pass" value="<?php echo $pdoResult[0]['PassWord'];?>" required placeholder="Password"><br><br>
    FullName: <input type="text" name="Fname" value="<?php echo $pdoResult[0]['FullName'];?>" required placeholder="Fullname"><br><br>
    <input type="submit" name="modify" value="Update">
    </form>
    <br>
</body>
</html>