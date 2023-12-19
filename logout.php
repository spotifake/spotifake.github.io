<?php
session_start();
unset($_SESSION["user"]);
unset($_SESSION['registration_data']);
session_destroy();
header('location: index.php');
?>