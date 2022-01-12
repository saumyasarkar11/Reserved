<?php
session_start();

if(empty($_SESSION['prop_id'])){
    header("location: login.php");
}

if(!$_SESSION['rooms-arr']){
    session_unset();
    header("location: book.php");
    exit();
}

if(time() - $_SESSION['last_activity'] > 600){
    $_SESSION['status'] = "Session timed out";
    header("location: index.php");
    exit();
}

$_SESSION['last_activity'] = time();
include 'includes1/functions.php';

$sql1 = mysqli_query($con, "INSERT INTO `reservations` (`reservation_id`, `reservation_number`, `check_in`, `check_out`, `property_id`, `time`, `amount`, `paid`, `name`, `email`, `phone`, `aadhaar`, `address`, `city`, `state`, `pin`, `country`, `payment_id`, `status`, `note`) VALUES (NULL, '-', '".$_POST['check_in']."', '".$_POST['check_out']."', '".$_SESSION['prop']."', now(), '".$_POST['amount']."', '".$_POST['amount']."', '".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['aadhaar']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['pin']."', '".$_POST['country']."', '".$_POST['pay_id']."', 'Success', '')");

if(!checkDuplicacy($_POST['phone'])){
    mysqli_query($con, "INSERT INTO guests VALUES(NULL, '".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['aadhaar']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['pin']."', '".$_POST['country']."')");
}

$select_sql = mysqli_query($con, "SELECT reservation_id from reservations WHERE email = '".$_POST['email']."' AND phone = '".$_POST['phone']."' ORDER BY time desc LIMIT 1");
$row = mysqli_fetch_assoc($select_sql);

mysqli_query($con, "UPDATE reservations SET reservation_number='".$prefix.uniqid().$row['reservation_id']."' WHERE reservation_id='".$row['reservation_id']."'");

$pattern="/(?<=\[)(.*?)(?=\[)/";  
$arr = $_SESSION['rooms-arr'];  

foreach($arr as $value){
    $value="[".str_replace("?", "[", $value)."[";
    preg_match_all($pattern, $value, $result);
    $date = date("Y-m-d", strtotime($result[0][0]));
    $room = $result[0][1];
    $no = $result[0][2];
    if($no != 0){        
        $sql3 = mysqli_query($con, "INSERT INTO reserved_rooms VALUES (NULL, '".$row['reservation_id']."', '$room', '$no', '$date', 'Booked')");
    }        
}
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
        background: #f7f7f7 url("../assets/images/success.gif") no-repeat center;
        z-index: 999;
      }
      
    </style>
    <link rel="stylesheet" href="../assets/bootstrap/bootstrap.min.css"/>
    <link rel="stylesheet" href="../assets/css/style.css"/>
    <link rel="shortcut icon" href="../assets/images/logo1.jpg" />
  </head>

  <body>
    <div id="preloader"></div>
    <header class="header-wrapper1">
      <div class="header-content1" align="left">
        <span class="org_name"><img class="header-logo1" src="../assets/images/logo1.jpg" alt="logo" />
        <?php echo fetchConfig(1); ?></span>
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
    <?php echo mysqli_error($con); ?>
    <div class="container-thanks">
      <?php     
        if(time() - $_SESSION['last_activity'] > 600){            
      ?>
      <div align="center">
        <h2><img src="../assets/images/remove.png" height="50px" alt="failed">&nbsp;&nbsp;Session Timed Out</h2><br>
        <h5>Your session has timed out which is why we could not confirm your booking. In case the payment has been debited from your account, please contact the respective hotel.</h5><h6><a href="index.php">Return</a></h6>
      </div><br><br>      
       <?php } else { ?>   
      <div align="center">
        <h2><img src="../assets/images/tick.png" alt="success">&nbsp;&nbsp;Payment Successful</h2>
        <h5>Booking has been confirmed. A mail for the same has been sent to the email id of the guest. Please download the receipt for booking confirmation.</h5><h6><a href="book.php">Return</a></h6>
      </div><br><br>      
      <div align="center">
        <form action="../receipt.php" method="POST" target="_blank">
          <input type="hidden" name="id" value="<?php echo $row['reservation_id']; ?>">
          <button type="submit" name="receipt" class="btn btn-primary">Download Receipt</button>
        </form>
        <!-- <button class="btn btn-primary">Print</button> -->
      </div>
      <?php 
        }
       unset($_SESSION['rooms-arr']);  
       unset($_SESSION['last_activity']);  
       unset($_SESSION['chkin']);  
       unset($_SESSION['chkout']);  
       unset($_SESSION['prop']);  
       ?>
    </div>      
    <footer>
      Copyright&copy; 2021. <?php echo fetchConfig(2); ?>. Powered by <a href="https://techworth.in" target="_blank">Techworth</a>
    </footer>  
  </body>
</html>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="../assets/bootstrap/bootstrap.min.js"></script>
<script>
  setTimeout(function () {
    $("#preloader").fadeOut("fast");
  }, 2550); // <-- time in milliseconds  
    $.ajax({
      url: "sendmail.php",
      method: "POST",
      data: {id: <?php echo $row['reservation_id']; ?>, type: 1}
    })
</script>

