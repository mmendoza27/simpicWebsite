<?php
session_start();
$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

if(isset($_POST)){
		$photoID = $_POST['photo_id'];
		//increment comment count within user_images table
		$_SESSION['photo_id'] = $photoID;
		$_SESSION['alert_type'] = "rating";
		$hearts_count = "UPDATE user_images SET hearts=hearts+1 WHERE photo_id = $photoID";
		mysqli_query($con, $hearts_count);

}else{
	echo "DIS SHIZ BE EMPTY";
}
header("location: img_viewer.php");
?>