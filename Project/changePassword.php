<?php
include("config.php");
include("session.php")

$message = '';
$password = '';
$new_password = '';
$user_name = $login_session;

  if (isset($_POST['submit'])) {

if (isset($_POST['password']) && isset($_POST['newPassword'])) {
    $password = isset($_POST['password'];
    $new_password = isset($_POST['password'];

    $salt = "Select hashed_password FROM users WHERE user_name = '$login_session'";
    $salt_value = mysqli_query($db, $salt);
    $row = mysqli_fetch_all($salt_value,MYSQLI_ASSOC);

    $returned = $row[0]['hashed_password'];

    $array = explode('$', $returned);

    $iterations ='1000';
    $hash = hash_pbkdf2("sha256", $password, $array[1], $iterations, 32);
    $saltyHash = '$'.$array[1].'$'.$hash;

    if ($login_pw != $saltyHash){
      echo "No matchy";
}elseif((!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $new_password))){
  echo "Complexity ERROR!";
}else{
  $salt = openssl_random_pseudo_bytes(32);
  $hash = hash_pbkdf2("sha256", $new_password, $salt, $iterations, 32);
  $saltyHash = '$'.$salt.'$'.$hash;

  $query ="UPDATE users SET hashed_password = $saltyHash WHERE user_name = '$login_session'";
  $result = mysqli_query($db, $query);
  header("location: logout.php");
  }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Change Password</title>
    	<link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
<div class = "container">
  <h1>Change Password</h1>
  <form class="form-group" method="post" action="" autocomplete="off">
    <label>Password</label>
    <input  type="password" name="password" placeholder="PASSWORD">
    <label>New Password</label>
    <input  type="password" name="newPassword" placeholder="NEW PASSWORD">
    <input  type="submit" name="submit" value="Submit">
  </form>
</div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
