<?php
session_start();

if(!$_SESSION['rooms-arr']){
    session_unset();
    header("location: index.php");
    exit();
}

if(time() - $_SESSION['last_activity'] > 600){
    $_SESSION['status'] = "Session timed out";
    header("location: index.php");
    exit();
}

$_SESSION['last_activity'] = time();

require 'instamojo/Instamojo.php';
include 'includes/functions.php';

$sql1 = mysqli_query($con, "INSERT INTO `reservations` (`reservation_id`, `reservation_number`, `check_in`, `check_out`, `property_id`, `time`, `amount`, `paid`, `name`, `email`, `phone`, `aadhaar`, `address`, `city`, `state`, `pin`, `country`, `payment_id`, `status`, `note`) VALUES (NULL, '-', '".$_POST['check_in']."', '".$_POST['check_out']."', '".$_SESSION['prop']."', now(), '".$_POST['amount']."', '".$_POST['amount']."', '".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['aadhaar']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['pin']."', '".$_POST['country']."', '-', 'Payment Pending', '')");

if(!checkDuplicacy($_POST['phone'])){
    mysqli_query($con, "INSERT INTO guests VALUES(NULL, '".$_POST['name']."', '".$_POST['email']."', '".$_POST['phone']."', '".$_POST['aadhaar']."', '".$_POST['address']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['pin']."', '".$_POST['country']."')");
}

$select_sql = mysqli_query($con, "SELECT reservation_id from reservations WHERE email = '".$_POST['email']."' AND phone = '".$_POST['phone']."' ORDER BY time desc LIMIT 1");
$row = mysqli_fetch_assoc($select_sql);
$_SESSION['id'] = $row['reservation_id'];

mysqli_query($con, "UPDATE reservations SET reservation_number='".$prefix.uniqid().$_SESSION['id']."' WHERE reservation_id='".$_SESSION['id']."'");


$pattern="/(?<=\[)(.*?)(?=\[)/";  
$arr = $_SESSION['rooms-arr'];  

foreach($arr as $value){
    $value="[".str_replace("?", "[", $value)."[";
    preg_match_all($pattern, $value, $result);
    $date = date("Y-m-d", strtotime($result[0][0]));
    $room = $result[0][1];
    $no = $result[0][2];
    if($no != 0){        
        $sql3 = mysqli_query($con, "INSERT INTO reserved_rooms VALUES (NULL, '".$row['reservation_id']."', '$room', '$no', '$date', 'Pending')");
    }        
}

if($sql1){
    $api = new Instamojo\Instamojo(payCred($_SESSION['prop'], 1), payCred($_SESSION['prop'], 2), 'https://test.instamojo.com/api/1.1/');
    try {
        $response = $api->paymentRequestCreate(array(
            "purpose" => "Advance Booking Payment",
            "amount" => $_POST['paid'],
            "send_email" => false,
            "allow_repeated_payments" => false,
            "redirect_url" => $instamojo_redirect_url
            ));
        // print_r($response);
        $pay_url = $response['longurl'];
        header("location: $pay_url");
    }
    catch (Exception $e) {
        print('Error: ' . $e->getMessage());
    }
} else {
    $_SESSION['error'] = mysqli_error($con);
    // header("location: index.php");
    echo mysqli_error($con);
}

?>

