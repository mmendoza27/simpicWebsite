<?php
session_start();

$alert_type = null;

if(isset($_SESSION['alert_type'])){
   $photoID = $_SESSION['photo_id'];
   $cid = $_SESSION['cid'];
   $comment = $_SESSION['comment'];
   $alert_type = $_SESSION['alert_type'];
   $_SESSION['alert_type'] = NULL;
}

$userID= $_GET["id"];

$con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");

if (mysqli_connect_errno()) {
        echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
}

$query = "SELECT * FROM users WHERE id=$userID";

if ($result = mysqli_query($con, $query)) {
        $userData = mysqli_fetch_array($result);
}

$picture = $userData["profile_photo"];
$firstName = $userData["first_name"];
$lastName = $userData["last_name"];
$emailAddress = $userData["email"];
$userName = $userData["username"];
$joinDate = $userData["registration_date"];
$joinDateMonthYear = date('F Y', strtotime($joinDate));

mysqli_close($con);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="assets/ico/favicon.png">

    <title>Simpic</title>

    <!-- Bootstrap core CSS -->
    <link href="dist/css/bootstrap.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./assets/css/navbar-static-top.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="../../assets/js/html5shiv.js"></script>
      <script src="../../assets/js/respond.min.js"></script>
    <![endif]-->
   </head>
   <body>

   <!-- Static navbar -->
   <div class="navbar navbar-default navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"></button>
            <a class="navbar-brand" href="./index.php"><span class="glyphicon glyphicon-camera"></span> Simpic</a>
        </div>
        <div class="navbar-collapse collapse">
         <ul class="nav navbar-nav">
          
         <?php
            if (isset($_SESSION['userID']) && isset($_COOKIE['LoginCredentials'])) {
               echo "<li class=''><a href='profile.php?id=$_SESSION[id]'>$_SESSION[userID]</a></li>";
            }
         ?> 
          
            <li class=""><a data-toggle="tab" href="#people">People</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Images <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class=""><a data-toggle="tab" href="#popular">Popular</a></li>
                <li class=""><a href="./img_viewer.php">All</a></li>
                <li class=""><a data-toggle="tab" href="#mostCommented">Most Commented</a></li>
              </ul>
            </li>
            <li><a data-toggle="collapse" data-target="#search" href="#">Search</a></li>
            
            <?php
                  if (isset($_SESSION['userID']) && isset($_COOKIE['LoginCredentials'])) {
                     echo "<li><a data-toggle='modal' href='#editProfile'>Edit Profile</a></li><li><a href='logout.php'>Logout</a></li>";
                  } else {
                     echo "<li><a data-toggle='modal' href='#register'>Register</a></li><li><a data-toggle='modal' href='#login'>Login</a></li>";
                  }
            ?>            
          </ul>
          <ul class="nav navbar-nav navbar-right">
          <form class="navbar-form form-inline">
            <div class="btn-group">
            
            <?php
               if (isset($_SESSION['userID']) && isset($_COOKIE['LoginCredentials'])) {
                  echo "<li><a data-toggle='modal' href='#upload'><button type='button' class='btn btn-primary'>Upload Photo</button></a></li>";
               }
            ?>
            
            </div>
         </form>
         </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

   <div class="collapse" id="search">
   <div class="alert alert-info">
    <div class="row">
     <div class="col-lg-8">
       <div class="input-group input-group-lg">

        <span class="input-group-addon">@</span>
        <input type="text" class="form-control" placeholder="Username">

      <span class="input-group-btn">
        <button class="btn btn-default" type="button">Search</button>
      </span>         
      
       </div><!-- /input-group -->
     </div><!-- /.col-lg-6 -->
   </div><!-- /.row -->
    </div><!-- /.alert-info -->
   </div>

    
<div class="tab-content">
   <div class="tab-pane active" id="home">
   
   
   
<?php
   echo "<div class='jumbotron'><div class='container'><img src='$picture' class='img-circle' width='275' height='275' alt='Responsive image'><div style='display: inline-block; margin-left: 40px;'><h1>$firstName $lastName</h1>
   <h2> $userName </h2><h4>Member since $joinDateMonthYear</h4></div></div></div>";
?>
     
   
   <div class="container">

    <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

		//Query user and user_images for image information 
		$imageqry = "SELECT * FROM user_images WHERE user_id = $userID ORDER BY upload_time DESC";
		//Prints 9 images and creates 9 modals filled with image information.
		if ($result = mysqli_query($con, $imageqry)) {
			while ($row = $result->fetch_array()) {
				$userID = $row["user_id"];
				$username = $userName;
				$photoID = $row["photo_id"];
				$UserImage = $row["filename"];
				$ProfilePhoto = $picture;
				$tag1 = $row["tag1"];
				$tag2 = $row["tag2"];
				$tag3 = $row["tag3"];
				$hearts = $row["hearts"];
				
				echo "<a href='#imgView$photoID' role='button' data-toggle='modal'><div class='thumbnail'><div class='caption-btm'><p><span class='label label-primary'>$tag1</span> <span class='label label-primary'>$tag2</span> <span class='label label-primary'>$tag3</span></p></div><img src='$UserImage' height= '275' width='350' class='img-thumbnail' alt='Responsive image'></div></a>";
				
				//modal
				echo "<div id='imgView$photoID' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
				echo "<div class='modal-dialog'>
						<div class='modal-content'>
						   <div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
								<div class='media'>
								<a class='pull-left'>";
				echo "          	<img class='img-circle' src='$ProfilePhoto' alt='64x64' style='width: 68px; height: 68px;'>";
				echo "          </a>
								<div class='media-body'>";
				echo "				<h4 class='user-name'>$username</h4>";
				
				//   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion'>
				
				echo " 			</div>
						  </div>
					   </div> <!-- /.modal-header -->
					   <div class='modal-body' style='height: 615px';>
						  <div class='top-menu' style='width: 534px;'>
						  <div class='media-options' style='position:absolute;'>
								<div class='panel panel-default'>
							 <div class='panel-group' id='accordian'>
								   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseCList$photoID'><button class='btn'><span class='glyphicon glyphicon-list'></span></button></a>
								   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseComment$photoID'><button class='btn'><span class='glyphicon glyphicon-comment'></span></button></a>
								</div><!-- //top-panel -->
								<div>
								   <div id='collapseCList$photoID' class='panel-collapse collapse' style='background:white;'>
									  <div class='comments' style='width: 534px; height: 434px; overflow:scroll;'>
										 <table class='table'>
											<thead>
											   <tr>
												  <th>Comment</th>
												  <th>Username</th>
												  <th>Options</th>
											   </tr>
											</thead>
											<tbody>";
											
											//query for comments
											$commentqry = "SELECT * FROM comments WHERE pid = '$photoID'";
											if ($CommentRow = mysqli_query($con, $commentqry)) {
												while ($C_row = mysqli_fetch_array($CommentRow)) {
														$comment = $C_row["comment"];
														$c_username = $C_row["c_username"];
														$cid = $C_row["cid"];
														
														echo "<tr>
																<td>$comment</td>
																<td>$c_username</td>";
														if(isset($_SESSION['id'])){
															if((strcmp($c_username,$_SESSION['userID'])) == 0 || (strcmp($userID, $_SESSION['id'])) == 0 ){
																echo "	<form name= 'deleteForm$photoID' action='delete_comment.php' class='form-horizontal' role= 'form' method='post'>
																		<input type='hidden' name='cid' value='$cid'>
																		<input type='hidden' name='photo_id' value='$photoID'>
																		<td><button type='submit'><span class='glyphicon glyphicon-trash'></span></button></td>
																		</form>";
															}else{
																echo" <td></td>";
															}
														}else {
															echo "<td></td>";
														}
														echo"</tr> ";
												}
											}
										echo "</tbody>
										 </table>
									  </div>
								   </div>
								   <div id='collapseComment$photoID' class='panel-collapse collapse' style='background:white;'>
									  <div class='comment-body'>
										<form name='commentForm$photoID' action='add_comment.php' class='form-horizontal' role='form' method='post'>		
											<input type='hidden' name='photo_id' id='photo_id' value ='$photoID'> 
											<div class='make-comment' style='width: 534px; height: 120px;'>";
											if(isset($_SESSION['id'])){
											 echo"
												<div class='comment-box'>
													<textarea type='text' name='user_comment' id='user_comment' class='form-control' rows='3' placeholder='140 Characters Max'></textarea>
												</div>
												<div class='sub-comment' style='margin-top:10px;'>
													<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
													<button type='submit' class='btn btn-success'>Submit</button>
												</div>";
											}else{
												echo "<div class='comment-box'>
												<p><center>You must sign-in to add a comment.</p>
													<a data-toggle='modal' href='#login'><button type='button' class='btn btn-primary'>Login</button></center></a>
													</div>";
											}
											echo "	
											</div>
										 </form>
									  </div> <!-- comment-body -->
								   </div><!-- collapse-comment -->
								</div><!-- collapse-panels --> 
							 </div><!-- panel-group -->
							</div> <!-- media-options -->";
						  /*<div class='media-options2'>
							<form name='rating' action='hearts.php' role= 'form' method='post'> 
										<input type='hidden' name='photo_id' value='$photoID'>
										<button class='btn' type='submit'><span class='glyphicon glyphicon-heart'></span><span class='badge'>$hearts</span></button>
							</form>
							</div> <!-- //media-options2 -->*/
							
						echo"	</div> <!-- //top-menu -->
						  <div class='media'>";
				echo "		<img class='media-object' src='$UserImage' alt='' style='width: 534px; height: 534px;'>";
				echo "	  </div><!-- //media end -->
						  <div class='media-info'>
							 <div class='tags'  style='width: 470px; float: left;'>
								<span class='glyphicon glyphicon-tag'></span>
								$tag1, $tag2, $tag3
							 </div>
							
							<div class='current-hearts' style='float: right;'>
								<form name='rating' action='hearts.php' role= 'form' method='post'> 
										<input type='hidden' name='photo_id' value='$photoID'>
										<button class='btn' type='submit'><span class='glyphicon glyphicon-heart'></span><span class='badge'>$hearts</span></button>
								</form>
							</div>
							
							</div><!-- //media-info -->
					   </div> <!-- /.modal-body -->           
					   <div class='modal-footer' style='margin-top:10px;'>
						  <button class='btn btn-danger' data-dismiss='modal'>Close</button>
					   </div><!-- /.modal-footer -->
					</div><!-- /.modal-content -->
				 </div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->";
			}
		} else {
   		echo "NOTHING HERE.";
		}

       mysqli_close($con);

    ?>
    </div> <!-- /container -->    
     
   </div>
   
   
   <div class="tab-pane" id="people">
     
   <div class="container" style="margin-top:100px; margin-bottom:100px;">
     <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

       $query = "SELECT * FROM users ORDER BY registration_date DESC";

       if (!mysqli_query($con, $query)) {
         die('Error: ' . mysqli_error($con));
       }

       if ($result = mysqli_query($con, $query)) {
         while ($row = $result->fetch_array()) {
            $id = $row['id'];
            $username = $row['username'];
            echo "<a href='profile.php?id=$id'><div class='thumbnail'><div class='caption-btm'><p>$username</p></div><img src='$row[profile_photo]' class='img-thumbnail' alt='Responsive image'/></div></a>";
         }
       }

       mysqli_close($con);
    ?>
    </div> <!-- /container -->
     
   </div>   
   
   
   <div class="tab-pane" id="popular">
   
   <div class="container" style="margin-top:100px;">

    <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

		//Query user and user_images for image information 
		$imageqry = "SELECT * FROM user_images i, users u WHERE u.id = i.user_id ORDER BY hearts DESC LIMIT 9";
		//Prints 9 images and creates 9 modals filled with image information.
		if ($result = mysqli_query($con, $imageqry)) {
			while ($row = $result->fetch_array()) {
				$userID = $row["user_id"];
				$username = $row["username"];
				$photoID = $row["photo_id"];
				$UserImage = $row["filename"];
				$ProfilePhoto = $row["profile_photo"];
				$tag1 = $row["tag1"];
				$tag2 = $row["tag2"];
				$tag3 = $row["tag3"];
				$hearts = $row["hearts"];
				
				echo "<a href='#imgView$photoID' role='button' data-toggle='modal'><div class='thumbnail'><div class='caption-btm'><p><span class='label label-danger'>$hearts <span class='glyphicon glyphicon-heart'></span></span></p></div><img src='$UserImage' height= '275' width='350' class='img-thumbnail' alt='Responsive image'></div></a>";
				
				//modal
				echo "<div id='imgView$photoID' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
				echo "<div class='modal-dialog'>
						<div class='modal-content'>
						   <div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
								<div class='media'>
								<a class='pull-left'>";
				echo "          	<img class='img-circle' src='$ProfilePhoto' alt='64x64' style='width: 68px; height: 68px;'>";
				echo "          </a>
								<div class='media-body'>";
				echo "				<h4 class='user-name'>$username</h4>";
				
				//   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion'>
				
				echo " 			</div>
						  </div>
					   </div> <!-- /.modal-header -->
					   <div class='modal-body' style='height: 615px';>
						  <div class='top-menu' style='width: 534px;'>
						  <div class='media-options' style='position:absolute;'>
								<div class='panel panel-default'>
							 <div class='panel-group' id='accordian'>
								   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseCList$photoID'><button class='btn'><span class='glyphicon glyphicon-list'></span></button></a>
								   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#collapseComment$photoID'><button class='btn'><span class='glyphicon glyphicon-comment'></span></button></a>
								</div><!-- //top-panel -->
								<div>
								   <div id='collapseCList$photoID' class='panel-collapse collapse' style='background:white;'>
									  <div class='comments' style='width: 534px; height: 434px; overflow:scroll;'>
										 <table class='table'>
											<thead>
											   <tr>
												  <th>Comment</th>
												  <th>Username</th>
												  <th>Options</th>
											   </tr>
											</thead>
											<tbody>";
											
											//query for comments
											$commentqry = "SELECT * FROM comments WHERE pid = '$photoID'";
											if ($CommentRow = mysqli_query($con, $commentqry)) {
												while ($C_row = mysqli_fetch_array($CommentRow)) {
														$comment = $C_row["comment"];
														$c_username = $C_row["c_username"];
														$cid = $C_row["cid"];
														
														echo "<tr>
																<td>$comment</td>
																<td>$c_username</td>";
														if(isset($_SESSION['id'])){
															if((strcmp($c_username,$_SESSION['userID'])) == 0 || (strcmp($userID, $_SESSION['id'])) == 0 ){
																echo "	<form name= 'deleteForm$photoID' action='delete_comment.php' class='form-horizontal' role= 'form' method='post'>
																		<input type='hidden' name='cid' value='$cid'>
																		<input type='hidden' name='photo_id' value='$photoID'>
																		<td><button type='submit'><span class='glyphicon glyphicon-trash'></span></button></td>
																		</form>";
															}else{
																echo" <td></td>";
															}
														}else {
															echo "<td></td>";
														}
														echo"</tr> ";
												}
											}
										echo "</tbody>
										 </table>
									  </div>
								   </div>
								   <div id='collapseComment$photoID' class='panel-collapse collapse' style='background:white;'>
									  <div class='comment-body'>
										<form name='commentForm$photoID' action='add_comment.php' class='form-horizontal' role='form' method='post'>		
											<input type='hidden' name='photo_id' id='photo_id' value ='$photoID'> 
											<div class='make-comment' style='width: 534px; height: 120px;'>";
											if(isset($_SESSION['id'])){
											 echo"
												<div class='comment-box'>
													<textarea type='text' name='user_comment' id='user_comment' class='form-control' rows='3' placeholder='140 Characters Max'></textarea>
												</div>
												<div class='sub-comment' style='margin-top:10px;'>
													<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
													<button type='submit' class='btn btn-success'>Submit</button>
												</div>";
											}else{
												echo "<div class='comment-box'>
												<p><center>You must sign-in to add a comment.</p>
													<a data-toggle='modal' href='#login'><button type='button' class='btn btn-primary'>Login</button></center></a>
													</div>";
											}
											echo "	
											</div>
										 </form>
									  </div> <!-- comment-body -->
								   </div><!-- collapse-comment -->
								</div><!-- collapse-panels --> 
							 </div><!-- panel-group -->
							</div> <!-- media-options -->";
						  /*<div class='media-options2'>
							<form name='rating' action='hearts.php' role= 'form' method='post'> 
										<input type='hidden' name='photo_id' value='$photoID'>
										<button class='btn' type='submit'><span class='glyphicon glyphicon-heart'></span><span class='badge'>$hearts</span></button>
							</form>
							</div> <!-- //media-options2 -->*/
							
						echo"	</div> <!-- //top-menu -->
						  <div class='media'>";
				echo "		<img class='media-object' src='$UserImage' alt='' style='width: 534px; height: 534px;'>";
				echo "	  </div><!-- //media end -->
						  <div class='media-info'>
							 <div class='tags'  style='width: 470px; float: left;'>
								<span class='glyphicon glyphicon-tag'></span>
								$tag1, $tag2, $tag3
							 </div>
							
							<div class='current-hearts' style='float: right;'>
								<form name='rating' action='hearts.php' role= 'form' method='post'> 
										<input type='hidden' name='photo_id' value='$photoID'>
										<button class='btn' type='submit'><span class='glyphicon glyphicon-heart'></span><span class='badge'>$hearts</span></button>
								</form>
							</div>
							
							</div><!-- //media-info -->
					   </div> <!-- /.modal-body -->           
					   <div class='modal-footer' style='margin-top:10px;'>
						  <button class='btn btn-danger' data-dismiss='modal'>Close</button>
					   </div><!-- /.modal-footer -->
					</div><!-- /.modal-content -->
				 </div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->";
			}
		}

       mysqli_close($con);
    ?>
    </div> <!-- /container -->    
        
   </div>
   
   
   <div class="tab-pane" id="mostCommented">  
   <div class="container" style="margin-top:100px;">

    <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

		//Query user and user_images for image information 
		$imageqry = "SELECT * FROM user_images i, users u WHERE u.id = i.user_id ORDER BY comment_count DESC LIMIT 9";
		//Prints 9 images and creates 9 modals filled with image information.
		if ($result = mysqli_query($con, $imageqry)) {
			while ($row = $result->fetch_array()) {
				$userID = $row["user_id"];
				$username = $row["username"];
				$photoID = $row["photo_id"];
				$UserImage = $row["filename"];
				$ProfilePhoto = $row["profile_photo"];
				$tag1 = $row["tag1"];
				$tag2 = $row["tag2"];
				$tag3 = $row["tag3"];
				$hearts = $row["hearts"];
				$commentCount = $row["comment_count"];
				
				echo "<a href='#mimgView$photoID' role='button' data-toggle='modal'><div class='thumbnail'><div class='caption-btm'><p><span class='label label-danger'>$commentCount <span class='glyphicon glyphicon-comment'></span></span></p></div><img src='$UserImage' height= '275' width='350' class='img-thumbnail' alt='Responsive image'></div></a>";
					
				//modal
				echo "<div id='mimgView$photoID' class='modal fade' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true'>";
				echo "<div class='modal-dialog'>
						<div class='modal-content'>
						   <div class='modal-header'>
								<button type='button' class='close' data-dismiss='modal' aria-hidden='true'>×</button>
								<div class='media'>
								<a class='pull-left'>";
				echo "          	<img class='img-circle' src='$ProfilePhoto' alt='64x64' style='width: 68px; height: 68px;'>";
				echo "          </a>
								<div class='media-body'>";
				echo "				<h4 class='user-name'>$username</h4>";
				
				//   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion'>
				
				echo " 			</div>
						  </div>
					   </div> <!-- /.modal-header -->
					   <div class='modal-body' style='height: 615px';>
						  <div class='top-menu' style='width: 534px;'>
						  <div class='media-options' style='position:absolute;'>
								<div class='panel panel-default'>
							 <div class='panel-group' id='accordian'>
								   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#mcollapseCList$photoID'><button class='btn'><span class='glyphicon glyphicon-list'></span></button></a>
								   <a class='accordion-toggle' data-toggle='collapse' data-parent='#accordion' href='#mcollapseComment$photoID'><button class='btn'><span class='glyphicon glyphicon-comment'></span></button></a>
								</div><!-- //top-panel -->
								<div>
								   <div id='mcollapseCList$photoID' class='panel-collapse collapse' style='background:white;'>
									  <div class='comments' style='width: 534px; height: 434px; overflow:scroll;'>
										 <table class='table'>
											<thead>
											   <tr>
												  <th>Comment</th>
												  <th>Username</th>
												  <th>Options</th>
											   </tr>
											</thead>
											<tbody>";
											
											//query for comments
											$commentqry = "SELECT * FROM comments WHERE pid = '$photoID'";
											if ($CommentRow = mysqli_query($con, $commentqry)) {
												while ($C_row = mysqli_fetch_array($CommentRow)) {
														$comment = $C_row["comment"];
														$c_username = $C_row["c_username"];
														$cid = $C_row["cid"];
														
														echo "<tr>
																<td>$comment</td>
																<td>$c_username</td>";
														if(isset($_SESSION['id'])){
															if((strcmp($c_username,$_SESSION['userID'])) == 0 || (strcmp($userID, $_SESSION['id'])) == 0 ){
																echo "	<form name= 'deleteForm$photoID' action='delete_comment.php' class='form-horizontal' role= 'form' method='post'>
																		<input type='hidden' name='cid' value='$cid'>
																		<input type='hidden' name='photo_id' value='$photoID'>
																		<td><button type='submit'><span class='glyphicon glyphicon-trash'></span></button></td>
																		</form>";
															}else{
																echo" <td></td>";
															}
														}else {
															echo "<td></td>";
														}
														echo"</tr> ";
												}
											}
										echo "</tbody>
										 </table>
									  </div>
								   </div>
								   <div id='mcollapseComment$photoID' class='panel-collapse collapse' style='background:white;'>
									  <div class='comment-body'>
										<form name='commentForm$photoID' action='add_comment.php' class='form-horizontal' role='form' method='post'>		
											<input type='hidden' name='photo_id' id='photo_id' value ='$photoID'> 
											<div class='make-comment' style='width: 534px; height: 120px;'>";
											if(isset($_SESSION['id'])){
											 echo"
												<div class='comment-box'>
													<textarea type='text' name='user_comment' id='user_comment' class='form-control' rows='3' placeholder='140 Characters Max'></textarea>
												</div>
												<div class='sub-comment' style='margin-top:10px;'>
													<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
													<button type='submit' class='btn btn-success'>Submit</button>
												</div>";
											}else{
												echo "<div class='comment-box'>
												<p><center>You must sign-in to add a comment.</p>
													<a data-toggle='modal' href='#login'><button type='button' class='btn btn-primary'>Login</button></center></a>
													</div>";
											}
											echo "	
											</div>
										 </form>
									  </div> <!-- comment-body -->
								   </div><!-- collapse-comment -->
								</div><!-- collapse-panels --> 
							 </div><!-- panel-group -->
							</div> <!-- media-options -->";
						  /*<div class='media-options2'>
							<form name='rating' action='hearts.php' role= 'form' method='post'> 
										<input type='hidden' name='photo_id' value='$photoID'>
										<button class='btn' type='submit'><span class='glyphicon glyphicon-heart'></span><span class='badge'>$hearts</span></button>
							</form>
							</div> <!-- //media-options2 -->*/
							
						echo"	</div> <!-- //top-menu -->
						  <div class='media'>";
				echo "		<img class='media-object' src='$UserImage' alt='' style='width: 534px; height: 534px;'>";
				echo "	  </div><!-- //media end -->
						  <div class='media-info'>
							 <div class='tags'  style='width: 470px; float: left;'>
								<span class='glyphicon glyphicon-tag'></span>
								$tag1, $tag2, $tag3
							 </div>
							
							<div class='current-hearts' style='float: right;'>
								<form name='rating' action='hearts.php' role= 'form' method='post'> 
										<input type='hidden' name='photo_id' value='$photoID'>
										<button class='btn' type='submit'><span class='glyphicon glyphicon-heart'></span><span class='badge'>$hearts</span></button>
								</form>
							</div>
							
							</div><!-- //media-info -->
					   </div> <!-- /.modal-body -->           
					   <div class='modal-footer' style='margin-top:10px;'>
						  <button class='btn btn-danger' data-dismiss='modal'>Close</button>
					   </div><!-- /.modal-footer -->
					</div><!-- /.modal-content -->
				 </div><!-- /.modal-dialog -->
			  </div><!-- /.modal -->";
			}
		}

       mysqli_close($con);


    ?>
    </div> <!-- /container -->
   </div>
   
   <div class="tab-pane" id="about" style="margin-top:100px;">
   
      <div class="container">
		<center><h2>About Us</h2></center><br>
		<p>The main goal of Simpic is to provide a seamless, easy-to-use, interactive and enjoyable image sharing experience to all users. Since we want our audience to consist of young and old, those familiar and those unfamiliar with computers, our aim is to provide a tool that engages users to continue using our service regularly. Through our own individual studies, increasingly advanced camera technology is pushing individuals to share moments with their family and friends. People are starting to take pride in their pictures and express their creativity through their digital camera roll. </p>
      </div> <!-- /container -->
   
   </div>
   
   <div class="tab-pane" id="FAQ" style="margin-top:100px;">
   
       <div class="container">
		<center><h2>Simpic FAQ</h2></center><br>	
		<!-- Faq Questions -->
		<div class="container-fluid">
			<div class="accordion" id="accordion2">
				
				<!-- FAQ #1 - What is Simpic -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
							<h4>What is Simpic? (Click to expand)</h4>
						</a>
					</div>
					<div id="collapseOne" class="accordion-body collapse" style="height: 0px; ">
						<div class="accordion-inner">
							<p>Simpic is a photo sharing site which is AWESOMEEE. The main goal of Simpic is to provide a seamless, easy-to-use, interactive and enjoyable image sharing experience to all users. Since we want our audience to consist of young and old, those familiar and those unfamiliar with computers, our aim is to provide a tool that engages users to continue using our service regularly.</p><br>
						</div>
					</div>
				</div>
				
				<!-- FAQ #2 How do you pronounce Simpic? -->
				<div class="accordion-group">
				  <div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
					 <h4>How do you pronounce Simpic? (Click me to expand)</h4>
					</a>
				  </div>
				  <div id="collapseTwo" class="accordion-body collapse">
					<div class="accordion-inner">
					 <p>Simpic is pronounced as "Sim-Pick". It is short for Simple Picture. This name was created during an inspirational episode experienced by Amber while being sleep deprived for 20+ hours.
					 by </p><br>
					</div>
				  </div>
				</div>
				
				<!-- FAQ #3 How many images can I upload? -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
							<h4>How many images can I upload? (Click me to expand)</h4>
						</a>
					</div>
					<div id="collapseThree" class="accordion-body collapse">
						<div class="accordion-inner">
						<p>Your account comes with 5GB of free space. YOU CAN DOWNLOAD TONSSSS!!!!1111one</p><br>
						</div>
					</div>
				</div>
				
				<!-- FAQ #4 Can I delete an image after I upload it? -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
						<h4>Can I delete an image after I upload it? (Click me to expand)</h4>
						</a>
					</div>
					<div id="collapseFour" class="accordion-body collapse">
						<div class="accordion-inner">
						<p>Yes, when viewing your image, there is a "delete button" at the top of the screen which prompts to
						delete the image.</p><br>
						</div>
					</div>
				</div>
				
				<!-- FAQ #5 What file types are allowed? -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
						<h4>What file types are allowed? (Click me to expand)</h4>
						</a>
					</div>
					<div id="collapseFive" class="accordion-body collapse">
						<div class="accordion-inner">
							<p>Jpeg, gif and png are allowed. We plan on expanding and utilizing other file types but we are still in our beta period. Please feel free to contact us to provide feedback. Talk to us around school and let us know what other file types you would like to see! In the future, we are possibly considering adding video and other multimedia types. Stay tuned.</p><br>
						</div>
					</div>
				</div
				
				<!-- FAQ #6 The image quality is worse after I uploaded my image! -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
						<h4>The image quality is worse after I uploaded my image! (Click me to expand)</h4>
						</a>
					</div>
					<div id="collapseSix" class="accordion-body collapse">
						<div class="accordion-inner">
							<p>Too bad, yo.</p><br>
						</div>
					</div>
				</div>
				
			</div>
		</div>
    </div> <!-- /container -->	

   
   </div>
   
   <div class="tab-pane" id="contactUs" style="margin-top:100px;">
   
   <div class="container">
		<center><h2>Contact Us</h2></center><br><br>
		
		<center><a href="mailto:danielm8587@gmail.com"><img src="./assets/img/static/daniel.jpg" width="200" height="200" class="img-circle" alt="Responsive image"></a>
		<a href="mailto:ambertx09@gmail.com"><img src="./assets/img/static/amber.jpg" width="200" height="200" class="img-circle" alt="Responsive image"></a>
		<a href="mailto:mmendoza27@satx.rr.com"><img src="./assets/img/static/michael.jpg"  width="200" height="200" class="img-circle" alt="Responsive image"></a>
		<a href="mailto:sososeng@gmail.com"><img src="./assets/img/static/sokhun.jpg" width="200" height="200" class="img-circle" alt="Responsive image"></a>
		<a href="mailto:kvela415@gmail.com"><img src="./assets/img/static/kevin.jpg" width="200" height="200" class="img-circle" alt="Responsive image"></a></center><br><br>
		
		<p>All of us are currently enrolled at Computer Science students at the University of Texas at San Antonio.
   		We are currently taking security, programming theory and user interface courses. Our hope is that you enjoy
   		this website and use it to it's full advantage. Please feel free to click on our images to send us an email
   		and let us know what you think of the website. We appreciate your feedback.
		</p>
    </div> <!-- /container -->

   
   </div>
   
      <div class="tab-pane" id="copyright" style="margin-top:100px;">
   
   <div class="container">
		<center><h2>Copyright</h2></center><br>
	<p>By uploading a file or other content or by making a comment, you represent and warrant
	to us that (1) doing so does not violate or infringe anyone else’s rights; and (2) you 
	created the file or other content you are uploading, or otherwise have sufficient 
	intellectual property rights to upload the material consistent with these terms. With 
	regard to any file or content you upload to the public portions of our site, you grant 
	Simpic a non-exclusive, royalty-free, perpetual, irrevocable worldwide license (with 
	sublicense and assignment rights) to use, to display online and in any present or future 
	media, to create derivative works of, to allow downloads of, and/or distribute any such 
	file or content. To the extent that you delete a such file or content from the public 
	portions of our site, the license you grant to Simpic pursuant to the preceding sentence 
	will automatically terminate, but will not be revoked with respect to any file or content 
	Simpic has already copied and sublicensed or designated for sublicense. Also, of course, 
	anything you post to a public portion of our site may be used by the public pursuant to 
	the following paragraph even after you delete it. 

	By downloading a file or other content from the Simpic site, you agree that you will not use
	such file or other content except for personal, non-commercial purposes, and you may not claim
	any rights to such file or other content, except to the extent otherwise specifically provided
	in writing.</p>
    </div> <!-- /container -->

   
   </div>
   
   
</div>
    
        
    <!-- Static bottom navbar -->
    <div class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".bottom-collapse"></button> <!-- NOTE! data-target was changed to .bottom-collapse -->
        </div>
        <div class="navbar-collapse collapse bottom-collapse"> <!-- NOTE! The extra bottom-collapse class put on here -->
          <ul class="nav navbar-nav">
            <li class=""><a data-toggle="tab" href="#contactUs">Contact Us</a></li>
            <li class=""><a data-toggle="tab" href="#FAQ">FAQ</a></li>
            <li class=""><a data-toggle="tab" href="#about">About</a></li>
            <li class=""><a data-toggle="tab" href="#copyright">Copyright</a></li>
          </ul>
        </div> <!-- /.nav-collapse -->
      </div>
    </div>

   <!-- Register Modal -->
   <div class="modal fade" id="register" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Register</h4>
        </div>
        <div class="modal-body">
        
      <form name="registration" id="registration" action="register.php" class="form-horizontal" role="form" method="post" enctype="multipart/form-data" >
      <div class="form-group">
       <label for="inputFirstName1" class="col-lg-2 control-label">Name</label>
       <div class="col-lg-10">
         <input type="text" name="inputFirstName1" class="form-control" id="inputFirstName1" placeholder="First" >
       </div>
      </div>
      <div class="form-group">
       <label for="inputLastName1" class="col-lg-2 control-label"></label>
       <div class="col-lg-10">
         <input type="text" name="inputLastName1" class="form-control" id="inputLastName1" placeholder="Last" >
       </div>
      </div>
      <div class="form-group">
       <label for="inputUserName1" class="col-lg-2 control-label">User ID</label>
       <div class="col-lg-10">
         <input type="text" name="inputUserName1" class="form-control" id="inputUserName1" placeholder="Username" >
       </div>
      </div>
      <div class="form-group">
       <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
       <div class="col-lg-10">
         <input type="email" name="inputEmail1" class="form-control" id="inputEmail1" placeholder="Email" >
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
       <div class="col-lg-10">
         <input type="password" name="inputPassword1" class="form-control" id="inputPassword1" placeholder="Password" >
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword2" class="col-lg-2 control-label"></label>
       <div class="col-lg-10">
         <input type="password" class="form-control" id="inputPassword2" placeholder="Verify Password" data-validation-match-match="inputPassword1" >
       </div>
      </div>
    
      <div class="modal-body">
       <div class="form-group">
          <label for="inputFile">Upload Photo</label>
          <input name="inputFile" type="file" id="inputFile">
          <p class="help-block">Please upload your picture from your device.</p>
        </div>
     </div>
      
        </div>
        
        <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Register</button>
        </div>
      </form>
      
      
      
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->

   <!-- Login Modal -->
   <div class="modal fade" id="login" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Login</h4>
        </div>
        
        <div class="modal-body">
        <form name="logOn" action="login.php" class="form-horizontal" role="form" method="post">
         <div class="form-group">
          <label for="inputUser1" class="col-lg-2 control-label">User ID</label>
          <div class="col-lg-10">
            <input type="text" name="inputUser1" class="form-control" id="inputUser1" placeholder="Username" required="required" />
          </div>
         </div>
         <div class="form-group">
          <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
          <div class="col-lg-10">
            <input type="password" name="inputPassword1" class="form-control" id="inputPassword1" placeholder="Password" required="required" />
          </div>
         </div>
        </div>
        
        <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->


   <!-- Upload Modal -->
   <div class="modal fade" id="upload" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Upload Photo</h4>
        </div>
        
      <div class="modal-body">        
      <form name="upload" action="upload.php" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">

         <div class="form-group">
          <label for="tag1" class="col-lg-2 control-label">Tag 1</label>
          <div class="col-lg-10">
            <input type="text" name="tag1" class="form-control" id="tag1" placeholder="Tag 1">
          </div>
         </div>
         
         <div class="form-group">
          <label for="tag2" class="col-lg-2 control-label">Tag 2</label>
          <div class="col-lg-10">
            <input type="text" name="tag2" class="form-control" id="tag2" placeholder="Tag 2">
          </div>
         </div>

         <div class="form-group">
          <label for="tag3" class="col-lg-2 control-label">Tag 3</label>
          <div class="col-lg-10">
            <input type="text" name="tag3" class="form-control" id="tag3" placeholder="Tag 3">
          </div>
         </div>
          
         <div class="modal-body">
            <div class="form-group">
             <label for="inputFile">Upload Photo</label>
             <input name="inputFile" type="file" id="inputFile">
             <p class="help-block">Please upload your picture from your device.</p>
           </div>
        </div>
        
      </div>
        
        <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Upload</button>
                </form>

          
        </div>
      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->


   <!-- Edit Profile Modal -->
   <div class="modal fade" id="editProfile" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Edit Profile</h4>
        </div>
        <div class="modal-body">
        
      <form name="editProfile" action="editProfile.php" class="form-horizontal" role="form" method="post">
      <div class="form-group">
       <label for="inputEmail1" class="col-lg-2 control-label">Email</label>
       <div class="col-lg-10">
         <input type="email" name="inputEmail1" class="form-control" id="inputEmail1" placeholder="Email">
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
       <div class="col-lg-10">
         <input type="password" name="inputPassword1" class="form-control" id="inputPassword1" placeholder="Password">
       </div>
      </div>
      <div class="form-group">
       <label for="inputPassword2" class="col-lg-2 control-label"></label>
       <div class="col-lg-10">
         <input type="password" class="form-control" id="inputPassword2" placeholder="Verify Password">
       </div>
      </div>
      <div class="form-group">
       <label for="inputUsername1" class="col-lg-2 control-label">Username</label>
       <div class="col-lg-10">
         <input type="text" name="inputUsername1" class="form-control" id="inputUsername1" placeholder="Username">
       </div>
      </div>
      
      <div class="modal-body">
       <div class="form-group">
          <label for="inputFile">Upload Photo</label>
          <input name="inputFile" type="file" id="inputFile">
          <p class="help-block">You may upload a new profile picture from your device.</p>
        </div>
     </div>
      
        </div>
        
        <div class="modal-footer">
          <button type="reset" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Edit Profile</button>
        </div>
      </form>

      </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
   </div><!-- /.modal -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/jquery.validate.js"></script>
    <script src="assets/js/usernameHover.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>
