<!--
Name: Rory Garner
Class: Software Dev
Number: C00193506
-->
<?php
      include("config.php");
      session_start();
      // function to start session
      $message = '';
      $count = 0;

      if($_SERVER["REQUEST_METHOD"] == "POST"){
        $ip = $_SERVER['REMOTE_ADDR'];
        $user_agent = $_SERVER['HTTP_USER_AGENT'];
        //collecting info of user logging in
        $hash_of_user = $ip . $user_agent;
        $iterations = 1000;
        $salt = "salty";
        //simple salt (this info not overly sensative)
        $hash = hash_pbkdf2("sha256", $hash_of_user, $salt, $iterations, 32);
        //hashing the info collect before storing it in the db
        $result = mysqli_query($db,"SELECT COUNT(hashed_user_agent_Ip) AS Count FROM ip WHERE hashed_user_agent_Ip = '$hash' AND `time_stamp` > (now() - interval 10 minute) AND active = True");
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        // checking the number of attempted logins
      if($row[0]['Count'] >= 3){
        $message = "You hare limited to 3 attempts ! You are now locked out for 10 minutes";
      }else{
        mysqli_query($db, "INSERT INTO `ip` (`hashed_user_agent_Ip` ,`time_stamp`) VALUES ('$hash',CURRENT_TIMESTAMP)");
        //inserts into the ip table
        $sanitized_user_name = filter_var($_POST['name'],FILTER_SANITIZE_STRING);
        $real_escape_password = mysqli_real_escape_string($db,$_POST['password']);
        // stops the use of "the bad chars"
        $salt = "SELECT hashed_password FROM users WHERE user_name = '$sanitized_user_name'";
        $salt_return = mysqli_query($db,$salt);
        $row = mysqli_fetch_all($salt_return,MYSQLI_ASSOC);
        $arr = (array)$row;
        //checking if it exists
      if(empty($arr)){
        $message = "Your name($sanitized_user_name) or Password is invalid";
      }else{
        $returned = $row[0]['hashed_password'];
        $array =  explode( '$', $returned );
        $iterations = 1000;
        //number of times to run through algo (proof of concept- must be a much larger number)
        $hash = hash_pbkdf2("sha256", $real_escape_password, $array[1], $iterations, 32);
        $salty_hash = '$' . $array[1] . '$' . $hash;
        //appending salt
        $name_result = mysqli_query($db,"SELECT id FROM users WHERE user_name = '$sanitized_user_name' AND hashed_password = '$salty_hash'");
        $name_count = mysqli_num_rows($name_result);
        // check db
      if($name_count == 1){
        $result = mysqli_query($db,"SELECT id FROM users WHERE user_name = '$sanitized_user_name' AND hashed_password = '$salty_hash'");
        $count = mysqli_num_rows($result);
        $query = "UPDATE ip SET active = False ";
        $result = mysqli_query($db,$query);
      }
      if($count == 1){
        $_SESSION['name'] = $sanitized_user_name;
        header("location:home.php");
      }else {

      }

    }
  }
  mysqli_close($db);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login form</title>
    <link rel="stylesheet" type="text/css" href="./css/stylesheet.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css" integrity="sha384-PsH8R72JQ3SOdhVi3uxftmaW6Vc51MKb0q5P2rRUpPvrszuE4W1povHYgTpBfshb" crossorigin="anonymous">
</head>
<body>

  <div class="container-fluid bg">
    <div class="row">
      <div class="col-mid-4 col-sm-4 col-xs-12"></div>
      <div class="col-mid-4 col-sm-4 col-xs-12">
        <form class="form-container" method="post" action="" autocomplete="off">
          <h1>Login</h1>
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter Name" required>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" name="password" class="form-control" id="password" placeholder="Password" required pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[0-9]){8,}">
            <small id="passwordHelpBlock" class="form-text text-muted">
              Your password must be a min of 8 characters long, contain uppercase / lowercase letters and numbers!
            </small>
            <br>
          </div>
          <button type="submit" class="btn btn-success btn-block" value="Login">Submit</button>
          <input type= "button" class="btn btn-success btn-block"  value= "Registration" onclick="window.location.href='register.php'"/>
          <br/>
          <?php echo "$message";?>
        </form>
      </div>
      <div class="col-mid-4 col-sm-4 col-xs-12"></div>
    </div>
  </div>
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
</body>
</html>
