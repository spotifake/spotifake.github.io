<?php
session_start();

// Check if the user is logged in; otherwise, redirect to the login page
if (!isset($_SESSION["email"])) {
    header("Location: index.php");
    exit;
}

$firstname = $_SESSION["firstname"];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./include/style/style.css">
    <title>Welcome</title>

</head>
<body>

  <!-- Navigation bar -->
  <div class="navbar">
  <a href="home.php.">Sample Website</a>
       
        <!-- You can add more links here -->
    </div>


    <div class="main">
    <div>
    <div class="container">
        <h1>Welcome, <?php echo htmlspecialchars($firstname); ?>!</h1>
        <p>Login successful. This is your home page.</p>
        <!-- Additional content for the home page can be added here -->
        <form action="logout.php" method="post">
            <input type="submit" name="logout" value="Logout">
            </div>
        </form> <br>
        <iframe style="border-radius:12px" src="https://open.spotify.com/embed/album/1xn54DMo2qIqBuMqHtUsFd?utm_source=generator&theme=0" width="100%" height="152" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
    </div>
</body>
</html>
