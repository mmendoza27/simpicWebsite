<!DOCTYPE HTML>
<?php
session_start();
$alert_type = NULL;

if(isset($_SESSION['alert_type'])){
$photoID = $_SESSION['photo_id'];
$cid = $_SESSION['cid'];
$comment = $_SESSION['comment'];
$alert_type = $_SESSION['alert_type'];
$_SESSION['alert_type'] = NULL;
}
?>

<?
echo "
<html lang='en'>
  <head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <meta name='description' content=''>
    <meta name='author' content=''>
    <link rel='shortcut icon' href='assets/ico/favicon.png'>

    <title>Simpic</title>

    <!-- Bootstrap core CSS -->
    <link href='dist/css/bootstrap.css' rel='stylesheet'>

    <!-- Custom styles for this template -->
    <link href='navbar-static-top.css' rel='stylesheet'>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src='../../assets/js/html5shiv.js'></script>
      <script src='../../assets/js/respond.min.js'></script>
    <![endif]-->
   </head>

   <body>
      <!-- Static navbar -->
      <div class='navbar navbar-default navbar-fixed-top'>
         <div class='container'>
            <div class='navbar-header'>
               <button type='button' class='navbar-toggle' data-toggle='collapse' data-target='.navbar-collapse'></button>
               <a class='navbar-brand' href='#'>Simpic</a>
            </div>
            <div class='navbar-collapse collapse'>
            <ul class='nav navbar-nav'>
               <li><a href='#'>People</a></li>
               <li class='dropdown'>
                  <a href='#' class='dropdown-toggle' data-toggle='dropdown'>Images <b class='caret'></b></a>
                  <ul class='dropdown-menu'>
                     <li><a href='#popular'>Popular</a></li>
                     <li><a href='#current'>Current</a></li>
                     <li><a href='#topCommented'>Top Commented</a></li>
                  </ul>
               </li>
               <li><a href='#search'>Search</a></li>
               <li><a data-toggle='modal' href='#register'>Register</a></li>
               <li><a data-toggle='modal' href='#login'>Login</a></li>
            </ul>
            <ul class='nav navbar-nav navbar-right'>
               <form class='navbar-form form-inline'>
                  <div class='btn-group'>
                     <li><button type='button' class='btn btn-primary'>Upload Photo</button></li>
                  </div>
               </form>
            </ul>
            </div><!--/.nav-collapse -->
         </div>
      </div>

      <div class='jumbotron'>";
	  if($alert_type != null){
		if(strcmp($alert_type,"dcomment") == 0){
			echo "<div class='alert alert-warning' style='width: 100%'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<form name='undo_dodo' action='undo_dodo.php' class='form-horizontal' role='form' method='post'>
						<input type='hidden' name='dphoto_id' id='dphoto_id' value ='$photoID'> 
						<input type='hidden' name='dcomment' id='dcomment' value ='$comment'>  
						<p>You have deleted your post. Was that a mistake? If so, click here --->
						<button class='btn btn-warning' type='submit'>Undo Deletion</button></a>
					</form>
				</div>";
		}elseif(strcmp($alert_type,"acomment") == 0){
				echo "<div class='alert alert-success' style='width: 100%'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<p>Thanks for commenting! Click here to see the photo ->
					<a href='#imgView$photoID' role='button' data-toggle='modal'><button class='btn btn-success' type='button'>Photo</button></a>
				</div>";
		}else{
				echo "<div class='alert alert-success' style='width: 100%'>
					<button type='button' class='close' data-dismiss='alert'>&times;</button>
					<p>Thanks for rating! Click here to see the photo ->
					<a href='#imgView$photoID' role='button' data-toggle='modal'><button class='btn btn-success' type='button'>Photo</button></a>
				</div>";
		
		}
	  }
	  
	echo "
      <div class='container'>
         <img src='./assets/img/static/Logo.png' class='img-responsive' alt='Responsive image'>
      </div> <!-- /container -->
    </div>
      <div class='container'>";
?>
       <?php
		$con = mysqli_connect("localhost","krobbins","abc123","simpic");
		
		
		// Check connection
		if (mysqli_connect_errno($con))
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
		
		//Query user and user_images for image information 
		$imageqry = "SELECT * FROM user_images i, users u WHERE u.id = i.user_id LIMIT 9";
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
				
				echo "<a href='#imgView$photoID' role='button' data-toggle='modal'><img src='$UserImage' height= '275' width='350' class='img-thumbnail' alt='Responsive image'></a>";
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
														if((strcmp($c_username,$_SESSION['userID'])) == 0 || (strcmp($userID, $_SESSION['id'])) == 0 ){
															echo "	<form name= 'deleteForm$photoID' action='delete_comment.php' class='form-horizontal' role= 'form' method='post'>
																	<input type='hidden' name='cid' value='$cid'>
																	<input type='hidden' name='photo_id' value='$photoID'>
																	<td><button type='submit'><span class='glyphicon glyphicon-trash'></span></button></td>
																	</form>";
														}else{
															echo" <td></td>";
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
											<div class='make-comment' style='width: 534px; height: 120px;'>
												<div class='comment-box'>
													<textarea type='text' name='user_comment' id='user_comment' class='form-control' rows='3' placeholder='140 Characters Max'></textarea>
												</div>
												<div class='sub-comment' style='margin-top:10px;'>
													<button type='button' class='btn btn-default' data-dismiss='modal'>Cancel</button>
													<button type='submit' class='btn btn-success'>Submit</button>
												</div>
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
			print_r($result);
			echo "Nothing here.";
		}
			
      ?>
      </div> <!-- /container -->    
                  

      <!-- Bootstrap core JavaScript
      ================================================== -->
      <!-- Placed at the end of the document so the pages load faster -->
      <span class="glyphicon glyphicon-search"></span>
      <script src="assets/js/jquery.js"></script>
      <script src="dist/js/bootstrap.min.js"></script>

   </body>
</html>