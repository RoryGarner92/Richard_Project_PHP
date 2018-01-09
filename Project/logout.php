<!--
Name: Rory Garner
Class: Software Dev
Number: C00193506
-->
<?php
      session_start();

      if(session_destroy()){
        header("location:home.php");
      }
      //destroys the session and redirests to login
 ?>
