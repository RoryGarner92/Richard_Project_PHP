<!--
Name: Rory Garner
Class: Software Dev
Number: C00193506
-->
<?php
      include("config.php");
      include("session.php");

      $message = '';

      if(isset($_POST['submit'])) {

      if(isset($_POST['password1']) && isset($_POST['password2'])){

          $password2 = $_POST['password2'];
          $password1 = $_POST['password1'];
          $user_name = $login_session;

          $salt = "SELECT hashed_password FROM users WHERE user_name = '$user_name'";
          $salt_returned = mysqli_query($db,$salt);
          $row = mysqli_fetch_all($salt_returned,MYSQLI_ASSOC);

          $returned =  $row[0]['hashed_password'];
          $array =  explode( '$', $returned );
            //$returned =  $row[0]['Salt'];
          $iterations = 1000;
          $hash = hash_pbkdf2("sha256", $password1, $array[1], $iterations, 32);
          $salty_hash = '$' . $array[1] . '$' . $hash;

          if($login_pw != $salty_hash){
            $message = 'No Match !';
          }elseif((!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password2))){
            $message = "Complexity ERROR!";
          }else{
            $salt = openssl_random_pseudo_bytes(32);
            $hash = hash_pbkdf2("sha256", $password2, $salt, $iterations, 32);
            $salt_hash = '$'.$salt.'$'.$hash;

            $query ="UPDATE users SET hashed_password = '$salt_hash' WHERE user_name = '$login_session'";
            $result = mysqli_query($db, $query);
            header("location: logout.php");
          }
        }
      }
?>


<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    	<link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
</head>
<body>
  <nav class="navbar navbar-inverse">
   <div class="container-fluid">
     <div class="navbar-header">
       <a class="navbar-brand" href="#">GarnerTec : User : <?php echo "$login_session";?></a>
     </div>
     <ul class="nav navbar-nav">
       <li class="active"><a href="home.php">Home</a></li>
       <li><a href="about.php">About</a></li>
       <li><a href="#">Page 2</a></li>
     </ul>
     <ul class="nav navbar-nav navbar-right">
       <li><a href="change_password.php"><span class="glyphicon glyphicon-user"></span>Change Password</a></li>
       <li><a href="logout.php"><span class="glyphicon glyphicon-log-in"></span>Logout</a></li>
     </ul>
   </div>
 </nav>
<div class="container">
  <h1>Change Password</h1>
  <form class="form-group" method="post" action="" autocomplete="off">
    <label>Password</label>
    <input  type="password" name="password1" placeholder="PASSWORD">
    <label>New Password</label>
    <input  type="password" name="password2" placeholder="NEW PASSWORD">
    <label>Confirm Password</label>
    <input  type="password" name="confirm" placeholder="CONFIRM PASSWORD">
    <input  type="submit" name="submit" value="Submit">
  </form>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  </body>
</html>
