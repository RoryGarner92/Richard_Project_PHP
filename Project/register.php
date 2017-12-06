<?php
include("config.php");

  $name = '';
  $password = '';
  $message = '';

  if (isset($_POST['submit'])) {

    if (isset($_POST['name']) && isset($_POST['password'])) {
        $name = $_POST['name'];
        $password = $_POST['password'];

        $existing_user_name = mysqli_query($db, "SELECT user_name From users WHERE user_name = '$name'");

        if(mysqli_num_rows($existing_user_name) != 0){
          $message = "We had a problem creating an account ";

        }elseif(!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)){
          $message = "Shit password mate ";
        }else{

          $iterations ='1000';
          $salt = openssl_random_pseudo_bytes(32);
          $hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 32);
          $saltyHash = '$'.$salt.'$'.$hash;

           // add database code here
          $sql = sprintf("INSERT INTO users (user_name, hashed_password ) VALUES (
            '%s', '%s'
          )", mysqli_real_escape_string($db, $name),
              mysqli_real_escape_string($db, $saltyHash));
          mysqli_query($db, $sql);
          mysqli_close($db);
          header("location:login.php");
        }


    }
  }

?>

<!DOCTYPE html>
<html>
<head>
    <title>PHP Project</title>
    	<link rel="stylesheet" type="text/css" href="stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>

<div class = "container">
  <h1>Create User Form</h1>
  <form class="form-group" method="post" action="" autocomplete="off">
    <label>User Name</label>
     <input required  autofocus= "true" type="text" name="name" placeholder="USER NAME" value="<?php echo htmlspecialchars($name);?>">
    <label>Password</label>
    <input required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*''""?&])[A-Za-z\d$@$!%*?&]{8,}" type="password" name="password" placeholder="PASSWORD">
    <input  type="submit" name="submit" value="Submit">
  </form>
<div>
  <?php echo "$message"; ?>
</div>
</div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
