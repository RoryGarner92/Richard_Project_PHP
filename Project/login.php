<?php
include("config.php");
session_start();

$message = '';

if (isset($_POST['name']) && isset($_POST['password'])) {

$ip = $_SERVER["REMOTE_ADDR"];
mysqli_query($db, "INSERT INTO `ip` (`address` ,`timestamp`)VALUES ('$ip',CURRENT_TIMESTAMP)");
$result = mysqli_query($db, "SELECT COUNT(*) FROM `ip` WHERE `address` LIKE '$ip' AND `timestamp` > (now() - interval 2 minute)");
$count = mysqli_fetch_array($result, MYSQLI_NUM);
echo $count[0];
if($count[0] > 2){
  echo "Your are allowed 3 attempts in 10 minutes";
}
else{
$sql = sprintf("SELECT * FROM users WHERE name='%s'",mysqli_real_escape_string($db, $_POST['name']));
$result = mysqli_query($db, $sql);

$row = mysqli_fetch_assoc($result);
if ($row) {
    $saltyHash = $row['password'];
    $name = $row['name'];
    if (password_verify($_POST['password'], $saltyHash)) {
        header("location:home.php");
        $_SESSION['name'] = $row['name'];
    } else {
        $message = 'Login failed.';
    }
} else {
    $message = 'Login failed.';
}
}
mysqli_close($db);
}
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
