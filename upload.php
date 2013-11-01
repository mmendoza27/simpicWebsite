<?php

session_start();

$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

$tag1 = $_POST['tag1'];
$tag2 = $_POST['tag2'];
$tag3 = $_POST['tag3'];
$userID = $_SESSION['id'];
$hearts = 0;
$comments = 0;

if ($_FILES["inputFile"]["error"] > 0) {
   echo "Error: " . $_FILES["inputFile"]["error"] . "<br>";
} else {
   move_uploaded_file($_FILES["inputFile"]["tmp_name"], "./assets/img/userImages/" . $_FILES["inputFile"]["name"]);
   $picture = "./assets/img/userImages/" . $_FILES["inputFile"]["name"];
}

$query =  "INSERT INTO user_images (user_id, hearts, tag1, tag2, tag3, filename, comment_count)
   VALUES ('$userID', '$hearts', '$tag1', '$tag2', '$tag3', '$picture', '$comments')";


if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
}

mysqli_close($con);

// Return to the main page after this.
header('Location: ./index.php');

?>