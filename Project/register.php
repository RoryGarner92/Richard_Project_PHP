<!--
Name: Rory Garner
Class: Software Dev
Number: C00193506
-->
<?php
      include("config.php");

      $name = '';
      $password = '';
      $message = '';

      if(isset($_POST['submit'])){

        if(isset($_POST['name']) && isset($_POST['password'])){
          $name = $_POST['name'];
          $password = $_POST['password'];

          $existing_user_name = mysqli_query($db, "SELECT user_name From users WHERE user_name = '$name'");

        if(mysqli_num_rows($existing_user_name) != 0){
          $message = "We had a problem creating an account ";
        }elseif(!preg_match("#.*^(?=.{8,})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$#", $password)){
          $message = "Shit password mate! Try again ? ";
        }else{
          $iterations ='1000';
          $salt = openssl_random_pseudo_bytes(32);
          $hash = hash_pbkdf2("sha256", $password, $salt, $iterations, 32);
          $salty_hash = '$'.$salt.'$'.$hash;
                 // add database code here
          $sql = sprintf("INSERT INTO users (user_name, hashed_password ) VALUES (
            '%s', '%s')", mysqli_real_escape_string($db, $name),
            mysqli_real_escape_string($db, $salty_hash));
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
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid bg">
    <div class="row">
      <div class="col-mid-4 col-sm-4 col-xs-12"></div>
      <div class="col-mid-4 col-sm-4 col-xs-12">
        <form class="form-container" method="post" action="" autocomplete="off">
          <h1>Register</h1>
          <div class="form-group">
            <label>User Name</label>
            <input type="text" name="name" class="form-control"  id="name"  autofocus= "true"  aria-describedby="name" placeholder="Enter Name" required value="<?php echo htmlspecialchars($name);?>">
          </div>
          <div class="form-group"><label>Password</label>
            <input type="password" name="password" class="form-control"  id="password"  pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*''""?&])[A-Za-z\d$@$!%*?&]{8,}" aria-describedby="password"   placeholder="PASSWORD" required>
            <small id="passwordHelpBlock" class="form-text text-muted">
              Your password must be a min of 8 characters long, contain uppercase / lowercase letters and numbers!
            </small>
            <br>
            <input  type="submit" class="btn btn-success btn-block" name="submit" value="Submit">
            <input type= "button" class="btn btn-success btn-block"  value= "Login" onclick="window.location.href='login.php'"/>
            <br>
          </form>
          <?php echo "$message";?>
        </div>
        <div class="col-mid-4 col-sm-4 col-xs-12">
      </div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
 </body>
</html>
