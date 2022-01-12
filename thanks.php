<?php
session_start();
if(empty($_SESSION['id'])){
  session_unset();
  header("Location: index.php");
  exit();
}
include 'includes/functions.php';
?>
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
        background: #f7f7f7 url("assets/images/success.gif") no-repeat center;
        z-index: 999;
      }
      
    </style>
    <link rel="stylesheet" href="assets/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css"/>
    <link rel="shortcut icon" href="assets/images/logo1.jpg" />
  </head>

  <body>
    <div id="preloader"></div>
    <header class="header-wrapper1">
      <div class="header-content1" align="left">
        <span class="org_name"><img class="header-logo1" src="assets/images/logo1.jpg" alt="ashram-logo" />
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
    <div class="container-thanks">
      <?php              
        require 'instamojo/Instamojo.php';
        $api = new Instamojo\Instamojo(payCred($_SESSION['prop'], 1), payCred($_SESSION['prop'], 2), 'https://test.instamojo.com/api/1.1/');
        $payid=$_GET['payment_request_id'];
        $status=$_GET['payment_status'];
        if ($status=="Credit"){
          if(time() - $_SESSION['last_activity'] > 600){
            mysqli_query($con, "UPDATE reservations SET status='Session timed out', payment_id='".$response['payments'][0]['payment_id']."' WHERE reservation_id='".$_SESSION['id']."'");
          ?>
      <div align="center">
        <h2><img src="assets/images/remove.png" height="50px" alt="failed">&nbsp;&nbsp;Session Timed Out</h2><br>
        <h5>Your session has timed out which is why we could not confirm your booking. In case the payment has been debited from your account, please contact the respective hotel.</h5><h6><a href="index.php">Return</a></h6>
      </div><br><br>      
          <?php
          } else {
            try {
                $response = $api->paymentRequestStatus($payid);
      ?>
      <div align="center">
        <h2><img src="assets/images/tick.png" alt="success">&nbsp;&nbsp;Payment Successful</h2>
      </div><br><br>
      <div class="table-responsive">
          <table class="table table-bordered">
              <tr>
                  <th>Payment Id:</th>
                  <td><?= $response['payments'][0]['payment_id']; ?></td>
              </tr>
              <tr>
                  <th>Payee Name:</th>
                  <td><?= $response['payments'][0]['buyer_name']; ?></td>
              </tr>
              <tr>
                  <td colspan="2">A confirmation email containing the receipt has been sent to your email id.</td>
              </tr>
          </table>
      </div>
      <div align="center">
        <form action="receipt.php" method="POST" target="_blank">
          <input type="hidden" name="id" value="<?php echo $_SESSION['id']; ?>">
          <button type="submit" name="receipt" class="btn btn-primary">Download Receipt</button>
        </form>
        <!-- <button class="btn btn-primary">Print</button> -->
      </div>
      <?php
              mysqli_query($con, "UPDATE reservations SET payment_id='".$response['payments'][0]['payment_id']."', status='Success' WHERE reservation_id='".$_SESSION['id']."'");
              mysqli_query($con, "UPDATE reserved_rooms SET status='Booked' WHERE reservation_id='".$_SESSION['id']."'");

            } catch (Exception $e) {
              print('Error: ' . $e->getMessage());
          }
         }
        } else {
      ?>
      <div class="container-thanks">      
      <div align="center">
        <h2><img src="assets/images/remove.png" height="50px" alt="failed">&nbsp;&nbsp;Payment Failed</h2><br>
        <h5>We could not confirm the booking because the payment could not be processed. We recommend you to try after sometime.</h5><h6><a href="index.php">Try Again</a></h6>    
      </div><br>
      <?php 
          mysqli_query($con, "UPDATE reservations SET status='Failed' WHERE reservation_id='".$_SESSION['id']."'");
          mysqli_query($con, "UPDATE reserved_rooms SET status='Failed' WHERE reservation_id='".$_SESSION['id']."'");
        } 
        $id = $_SESSION['id'];
        session_unset();
      ?>
    </div>

    <footer>
      Copyright&copy; 2021. <?php echo fetchConfig(2); ?>. Powered by <a href="https://techworth.in" target="_blank">Techworth</a>
    </footer> 
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="assets/bootstrap/bootstrap.min.js"></script>
<script>
<?php
  if($status == "Credit"){
  ?>
  setTimeout(function () {
    $("#preloader").fadeOut("fast");
  }, 2550); // <-- time in milliseconds
  $.ajax({
      url: "sendmail.php",
      method: "POST",
      data: {id: <?php echo $id; ?>, type: 1}
  })
  <?php
  } else {
  ?>
  $("#preloader").hide();
  <?php  
  }
  ?>
</script>

