<?php
include("config.php");
session_start();

$message = '';

if (isset($_POST['name']) && isset($_POST['password'])) {
  $ip = $_SERVER['REMOTE_ADDR'];
  $userAgent = $_SERVER['HTTP_USER_AGENT'];

  $hashOfUser = $ip . $userAgent;
  $iterations = 1000;

  $salt = "salty";
  $hash = hash_pbkdf2("sha256", $hashOfUser, $salt, $iterations, 32);

  $result = mysqli_query($db,"SELECT COUNT(hashed_user_agent_Ip) AS Count FROM ip WHERE hashed_user_agent_Ip = '$hash' AND `time_stamp` > (now() - interval 5 minute) AND active = True");
  $row = mysqli_fetch_all($result,MYSQLI_ASSOC);

  if($row[0]['Count'] >= 3)
      {
          echo "Your are allowed 3 attempts in 5 minutes";
      }
  else
      {
          mysqli_query($db, "INSERT INTO `ip` (`hashed_user_agent_Ip` ,`time_stamp`) VALUES ('$hash',CURRENT_TIMESTAMP)");
          $myusername = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
          $mypassword = mysqli_real_escape_string($db,$_POST['password']);

          $nameResult = mysqli_query($db,"SELECT id FROM users WHERE user_name = '$myusername'");
          $nameCount = mysqli_num_rows($nameResult);

  if($row[0]['Count']>2){
    echo "Your are only allowed 3 attempts! Try back later..";
  }else{
    mysqli_query($db, "INSERT INTO `ip` (`hashed_user_agent_Ip` ,`times_stamp`) VALUES ('$hash',CURRENT_TIMESTAMP)");
    $myusername = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
    $mypassword = mysqli_real_escape_string($db,$_POST['password']);

    $nameResult = mysqli_query($db,"SELECT id FROM users WHERE user_name = '$myusername'");
    $nameCount = mysqli_num_rows($nameResult);

if($nameCount == 1)
{
    // Generate a random IV using openssl_random_pseudo_bytes()
    // random_bytes() or another suitable source of randomness
    $salt = "SELECT hashed_password FROM users WHERE user_name = '$myusername'";
    $saltReturn = mysqli_query($db,$salt);
    $row = mysqli_fetch_all($saltReturn,MYSQLI_ASSOC);

    $returned =  $row[0]['hashed_password'];

    $array =  explode( '$', $returned );

    $iterations = 1000;
    $hash = hash_pbkdf2("sha256", $mypassword, $array[1], $iterations, 32);
    $saltyHash = '$' . $array[1] . '$' . $hash;

    $sql = "SELECT id FROM users WHERE user_name = '$myusername' and hashed_password = '$saltyHash'";
    $result = mysqli_query($db,$sql);
    $count = mysqli_num_rows($result);
    echo $count;

    // If result matched $myusername and $mypassword, table row must be 1 row
    $query = "UPDATE ip SET active = False ";
    $result = mysqli_query($db,$query);

    if($count == 1) {
          $_SESSION['user_name'] = $myusername;

          header("location:home.php");
        }
}
else
{
$error = "Your Username($myusername) or Password is invalid";
echo "not correct";
}
}
}


mysqli_close($db);
}
#}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login form</title>
    <link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
<div class="container">
<h1>Login Form</h1>
<form method="post" action="" autocomplete="off">
    User name <input type="text" name="name"><br>
    Password <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}" type="password" name="password"><br>
    <input type="submit" value="Login">
</form>
<div><?php echo "<p>$message </p>";?></div>
</div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
