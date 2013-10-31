<?php
session_start();
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
          
          <?php
            if (isset($_SESSION['userID']) && isset($_COOKIE['LoginCredentials'])) {
               echo "<a class='navbar-brand' href='#profilePage'>$_SESSION[userID]</a>";
            } else {
               echo "<a class='navbar-brand' href='index.php'>Simpic</a>";
            }
         ?> 
          
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li class=""><a data-toggle="tab" href="#people">People</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Images <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li class=""><a data-toggle="tab" href="#popular">Popular</a></li>
                <!-- <li><a href="#current">Current</a></li> -->
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

    <div class="jumbotron">
      <div class="container">
         <img src="./assets/img/static/Logo.png" class="img-responsive" alt="Responsive image">
      </div> <!-- /container -->
    </div>
    
<div class="tab-content">
   <div class="tab-pane active" id="home">
     
         <div class="container">

    <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

       $query = "SELECT * FROM user_images ORDER BY upload_time DESC LIMIT 9";

       if (!mysqli_query($con, $query)) {
         die('Error: ' . mysqli_error($con));
       }

       if ($result = mysqli_query($con, $query)) {
         while ($row = $result->fetch_array()) {
            $picture = $row['filename'];
            $tag1 = "#" . $row['tag1'];
            $tag2 = "#" . $row['tag2'];
            $tag3 = "#" . $row['tag3'];
            echo "<a href='#'><div class='thumbnail'><div class='caption-btm'><p><span class='label label-primary'>$tag1</span> <span class='label label-primary'>$tag2</span> <span class='label label-primary'>$tag3</span></p></div><img src='$picture' class='img-thumbnail' alt='Responsive image'/></div></a>";
         }
       }

       mysqli_close($con);
    ?>
    </div> <!-- /container -->    
     
     
   </div>
   <div class="tab-pane" id="people">
     
   <div class="container">
     <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

       $query = "SELECT * FROM users ORDER BY registration_date DESC LIMIT 9";

       if (!mysqli_query($con, $query)) {
         die('Error: ' . mysqli_error($con));
       }

       if ($result = mysqli_query($con, $query)) {
         while ($row = $result->fetch_array()) {
            $username = $row['username'];
            echo "<a href='#'><div class='thumbnail'><div class='caption-btm'><p>$username</p></div><img src='$row[profile_photo]' class='img-thumbnail' alt='Responsive image'/></div></a>";
         }
       }

       mysqli_close($con);
    ?>
    </div> <!-- /container -->
         
     
   </div>
   <div class="tab-pane" id="popular">
   
   <div class="container">

    <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

       $query = "SELECT * FROM user_images ORDER BY hearts DESC LIMIT 9";

       if (!mysqli_query($con, $query)) {
         die('Error: ' . mysqli_error($con));
       }

       if ($result = mysqli_query($con, $query)) {
         while ($row = $result->fetch_array()) {
            $picture = $row['filename'];
            $heartCount = $row['hearts'];
            echo "<a href='#'><div class='thumbnail'><div class='caption-btm'><p><span class='label label-danger'>$heartCount <span class='glyphicon glyphicon-heart'></span></span></p></div><img src='$picture' class='img-thumbnail' alt='Responsive image'/></div></a>";
         }
       }

       mysqli_close($con);
    ?>
    </div> <!-- /container -->    
   
     
   </div>
   <div class="tab-pane" id="mostCommented">
     
          
   </div>
   
   <div class="tab-pane" id="contactUs">
   
      <div class="container">
		<center><font size="10">Contact Us</font><br></center>
		Simpic is a simple photo sharer which user's can easily upload, discover and rate photos.
		orem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod 
		tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, 
		quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo 
		consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie 
		consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto 
		odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait 
		nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet 
		doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; 
		est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt 
		lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, 
		qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, 
		quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula 
		quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, 
		fiant sollemnes in futurum.
      </div> <!-- /container -->
   
   </div>
   
   <div class="tab-pane" id="FAQ">
   
       <div class="container">
		<center><font size="10">Simpic FAQ</font></center>	
		<!-- Faq Questions -->
		<div class="container-fluid">
			<div class="accordion" id="accordion2">
				
				<!-- FAQ #1 - What is Simpic -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
							<font size="5">What is Simpic?</font> (Click to expand)
						</a>
					</div>
					<div id="collapseOne" class="accordion-body collapse" style="height: 0px; ">
						<div class="accordion-inner">
							Simpic is a photo sharing site which is AWESOMEEE. blah blah blah blah
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod 
							tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit 
							amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut 
							labore et dolore magna aliqua.
						</div>
					</div>
				</div>
				
				<!-- FAQ #2 How do you pronounce Simpic? -->
				<div class="accordion-group">
				  <div class="accordion-heading">
					<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
					 <font size="5">How do you pronounce Simpic?</font> (Click me to expand)
					</a>
				  </div>
				  <div id="collapseTwo" class="accordion-body collapse">
					<div class="accordion-inner">
					 Simpic is pronounced as "Sim-Pick". It is short for Simple Picture. This name was inspired
					 by 
					</div>
				  </div>
				</div>
				
				<!-- FAQ #3 How many images can I upload? -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseThree">
							<font size="5">How many images can I upload?</font> (Click me to expand)
						</a>
					</div>
					<div id="collapseThree" class="accordion-body collapse">
						<div class="accordion-inner">
						Your account comes with 5GB of free space. YOU CAN DOWNLOAD TONNSNSSSNSNN!!!!1111one
						</div>
					</div>
				</div>
				
				<!-- FAQ #4 Can I delete an image after I upload it? -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFour">
						<font size="5">Can I delete an image after I upload it?</font> (Click me to expand)
						</a>
					</div>
					<div id="collapseFour" class="accordion-body collapse">
						<div class="accordion-inner">
						Yes, when viewing your image, there is a "delete button" at the top of the screen which prompts to
						delete the image. You can either cancel or confirm the deletion. Lorem ipsum dolor sit amet, 
						consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
						Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut 
						labore et dolore magna aliqua.
						</div>
					</div>
				</div>
				
				<!-- FAQ #5 What file types are allowed? -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseFive">
						<font size="5">What file types are allowed?</font> (Click me to expand)
						</a>
					</div>
					<div id="collapseFive" class="accordion-body collapse">
						<div class="accordion-inner">
							Jpeg, gif and png are allowed! Lorem ipsum dolor sit amet, consectetur adipisicing elit, 
							sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Lorem ipsum dolor sit 
							amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore 
							magna aliqua.
						</div>
					</div>
				</div
				
				<!-- FAQ #6 The image quality is worse after I uploaded my image! -->
				<div class="accordion-group">
					<div class="accordion-heading">
						<a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseSix">
						<font size="5">	The image quality is worse after I uploaded my image!</font> (Click me to expand)
						</a>
					</div>
					<div id="collapseSix" class="accordion-body collapse">
						<div class="accordion-inner">
							Too bad, yo. 
						</div>
					</div>
				</div>
				
			</div>
		</div>
    </div> <!-- /container -->	

   
   </div>
   
   <div class="tab-pane" id="about">
   
   <div class="container">
		<center><font size="10">About Simpic</font><br>
		Simpic is a simple photo sharer which user's can easily upload, discover and rate photos.<br> 
		We are awesome, beautiful people. check it out!<br>
		<img src="./assets/img/static/daniel.jpg" width="200" height="200" class="img-circle" alt="Responsive image">
		<img src="./assets/img/static/amber.jpg" width="200" height="200" class="img-circle" alt="Responsive image"><br>
		<img src="./assets/img/static/michael.jpg"  width="200" height="200" class="img-circle" alt="Responsive image">
		<img src="./assets/img/static/sokhun.jpg" width="200" height="200" class="img-circle" alt="Responsive image">
		<img src="./assets/img/static/kevin.jpg" width="200" height="200" class="img-circle" alt="Responsive image"><br></center>
		&nbsp;&nbsp;&nbsp;Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy
		tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, 
		quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo 
		consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie 
		consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto 
		odio dignissim qui blandit praesent luptatum zzril delenit augue duis dolore te feugait 
		nulla facilisi. Nam liber tempor cum soluta nobis eleifend option congue nihil imperdiet 
		doming id quod mazim placerat facer possim assum. Typi non habent claritatem insitam; 
		est usus legentis in iis qui facit eorum claritatem. Investigationes demonstraverunt 
		lectores legere me lius quod ii legunt saepius. Claritas est etiam processus dynamicus, 
		qui sequitur mutationem consuetudium lectorum. Mirum est notare quam littera gothica, 
		quam nunc putamus parum claram, anteposuerit litterarum formas humanitatis per seacula 
		quarta decima et quinta decima. Eodem modo typi, qui nunc nobis videntur parum clari, 
		fiant sollemnes in futurum.
    </div> <!-- /container -->

   
   </div>
   
      <div class="tab-pane" id="copyright">
   
   <div class="container">
		<center><font size="10">Copyright Notice</font><br></center>
	By uploading a file or other content or by making a comment, you represent and warrant
	to us that (1) doing so does not violate or infringe anyone else’s rights; and (2) you 
	created the file or other content you are uploading, or otherwise have sufficient 
	intellectual property rights to upload the material consistent with these terms. With 
	regard to any file or content you upload to the public portions of our site, you grant 
	Simpic a non-exclusive, royalty- free, perpetual, irrevocable worldwide license (with 
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
	in writing. 
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
        
      <form name="registration" action="register.php" class="form-horizontal" role="form" method="post" enctype="multipart/form-data">
      <div class="form-group">
       <label for="inputFirstName1" class="col-lg-2 control-label">Name</label>
       <div class="col-lg-10">
         <input type="text" name="inputFirstName1" class="form-control" id="inputFirstName1" placeholder="First">
       </div>
      </div>
      <div class="form-group">
       <label for="inputLastName1" class="col-lg-2 control-label"></label>
       <div class="col-lg-10">
         <input type="email" name="inputLastName1" class="form-control" id="inputLastName1" placeholder="Last">
       </div>
      </div>
      <div class="form-group">
       <label for="inputUserName1" class="col-lg-2 control-label">User ID</label>
       <div class="col-lg-10">
         <input type="text" name="inputUserName1" class="form-control" id="inputUserName1" placeholder="Username">
       </div>
      </div>
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
    
      <div class="modal-body">
       <div class="form-group">
          <label for="inputFile">Upload Photo</label>
          <input name="inputFile" type="file" id="inputFile">
          <p class="help-block">Please upload your picture from your device.</p>
        </div>
     </div>
      
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
            <input type="text" name="inputUser1" class="form-control" id="inputUser1" placeholder="Username">
          </div>
         </div>
         <div class="form-group">
          <label for="inputPassword1" class="col-lg-2 control-label">Password</label>
          <div class="col-lg-10">
            <input type="password" name="inputPassword1" class="form-control" id="inputPassword1" placeholder="Password">
          </div>
         </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
          <div class="form-group">
             <label for="inputFile">Upload Photo</label>
             <input type="file" id="inputFile">
             <p class="help-block">Please upload your picture from your device.</p>
           </div>
        </div>
        
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary">Upload</button>
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
       <label for="inputDisplay1" class="col-lg-2 control-label">Username</label>
       <div class="col-lg-10">
         <input type="text" name="inputDisplay1" class="form-control" id="inputDisplay1" placeholder="Username">
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
          <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
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
    <script src="assets/js/usernameHover.js"></script>
    <script src="dist/js/bootstrap.min.js"></script>
  </body>
</html>
