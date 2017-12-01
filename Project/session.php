<?php
   include('config.php');
   session_start();

   $user_check = $_SESSION['name'];

   $session_check = mysqli_query($db, "SELECT name From users WHERE name = '$user_check'");
   $session_pw = mysqli_query($db, "SELECT password From users WHERE name = '$user_check'");

   $row = mysqli_fetch_array($session_check,MYSQLI_ASSOC);
   $col = mysqli_fetch_array($session_pw,MYSQLI_ASSOC);

   $login_session = $row['name'];
   $login_pw = $col['password'];
   if(!isset($_SESSION['name'])){
      header("location:login.php");
   }
?>
