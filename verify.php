
<?php
session_start();

require_once 'otp.php'; // Import the necessary functions here

$registrationData = $_SESSION['registration_data'] ?? [];
 $email = $registrationData['email'] ?? '';
$firstname = $registrationData['firstname'] ?? ''; // Using the correct key for first name
$middlename =$registrationData['middlename'] ?? '';
$lastname = $registrationData['lastname'] ?? '';

$storedOTP = $_SESSION["OTP"];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userOTP = htmlspecialchars(trim($_POST["otpCode"] ?? ''));

    if (empty($userOTP)) {
        $message = 'Empty input, please enter OTP.';
    } elseif ($storedOTP == $userOTP) {
        // Validation successful, proceed with registration
        unset($_SESSION["OTP"]);
        unset($storedOTP);
       
        $pass = ranPWD();
        
        //sendMail($email, $firstname); // Send verification email here
        echo $pass;
        sendVerificationEmail($email, $firstname, $pass);
        $Generated_pass = password_hash($pass, PASSWORD_DEFAULT);
        insertUser($pdoConnect, $email, $firstname, $middlename, $lastname, $Generated_pass);
        $_SESSION["email"] = $email;
        $_SESSION["firstname"] = $firstname;
        // unset($_SESSION['registration_data']);r
        header("location:home.php");
        // exit();
    } else {
        $message = 'Invalid OTP, please check your email.';
    }
}    


?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>
    <link rel="stylesheet" type="text/css" href="./include/style/style.css">

</head>
<body>

  <!-- Navigation bar -->
  <div class="navbar">
        <a href="index.php">Sample Website</a>
        <!-- You can add more links here -->
    </div>

<div class="main">
    <div class="container">
        <form action="" method="POST" id="otpForm" onsubmit="showLoading()">
            <h5 style="text-align: center; margin-bottom: 10px">We've sent the OTP to <?php echo htmlspecialchars($email); ?></h5>
            <input type="text" name="otpCode" value="" placeholder="Enter OTP" id="otpInput">
            <input type="submit" name="submit" value="Submit">
        </form>
        <div id="resendArea" style="text-align: center; margin-top: 10px;">
            <span id="timer"></span>
            <button onclick="resendOTP()" id="resendButton" style="display: none;">Resend OTP</button>
        </div>
        <?php
        if (isset($message)) {
           
                echo '<p class="red-text">' . $message . '</p>';
                
        }
        ?>
        
    </div>
</div>


</body>
</html>
