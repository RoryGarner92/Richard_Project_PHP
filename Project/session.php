<!--
Name: Rory Garner
Class: Software Dev
Number: C00193506
-->
<?php
       include('config.php');
       session_start();
      //function to start session
       $user_check = $_SESSION['name'];

       $session_check = mysqli_query($db, "SELECT user_name From users WHERE user_name = '$user_check'");
       $session_pw = mysqli_query($db, "SELECT hashed_password From users WHERE user_name = '$user_check'");

       $row = mysqli_fetch_array($session_check,MYSQLI_ASSOC);
       $col = mysqli_fetch_array($session_pw,MYSQLI_ASSOC);

       $login_session = $row['user_name'];
       $login_pw = $col['hashed_password'];
       if(!isset($_SESSION['name'])){
         header("location:login.php");
       }
?>
