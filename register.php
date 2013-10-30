<?php 
$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

$firstName = $_POST['inputFirstName1'];
$lastName = $_POST['inputLastName1'];
$username = $_POST['inputUserName1'];
$email = $_POST['inputEmail1'];
$password = $_POST['inputPassword1'];

if ($_FILES["inputFile"]["error"] > 0) {
   echo "Error: " . $_FILES["inputFile"]["error"] . "<br>";
} else {
   move_uploaded_file($_FILES["inputFile"]["tmp_name"], "./assets/img/profilepics/" . $_FILES["inputFile"]["name"]);
   $picture = "./assets/img/profilepics/" . $_FILES["inputFile"]["name"];
}

if (!isset($picture)) {
   $query =  "INSERT INTO users (first_name, last_name, username, email, password)
      VALUES ('$firstName', '$lastName', '$username', '$email', '$password')";
} else {
   $query =  "INSERT INTO users (first_name, last_name, username, email, password, profile_photo)
      VALUES ('$firstName', '$lastName', '$username', '$email', '$password', '$picture')";
}


if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
}

mysqli_close($con);

// Return to the main page after this.
header('Location: ./index.php');

?>