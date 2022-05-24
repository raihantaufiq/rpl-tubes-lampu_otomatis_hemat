<?php

  session_start();

  if (isset($_SESSION['username'])) {
      header("location: dashboard.html");
  }
  include("config.php");
  include("includes/DB.class.php");
  include("templates/login.html");
  
?>