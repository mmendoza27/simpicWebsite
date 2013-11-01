<?php
session_start();
$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

if(isset($_POST)){
		$cid = $_POST['cid'];
		$photoID = $_POST['photo_id'];
		
		$grabComment = "SELECT * FROM comments WHERE cid = $cid";  
		$gComment = mysqli_query($con, $grabComment);
		$commentRow = mysqli_fetch_array($gComment); 
		$comment = $commentRow['comment'];
		$_SESSION['comment'] = $comment;
		$_SESSION['alert_type'] = "dcomment";
		$_SESSION['cid'] = $cid;
		$deleteComment = "DELETE FROM comments WHERE cid = $cid";
		mysqli_query($con, $deleteComment);
		
		
		
		//decrement comment count within user_images table
		$comment_count = "UPDATE user_images SET comment_count = comment_count-1 WHERE photo_id = $photoID";
		mysqli_query($con, $comment_count);
		
}else{
	echo "DIS SHIZ BE EMPTY";
}
header("location: img_viewer.php");
//header("location: img_viewer.php#imgView$photoID");
?>