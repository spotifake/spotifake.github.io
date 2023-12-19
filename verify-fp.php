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

            if ($count > 0) {
                $row = $result['row'];
                $fname = $row['firstname'];
                $id = $row['id'];
                forgotpass($email, $fname, $id);
                $showPopup = true; // Set the flag to display the success popup
            } else {
                $message = 'Invalid email, make sure you are already registered.';
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
       <style>
        /* Loader styles */
        .loader {
            position: fixed;
    top: 0;
    left: 0;
    width: 100vw;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #333333;
    transition: opacity 0.75s, visibility 0.75s;
            display: none; /* Initially hidden */
        }

        /* Overlay styles */
        .overlay {
        position: fixed;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            background-color: rgba(0, 0, 0, 0.0);
            display: none;
            justify-content: center;
            align-items: center;
            
        }
    </style>
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

    <!-- Add overlay to HTML -->
    <div class="overlay" id="overlay">
        <div class="loader"></div>
    </div>

    <?php if ($showPopup) { ?>
        <div class="popup" id="popup">
            <img src="./include/img/404-tick.png">
            <h3> Success! </h3>
            <p>Please check your email. Thanks!</p>
            <button type="button" onclick="closePopup()">OK</button>
        </div>
    <?php } elseif (isset($message)) {
        echo '<p class="red-text">' . $message . '</p>';
    } ?>
</div>

<script>
    // Function to show/hide the overlay
    function toggleOverlay() {
        const overlay = document.getElementById("overlay");
        overlay.classList.toggle("show");
    }

    // Function to open the popup
    function openPopup() {
        const popup = document.getElementById("popup");
        popup.classList.add("open-popup");
    }

    // Function to close the popup
    function closePopup() {
        const popup = document.getElementById("popup");
        popup.classList.remove("open-popup");
    }

    // Add an event listener to the form submission
    const form = document.getElementById("emailForm");
    form.addEventListener("submit", function (event) {
        toggleOverlay(); // Show the overlay when the form is submitted
        document.getElementById("overlay").classList.add("show");
    });

    // Call openPopup function if PHP condition is met
    <?php if ($showPopup) { ?>
    openPopup();
    <?php } ?>
</script>
</body>
</html>
