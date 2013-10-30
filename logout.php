<?php
session_start();
unset($_SESSION['userID']);
setcookie("LoginCredentials", "", time() - 3600);
session_destroy();
header("Location: ./index.php");
?>