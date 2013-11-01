<?php
session_start();
$con = mysqli_connect('localhost', 'krobbins', 'abc123', 'simpic');

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

if(isset($_POST)){
		//$searchString = $_POST['search_string'];
		$searchString = "birds";
		
		//$searchqry = "SELECT tag1, tag2, tag3 FROM user_images WHERE tag1 = $searchString OR tag2 = $searchString OR tag3 = $searchString";
		$searchqry = "SELECT * FROM user_images WHERE tag1 = '$searchString'";
		$searchqry2 = "SELECT * FROM user_images WHERE tag2 = '$searchString'";
		$searchqry3 = "SELECT * FROM user_images WHERE tag3 = '$searchString'";
		
		$search1 = mysqli_query($con, $searchqry);
		$search2 = mysqli_query($con, $searchqry2);
		$search3 = mysqli_query($con, $searchqry3);
		
		$count = 0;
		
		while($result = mysqli_fetch_array($search1)) {
			$_SESSION["pid$count"] = $result['photo_id'];
			$count = $count + 1;
		}
		while($result = mysqli_fetch_array($search2)) {
			$_SESSION["pid$count"] = $result['photo_id'];
			$count = $count + 1;
		}
		while($result = mysqli_fetch_array($search3)) {
			$_SESSION["pid$count"] = $result['photo_id'];
			$count = $count + 1;
		}
		$j = 0;
		while(isset($_SESSION["pid$j"])){
			echo $_SESSION["pid$j"];
			$j = $j + 1;
		}
		
		//OR tag2 = $searchString OR tag3 = $searchString";
		//= mysqli_query($con, $searchqry);	
	}else{
	echo "DIS SHIZ BE EMPTY";
}
//header("location: img_viewer.php");
//header("location: img_viewer.php#imgView$photoID");
?>