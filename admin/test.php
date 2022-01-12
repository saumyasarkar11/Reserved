<!DOCTYPE html>
<html lang="en">
  <head>
    <title>Thank You</title>
    <style>
      #preloader {
        position: absolute;
        padding: 0;
        margin: 0;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: #f7f7f7 url("../assets/images/success.gif") no-repeat center;
        z-index: 999;
      }
      
    </style>
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/style.css"/>
  </head>

  <body>
    <div id="preloader"></div>   
    <header class="header-wrapper1">
      <div class="header-content1" align="left">
        <span class="org_name"><img class="header-logo1" src="../assets/images/logo1.jpg" alt="ashram-logo" />
        Sri Sri Balananda Ashrams</span>
        <span id="contact-details">
          For any booking related queries,<br>
          call: +91-983-011-0244
        </span>
      </div>      
    </header>
    <nav class="navbar1" align="left">
        <li id="nav-home"><a href="#">Home</a></li>
        <li><a href="#">Room Tariffs</a></li>
        <li><a href="#">Our Properties</a></li>
        <li><a href="#">Contact Us</a></li>
    </nav>
    <div class="hero"></div>   
    <div class="container-thanks">     
      <!-- <div align="center">
        <h2><img src="../assets/images/remove.png" height="50px" alt="failed">&nbsp;&nbsp;Session Timed Out</h2><br>
        <h5>Your session has timed out which is why we could not confirm your booking. In case the payment has been debited from your account, please contact the respective hotel.</h5><h6><a href="index.php">Return</a></h6>
      </div><br><br> -->
      <div align="center">
        <h2><img src="../assets/images/tick.png" alt="success">&nbsp;&nbsp;Payment Successful</h2>
      </div><br><br>      
      <div align="center">
        <form action="../receipt.php" method="POST" target="_blank">
          <input type="hidden" name="id">
          <button type="submit" name="receipt" class="btn btn-primary">Download Receipt</button>
        </form>
        <!-- <button class="btn btn-primary">Print</button> -->
      </div>
    </div>  
    <footer>
      Copyright&copy; 2021 Sri Sri Balananda Ashrams and Trusts. Designed and Hosted by <a href="https://techworth.in">Techworth</a>
    </footer>  
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../assets/bootstrap/bootstrap.min.js"></script>
<script>
  setTimeout(function () {
    $("#preloader").fadeOut("fast");
  }, 2550); // <-- time in milliseconds  
</script>

