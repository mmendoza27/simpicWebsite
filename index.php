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
               echo "<a data-toggle='modal' class='navbar-brand' href='#editProfile'>$_SESSION[userID]</a>";
            } else {
               echo "<a class='navbar-brand' href='#'>Simpic</a>";
            }
         ?> 
          
        </div>
        <div class="navbar-collapse collapse">
          <ul class="nav navbar-nav">
            <li><a href="#people">People</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Images <b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="#popular">Popular</a></li>
                <li><a href="#current">Current</a></li>
                <li><a href="#topComments">Top Commented</a></li>
              </ul>
            </li>
            <li><a data-toggle="collapse" data-target="#search" href="#">Search</a></li>
            
            <?php
                  if (isset($_SESSION['userID']) && isset($_COOKIE['LoginCredentials'])) {
                     echo "<li><a href='#profile'>Profile</a></li><li><a href='logout.php'>Logout</a></li>";
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
        <span class="input-group-addon">#</span>
        <input type="text" class="form-control" placeholder="Tag">

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
    
    
    <div class="container">

    <?php
       $con = mysqli_connect("localhost", "krobbins", "abc123", "simpic");
       
       if (mysqli_connect_errno()) {
         echo "Couldn't connect to database simpic: " . mysqli_connect_errno();
       }

       $query = "SELECT * FROM users ORDER BY `registration_date` DESC LIMIT 9";

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
    
    <!-- Static bottom navbar -->
    <div class="navbar navbar-default navbar-fixed-bottom">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".bottom-collapse"></button> <!-- NOTE! data-target was changed to .bottom-collapse -->
        </div>
        <div class="navbar-collapse collapse bottom-collapse"> <!-- NOTE! The extra bottom-collapse class put on here -->
          <ul class="nav navbar-nav">
            <li><a href="#">Contact Us</a></li>
            <li><a href="#about">FAQ</a></li>
            <li><a href="#contact">About Us</a></li>
            <li><a href="#contact">Copyright</a></li>
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
