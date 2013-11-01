<?php

session_start();

$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

$userID = $_SESSION['id'];
$email = $_POST['inputEmail1'];
$password = $_POST['inputPassword1'];
$username = $_POST['inputUsername1'];

if ($_FILES["inputFile"]["error"] > 0) {
   echo "Error: " . $_FILES["inputFile"]["error"] . "<br>";
} else {
   move_uploaded_file($_FILES["inputFile"]["tmp_name"], "./assets/img/userImages/" . $_FILES["inputFile"]["name"]);
   $picture = "./assets/img/userImages/" . $_FILES["inputFile"]["name"];
}

$query =  "UPDATE users SET username=$username, password=$password, email=$email, profile_photo=$picture WHERE id = $id";


if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
}

mysqli_close($con);

// Return to the main page after this.
header('Location: ./index.php');

?>