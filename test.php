<?php
session_start();

require_once './include/connect/dbcon.php';
require_once 'otp.php';

$showPopup = false; // Initialize $showPopup variable

try {
    $pdoConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if (isset($_POST['reset'])) {
        if (empty($_POST["email"])) {
            $message = 'enter your email';
        } else {
            $email = $_POST['email'];
            $result = selectuser($pdoConnect, $email);
            $count = $result['count'];
            $showPopup = true; // Set the flag to display the success popup


            if ($count > 0) {
                $row = $result['row'];
                $fname = $row['firstname'];
                $id = $row['id'];
                forgotpass($email, $fname, $id);
              
            } else {
                $message = 'Invalid email, please use your email to change your password.';
            }
        }
    }
} catch (PDOException $error) {
    echo $error->getMessage();
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <link rel="stylesheet" type="text/css" href="./include/style/style.css">
</head>
<body>
    <div class="navbar">
        <a href="index.php">Sample Website</a>
    </div>

    <div class="container">
        <h3>Forgot Password</h3>
        <form id="emailForm" method="POST">
            <label for="email">Enter Email:</label><br>
            <input type="email" id="email" name="email" required><br>
            <input type="submit" value="Submit" id="submitButton" name="reset">
        </form>

        <?php if ($showPopup) { ?>
            <div class="popup" id="popup">
                <img src="./include/img/404-tick.png">
                <h3> Success! </h3>
                <p>Please check your email. Thanks!</p>
                <button type="button" onclick="closePopup()">OK</button>
            </div>
        <?php } elseif (isset($message)) { ?>
            <p><?php echo $message; ?></p>
        <?php } ?>
    </div>

    <script>
        let popup = document.getElementById("popup");
        function openPopup() {
            popup.classList.add("open-popup");
        }
        function closePopup() {
            popup.classList.remove("open-popup");
        }

        // Call openPopup function if PHP condition is met
        <?php if ($showPopup) { ?>
            openPopup();
        <?php } ?>
    </script>
</body>
</html>
