<?php
session_start();
$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

if(isset($_POST)){
		$user_comment = $_POST['user_comment'];
		$photoID = $_POST['photo_id'];	
		$username = $_SESSION['userID'];
		$userID = $_SESSION['id'];
	
		$_SESSION['photo_id'] = $photoID;
		$_SESSION['alert_type'] = "acomment";
		
		
		//add new comment entry to comment table
		$addComment = "INSERT  INTO comments (uid,pid,comment,c_username) VALUES ('$userID','$photoID','$user_comment','$username')";  
		mysqli_query($con, $addComment);
		
		//increment comment count within user_images table
		$comment_count = "UPDATE user_images SET comment_count=comment_count+1 WHERE photo_id = $photoID";
		mysqli_query($con, $comment_count);
		
}else{
	echo "DIS SHIZ BE EMPTY";
}
header("location: img_viewer.php");
//header("location: img_viewer.php#imgView$photoID");
?>