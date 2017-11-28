
<?php
// Print an individual cookie
echo $_COOKIE["TestCookie"];

// Another way to debug/test is to view all cookies
print_r($_COOKIE);
?>


<?php
include("config.php");
session_start();


$message = '';

if (isset($_POST['name']) && isset($_POST['password'])) {
    $sql = sprintf("SELECT * FROM users WHERE name='%s'",
        mysqli_real_escape_string($db, $_POST['name'])
    );
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_assoc($result);
    if ($row) {
        $hash = $row['password'];
        $name = $row['name'];

        if (password_verify($_POST['password'], $hash)) {
            header("location:home.php");

            $_SESSION['name'] = $row['name'];
        } else {
            $message = 'Login failed.';
          //  echo $name;
        }
    } else {
        $message = 'Login failed.';
    //    echo $name;
    }
    mysqli_close($db);
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>PHP</title>
</head>
<body>

<?php

echo "<p>$message</p>";

?>
<form method="post" action="" autocomplete="off">
    User name <input type="text" name="name"><br>
    Password <input type="password" name="password"><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
