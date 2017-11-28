<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['name'];

   $session_check = mysqli_query($db, "SELECT name From users WHERE name = '$user_check'");

   $row = mysqli_fetch_array($session_check,MYSQLI_ASSOC);

   $login_session = $row['name'];

   if(!isset($_SESSION['name'])){
      header("location:login.php");
   }
?>
