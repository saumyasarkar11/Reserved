<?php
require 'functions.php';
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Hotel Reservation</title>    
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="shortcut icon" href="../assets/images/logo1.jpg" />
  </head>
  <body>
    <!-- <div class="pre-header">
      a
    </div> -->
    <header class="header-wrapper1">
      <div class="header-content1" align="left">
        <span><img class="header-logo1" src="../assets/images/logo1.jpg" alt="ashram-logo" />
        <span class="org_name"><?php echo fetchConfig(1); ?></span></span>
        <span id="contact-details">
          For any booking related queries,<br>
          call: +91-983-011-0244
        </span>
      </div>      
    </header>
    <nav class="navbar1" align="left">
        <li id="nav-home"><a href="#">Home</a></li>
        <li><a href="#">Contact Us</a></li>
    </nav>
    <div class="hero"></div>
