<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './PHPMailer/src/PHPMailer.php';
require './PHPMailer/src/SMTP.php';
require './PHPMailer/src/Exception.php';
require_once './include/connect/dbcon.php';

function ranNum(){
  $random_number = random_int(100000,999999);
  return $random_number;
}

function sendMail($email, $firstname) {
  try {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'samplewebemail@gmail.com';                     //SMTP username
    $mail->Password   = 'lvne gvmh clqa ibum';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('samplewebemail@gmail.com', 'Spotifake');
    $mail->addAddress( $email, $firstname,);     //Add a recipient
    $mail->addReplyTo('samplewebemail@gmail.com', 'Spotifake');

    // GENERATING RANDOM NUMBER
    $random_number = ranNum();

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'OTP Verification';
    $mail->Body    = "<h2>OTP Verification</h2><br>
                      Welcome " . $firstname . '<br>
                       your OTP is : <strong>' . $random_number . '</strong>'; 
    $mail->AltBody = 'your OTP is : ' . $random_number;

    // SESSION THE OTP
    $_SESSION["OTP"] = $random_number;

    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}

function ranPWD(){
  $random_pwd = bin2hex(random_bytes(5));
  return $random_pwd;
}

function sendVerificationEmail($email, $firstname,$pass) {
  try {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'samplewebemail@gmail.com';                     //SMTP username
    $mail->Password   = 'lvne gvmh clqa ibum';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('samplewebemail@gmail.com', 'Spotifake');
    $mail->addAddress( $email, $firstname);     //Add a recipient
    $mail->addReplyTo('samplewebemail@gmail.com', 'Spotifake');

    // GENERATING RANDOM NUMBER
    // $random_pwd = ranPWD();
    
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Email Verification';
    $mail->Body    = "Your Email : " . $email . "<br>
                      Your password : <strong>" . $pass . "</strong>";
    $mail->AltBody = "Your Email : " . $email . "<br>
                      Your password : " . $pass;

    // SESSION THE OTP
    // $_SESSION["pass"] = $random_pwd;
    // $_SESSION["email-verify"] = $email;

    // $firstname = $_SESSION['registration_data']['firstname'];
    // $middlename = $_SESSION['registration_data']['middlename'];
    // $lastname = $_SESSION['registration_data']['lastname'];
    // $email = $_SESSION['registration_data']['email'];


    
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}

function insertUser($pdoConnect, $email, $firstname, $middlename, $lastname, $Generated_pass) {

  require_once 'include\connect\dbcon.php';
  

$pdoQuery = "INSERT INTO `user` (`firstname`, `middlename`, `lastname`, `email`, `password` ) VALUES (:firstname, :middlename, :lastname, :email, :password)";
                $pdoResult = $pdoConnect->prepare($pdoQuery);
                $pdoExec = $pdoResult->execute([
                    ":firstname" => $firstname,
                    ":middlename" => $middlename,
                    ":lastname" => $lastname,
                    ":email" => $email,
                    ":password" => $Generated_pass,
         
                ]);  
}

function selectuser($pdoConnect, $email) {
  require_once 'include/connect/dbcon.php';

  $sql = "SELECT * FROM user WHERE email = ?";
  $pdoResult = $pdoConnect->prepare($sql);
  $pdoResult->execute([$email]);
  
  // Fetch the user data
  $row = $pdoResult->fetch(PDO::FETCH_ASSOC);

  // Check the number of rows returned
  $count = $pdoResult->rowCount();

  return [
      'row' => $row,
      'count' => $count
  ];
}

function forgotpass($email, $firstname, $id) {
  try {

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'samplewebemail@gmail.com';                     //SMTP username
    $mail->Password   = 'lvne gvmh clqa ibum';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('samplewebemail@gmail.com', 'Spotifake');
    $mail->addAddress($email, $firstname,);     //Add a recipient
    $mail->addReplyTo('samplewebemail@gmail.com', 'Spotifake');

    // GENERATING RANDOM NUMBER

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Forgot Password';
    $mail->Body = "<h2>Change Password Request</h2><br>
               Hi " . $firstname . '<br>
               Here is the link to change your password <a href="http://localhost/prj/forgotpassword.php?id=' . $id . '">change password</a>,
               if you did not request this you can ignore it safely.'; 
    $mail->AltBody = 'Here is: <a href="http://localhost/prj/forgotpassword.php?id=' . $id . '">change password</a>';


    // SESSION THE OTP

    $mail->send();
  } catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
  }
}


