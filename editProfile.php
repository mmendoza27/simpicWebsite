<?php

session_start();

$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
   echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

$userID = $_SESSION['id'];
$email = $_POST['inputEmail1'];
$password = $_POST['inputPassword1'];

if ($_FILES["inputFile"]["error"] > 0) {

} else {
   move_uploaded_file($_FILES["inputFile"]["tmp_name"], "./assets/img/profilepics/" . $_FILES["inputFile"]["name"]);
   $picture = "./assets/img/profilepics/" . $_FILES["inputFile"]["name"];
}

$query =  "UPDATE users SET ";

if(!empty($email)) {
   $array = array("email='$email'");
}

if(!empty($password)) {
   $array[] = "password='$password'";
}

if(!empty($picture)) {
   $array[] = "profile_photo='$picture'";
}

$query .= " " . implode(', ', $array) . " WHERE id = '$userID'";


if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
}

mysqli_close($con);

// Return to the main page after this.
unset($_SESSION['userID']);
setcookie("LoginCredentials", "", time() - 3600);
session_destroy();
echo "Please log back in with your updated credentials.";
header("Refresh: 3; URL=./index.php");

?>