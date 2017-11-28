<?php
include("config.php");

  $name = '';
  $password = '';

  if (isset($_POST['submit'])) {
    $ok = true;

    if (!isset($_POST['name']) || $_POST['name'] === '' ) {
        $ok = false;
    } else {
        $name = $_POST['name'];
    }
    if (!isset($_POST['password']) || $_POST['password'] === '') {
        $ok = false;
    }
    else {
        $password = $_POST['password'];
    }

    $password = $_POST['password'];
    if (preg_match("#.*^(?=.{8,20})(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9])(?=.*\W).*$#", $password)){
        echo "Your password is strong.";


    $q1 = mysqli_query($db, "SELECT name From users WHERE name = '$name'");
if(mysqli_num_rows($q1) != 0){
  echo("we have a problem");
  $ok = false;
} else{

    if ($ok) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        // add database code here
        $sql = sprintf("INSERT INTO users (name, password) VALUES (
          '%s', '%s'
        )", mysqli_real_escape_string($db, $name),
            mysqli_real_escape_string($db, $hash));
        mysqli_query($db, $sql);
        mysqli_close($db);
        echo '<p>User added.</p>';
    }
    }
  }
} else {
    echo "Your password is not safe.";
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
     <input autofocus= "true" type="text" name="name" placeholder="USER NAME" value="<?php echo htmlspecialchars($name);?>">

    <label>Password</label>
    <input  type="password" name="password" placeholder="PASSWORD">

    <input  type="submit" name="submit" value="Submit">
  </form>
</div>

  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
  </body>
</html>
