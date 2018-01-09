<!--
Name: Rory Garner
Class: Software Dev
Number: C00193506
-->
<?php
      include("session.php");
      //connecting to session
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Home</title>
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
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
 <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</body>
</html>
