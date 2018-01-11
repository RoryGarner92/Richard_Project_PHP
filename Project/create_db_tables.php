<?php
$host ='localhost';
$user ='root';
$password ='';

$conn = new mysqli($host,$user,$password) or die('Cannot Connect');
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
if($_SERVER["REQUEST_METHOD"] == "POST"){
// Create database
$sql = "CREATE DATABASE logindb";

$createUserTable = "CREATE TABLE `users` ( 
    `id` int(11)NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `user_name` varchar(20) NOT NULL, 
    `hashed_password` varchar(500) CHARACTER SET utf8mb4 NOT NULL ) 
     ENGINE=InnoDB DEFAULT CHARSET=latin1";

$createIpTable = "CREATE TABLE IF NOT EXISTS `ip`( 
    `id` int(11) NOT NULL PRIMARY KEY AUTO_INCREMENT, 
    `hashed_user_agent_Ip` varchar(200) CHARACTER SET utf8 NOT NULL, 
    `time_stamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP, 
    `active` tinyint(1) NOT NULL DEFAULT '1' ) 
     ENGINE=InnoDB DEFAULT CHARSET=latin1";


if ($conn->query($sql) === TRUE) {
    $database = "logindb";
    $db = new mysqli($host,$user,$password,$database) or die('Cannot Connect');
    $ut = mysqli_query($db,$createUserTable);
    $ip = mysqli_query($db,$createIpTable);
    echo "Database and tables created successfully";
} else {
    echo "Error creating database: " . $conn->error;
}

}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="" method="post">
<button type="submit" class="btn btn-success btn-block" value="Create">Create</button>
<input type= "button" class="btn btn-success btn-block"  value= "Login" onclick="window.location.href='login.php'"/>

</form>
</body>
</html>