<?php

if(!isset($_POST['id'])){
    header("location: index.php");
}

require 'includes/db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

$con=mysqli_connect($db_host, $db_username, $db_password, $db_name)
or die(mysqli_error($con));

function fetchData($id, $i){
    global $con;
    if($i == 1){
        $sql = mysqli_query($con, "SELECT location_name FROM locations WHERE location_id='$id'"); 
        $row = mysqli_fetch_assoc($sql);
        return $row['location_name'];   
    } else {
        $sql = mysqli_query($con, "SELECT property_name FROM properties WHERE property_id='$id'"); 
        $row = mysqli_fetch_assoc($sql);
        return $row['property_name'];  
    }
}

function fetchTerms(){
    global $con;
    $sql = mysqli_query($con, "SELECT terms FROM configurations where config_id='1'");
    $row = mysqli_fetch_assoc($sql);
    return $row['terms'];
}

function fetchRoomInfo($id, $i){
    global $con;
    $sql = mysqli_query($con, "SELECT room_type, tariff FROM rooms WHERE room_id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    if($i == 1){
        return $row['room_type']." @ Rs. ".$row['tariff'];
    } else {
        return $row['tariff'];
    }
}

$id = $_POST['id'];

ob_end_clean();
require('fpdf/fpdf.php');
$sql = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id = '".$id."'");
$row = mysqli_fetch_assoc($sql);
echo $row['property_id'];
$prop[0] = fetchData($row['property_id'], 2);
$sql1 = mysqli_query($con, "SELECT location_id, property_address, phone, email, check_in_time, check_out_time FROM properties WHERE property_id = '".$row['property_id']."'");
$row1 = mysqli_fetch_assoc($sql1);
$prop[1] = fetchData($row1['location_id'], 1);
 $sql2 = mysqli_query($con, "SELECT * FROM reserved_rooms WHERE reservation_id = '$id'");

class PDF extends FPDF
{
    function Header(){
        global $row1;
        $this->Image('assets/images/logo.jpg',10,6,35);            
        $this->SetFont('Arial','',9);               
        $this->SetX($this->lMargin);
        $this->Cell(0,10,$row1['property_address'],0,0,'R');      
        $this->Ln(5);
        $this->SetX($this->lMargin);
        $this->Cell(0,10,"Phone: ".$row1['phone'],0,0,'R');  
        $this->Ln(5);
        $this->SetX($this->lMargin);
        $this->Cell(0,10,"Email: ".$row1['email'],0,0,'R'); 
        $this->Ln(15);
    }

    function Footer(){
        $this->SetY(-15);
        $this->SetFont('Arial','I',8);
        $this->Cell(0,10,'Powered by Techworth Technologies Pvt. Ltd. (www.techworth.in)',0,0,'C');
    }

    function Table(){
        global $row;
        global $row1;
        global $sql2;
        global $con;
        global $_POST;
        global $prop;
        $this->SetFont('Arial','B',10); 
        $this->SetFillColor(235,235,235);
        $this->Cell(105,10,'Booking Details',1,0,'L',1);
        $this->Cell(80,10,'Guest Details',1,0,'L',1);
        $this->Ln(10);
        $this->SetFont('Arial','',8); 
        $this->Cell(105,10,'Reservation No: ' . $row['reservation_number'],1,0,'L');
        $this->Cell(80,10,'Guest Name: ' . $row['name'],1,0,'L');
        $this->Ln(10);
        $this->Cell(105,10,'Transaction Id: ' . $row['payment_id'],1,0,'L');
        $this->Cell(80,10,'Email: ' . $row['email'],1,0,'L');
        $this->Ln(10);
        $this->Cell(105,10,'Property: ' . $prop[0].", ".$prop[1],1,0,'L');
        $this->Cell(80,10,'Phone: ' . $row['phone'],1,0,'L');
        $this->Ln(10);
        $this->Cell(105,10,'Booking Date & Time: ' . $row['time'],1,0,'L');
        $text1 = 'Address: ' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ' - ' . $row['pin'];
        $this->Cell(80,10,'Photo ID No.: ' . $row['aadhaar'],1,0,'L');                       
        $this->Ln(10);
        $this->Cell(52.5,10,'Check-in Date: ' . date("d-m-Y", strtotime($row['check_in']))." (".$row1['check_in_time'].")",1,0,'L');
        $this->Cell(52.5,10,'Check-out Date: ' . date("d-m-Y", strtotime($row['check_out']))." (".$row1['check_out_time'].")",1,0,'L');
        $this->MultiCell(80, 5 ,$text1, 1, 1); 
        $this->Ln(10);

        $this->SetFont('Arial','B',10); 
        $this->Cell(185,10,'Room Details',1,1,'C',1);
        $this->Ln(0);
        $this->SetFont('Arial','B',8);
        $this->Cell(30,10,'From',1,0,'L');
        $this->Cell(30,10,'To',1,0,'L');
        $this->Cell(55,10,'Room Type / Rate Per Day',1,0,'L');
        $this->Cell(10,10,'No.',1,0,'L');
        $this->Cell(30,10,'Status',1,0,'L');
        $this->Cell(30,10,'Amount (Rs.)',1,0,'L');
        $this->Ln(10);
        $this->SetFont('Arial','',8); 
            while($row2 = mysqli_fetch_assoc($sql2)){
                $this->Cell(30,10,date("d-m-Y", strtotime($row2['date'])),1,0,'L');
                $this->Cell(30,10,date("d-m-Y", strtotime($row2['date'] . "+1 day")),1,0,'L');
                $this->Cell(55,10, fetchRoomInfo($row2['room_id'], 1),1,0,'L');
                $this->Cell(10,10,$row2['qty'],1,0,'L');
                $this->Cell(30,10,$row2['status'],1,0,'L');                
                $this->Cell(30,10,$row2['qty'] * fetchRoomInfo($row2['room_id'], 2),1,0,'L');
                $this->Ln(10);
            }
        $this->SetFont('Arial','B',8);
        $this->Cell(30,10,'',0,0,'L');
        $this->Cell(30,10,'',0,0,'L');
        $this->Cell(55,10,'',0,0,'L');
        $this->Cell(10,10,'',0,0,'L');
        $this->Cell(30,10,'Grand Total:',1,0,'L');
        $this->SetFont('Arial','',8); 
        $this->Cell(30,10,'Rs. ' . $row['amount'],1,0,'L');
        $this->Ln(10);
        $this->SetFont('Arial','B',8);
        $this->Cell(30,10,'',0,0,'L');
        $this->Cell(30,10,'',0,0,'L');
        $this->Cell(55,10,'',0,0,'L');
        $this->Cell(10,10,'',0,0,'L');
        $this->Cell(30,10,'Advance Paid:',1,0,'L');
        $this->Cell(30,10,'Rs. ' . $row['paid'],1,1,'L');
        $this->Ln(10);
    }

    function Terms(){
        $this->SetFont('Arial','B',10);
        $this->Cell(185,10,'Terms & Conditions',0,0,'L',1);
        $this->Ln(15);
        $this->SetFont('Arial','',8); 
        $this->MultiCell(178,5,fetchTerms());              
    }


}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Table();
$pdf->Terms();

$filename = $row['reservation_number'].".pdf";

$pdf->Output($filename, 'F'); // save the pdf under filename

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

//Server settings
$mail->SMTPDebug = 0;                      // Enable verbose debug output
$mail->isSMTP();                                            // Send using SMTP
$mail->Host       = $host;                    // Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
$mail->Username   = $username;                     // SMTP username
$mail->Password   = $password;                               // SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
$mail->Port       = "465"; 

$mail->From = $from2;
$mail->FromName = $from1;
$mail->AddAddress( $row['email'], $row['name'] );  //  in this case the variable has been passed
$mail->SMTPDebug = 0;  // use 2 for debugging the email send

$pdf_content = file_get_contents($filename);

$mail->WordWrap = 50;
$mail->AddStringAttachment($pdf_content, "Receipt_".$row['reservation_number'].".pdf", "base64", "application/pdf");  // note second item is name of emailed pdf
$mail->IsHTML(true);

if($_POST['type'] == 1){
    $mail->Subject = "Room Booking Confirmation";
    $mail->Body = "Dear ".$row['name'].",<br><br>
                   Your room booking has been confirmed. Please find the pdf attached to get the receipt for the same.<br><br>
                   Thank you<br>".$prop[0].", ".$prop[1]."<br>Email: ".$row1['email']."<br>Phone: ".$row1['phone'];
} else if($_POST['type'] == 1){
    $mail->Subject = "Booking Date Modification";
    $mail->Body = "Dear ".$row['name'].",<br><br>
                   Your room booking schedule has been modified as per your request. Please
                   find the PDF attached to get the revised booking receipt. Additional
                   amount paid for the cancelled period will be adjusted with the final
                   bill amount at the hotel during the checkout.<br><br>
                   Thank you<br>".$prop[0].", ".$prop[1]."<br>Email: ".$row1['email']."<br>Phone: ".$row1['phone'];
} else {
    $mail->Subject = "Booking Cancellation";
    $mail->Body = "Dear ".$row['name'].",<br><br>
                   Your room booking schedule has been cancelled as per your request.
                   Please find the PDF attached to get the cancelled booking receipt. The
                   booking amount will be refunded and will be credited to your account
                   within 15 days as per our refund policy.<br><br>
                   Thank you<br>".$prop[0].", ".$prop[1]."<br>Email: ".$row1['email']."<br>Phone: ".$row1['phone'];
}

$mail->Send();
unlink($filename);

?>