<?php 
session_start();
$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

$username = $_POST['inputUser1'];
$password = $_POST['inputPassword1'];

$query = "SELECT * FROM users WHERE `username` = '$username' AND `password` = '$password'";

if (!mysqli_query($con, $query)) {
        die('Error: ' . mysqli_error($con));
}

if ($result = mysqli_query($con, $query)) {
        $row = $result->fetch_array();
        
        if ($row != null) {
                $_SESSION['userID'] = $row['username'];
                $_SESSION['id'] = $row['id'];
                setcookie("LoginCredentials", $_SESSION['userID'], time() + 86400);
                header("Location: ./index.php");
        } else {
                echo "Incorrect login credentials! Redirecting...";
                header("Refresh: 3; URL=./index.php");
        }
}

?>