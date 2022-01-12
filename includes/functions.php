<?php
require 'db.php';

// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;

// require 'PHPMailer/src/Exception.php';
// require 'PHPMailer/src/PHPMailer.php';
// require 'PHPMailer/src/SMTP.php';

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

function payCred($id, $i){
    global $con;
    $sql = mysqli_query($con, "SELECT mojo_api, mojo_key FROM properties WHERE property_id='$id'"); 
    $row = mysqli_fetch_assoc($sql);
    if($i == 1){
        return $row['mojo_api'];
    } else {
        return $row['mojo_key'];
    }
}

function fetchLocations(){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM locations WHERE status='Open' ORDER BY location_name ASC");    
    $output = '<option value="" selected hidden>---Select---</option>';
    while($row = mysqli_fetch_assoc($sql)){
        $sql1 = mysqli_query($con, "SELECT * FROM properties WHERE location_id = '".$row['location_id']."' AND status='Open'");
        $num = mysqli_num_rows($sql1);
        if($num != 0){
            $output .= '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
        }
    }
    return $output;
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

function fetchConfig($idx){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM configurations WHERE config_id = '1'");
    $row = mysqli_fetch_assoc($sql);
    if($idx == 1){
        return $row['title'];
    } else {
        return $row['footer'];
    }
}

function fetchRoomsTable($arr){
    global $con;
    $output = '';
    $pattern="/(?<=\[)(.*?)(?=\[)/";    
    $i = 1;
    $total = 0;
    foreach($arr as $value){
        $value="[".str_replace("?", "[", $value)."[";
        preg_match_all($pattern, $value, $result);
        $date = date("d-m-Y", strtotime($result[0][0]));
        $room = $result[0][1];
        $no = $result[0][2];
        if($no != 0){
            $output .= '<tr><td>'.$i.'</td><td>'.$date.'</td><td>'.fetchRoomInfo($room, 1).'</td><td>'.$no.'</td><td>'.fetchRoomInfo($room, 2) * $no.'</td></tr>';
            $i++;
            $total += fetchRoomInfo($room, 2) * $no;
        }        
    }
    $output .= '<tr><td colspan="2"></td><td colspan="2"><b>Grand Total (Rs.) : </b></td><td>'.$total.'</td></tr>';
    return $output;
} 

function fetchAmount($arr){
    global $con;
    $sql = mysqli_query($con, "SELECT pay_percent from configurations WHERE config_id='1'");
    $row = mysqli_fetch_assoc($sql);
    $pattern="/(?<=\[)(.*?)(?=\[)/";    
    $total = 0;
    foreach($arr as $value){
        $value="[".str_replace("?", "[", $value)."[";
        preg_match_all($pattern, $value, $result);
        $date = date("d-m-Y", strtotime($result[0][0]));
        $room = $result[0][1];
        $no = $result[0][2];
        if($no != 0){
            $total += fetchRoomInfo($room, 2) * $no;
        }        
    }
    return $total*$row['pay_percent']/100;
} 

function checkDuplicacy($phone){
    global $con;
    $sql = mysqli_query($con, "SELECT guest_id FROM guests WHERE phone = '$phone'");
    $num = mysqli_num_rows($sql);
    if($num == 0){
        return 0;
    } else {
        return 1;
    }
}

function fetchTerms(){
    global $con;
    $sql = mysqli_query($con, "SELECT terms FROM configurations where config_id='1'");
    $row = mysqli_fetch_assoc($sql);
    return $row['terms'];
}

// function sendMail($id){
//     global $con;
//     ob_end_clean();
//     require('fpdf/fpdf.php');
//     $sql = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id = '".$id."'");
//     $row = mysqli_fetch_assoc($sql);
//     $prop[0] = fetchData($row['property_id'], 2);
//     $sql1 = mysqli_query($con, "SELECT location_id, property_address, phone, email, check_in_time, check_out_time FROM properties WHERE property_id = '".$row['property_id']."'");
//     $row1 = mysqli_fetch_assoc($sql1);
//     $prop[1] = fetchData($row1['location_id'], 1);

//     class PDF extends FPDF
//     {
//         function Header(){
//             global $row1;
//             $this->Image('assets/images/logo.jpg',10,6,25);            
//             $this->SetFont('Arial','',9);               
//             $this->SetX($this->lMargin);
//             $this->Cell(0,10,$row1['property_address'],0,0,'R');      
//             $this->Ln(5);
//             $this->SetX($this->lMargin);
//             $this->Cell(0,10,"Phone: ".$row1['phone'],0,0,'R');  
//             $this->Ln(5);
//             $this->SetX($this->lMargin);
//             $this->Cell(0,10,"Email: ".$row1['email'],0,0,'R'); 
//             $this->Ln(20);
//         }

//         function Footer(){
//             $this->SetY(-15);
//             $this->SetFont('Arial','I',8);
//             $this->Cell(0,10,'Powered by Techworth Technologies Pvt. Ltd. (www.techworth.in)',0,0,'C');
//         }

//         function Table(){
//             global $row;
//             global $row1;
//             global $con;
//             global $_POST;
//             global $prop;
//             $this->SetFont('Arial','B',10); 
//             $this->SetFillColor(235,235,235);
//             $this->Cell(105,10,'Booking Details',1,0,'L',1);
//             $this->Cell(80,10,'Guest Details',1,0,'L',1);
//             $this->Ln(10);
//             $this->SetFont('Arial','',8); 
//             $this->Cell(105,10,'Reservation No: ' . $row['reservation_number'],1,0,'L');
//             $this->Cell(80,10,'Guest Name: ' . $row['name'],1,0,'L');
//             $this->Ln(10);
//             $this->Cell(105,10,'Transaction Id: ' . $row['payment_id'],1,0,'L');
//             $this->Cell(80,10,'Email: ' . $row['email'],1,0,'L');
//             $this->Ln(10);
//             $this->Cell(105,10,'Property: ' . $prop[0].", ".$prop[1],1,0,'L');
//             $this->Cell(80,10,'Phone: ' . $row['phone'],1,0,'L');
//             $this->Ln(10);
//             $this->Cell(105,10,'Booking Date & Time: ' . $row['time'],1,0,'L');
//             $text1 = 'Address: ' . $row['address'] . ', ' . $row['city'] . ', ' . $row['state'] . ' - ' . $row['pin'];
//             $this->Cell(80,10,'Photo ID No.: ' . $row['aadhaar'],1,0,'L');                       
//             $this->Ln(10);
//             $this->Cell(52.5,10,'Check-in Date: ' . date("d-m-Y", strtotime($row['check_in']))." (".$row1['check_in_time'].")",1,0,'L');
//             $this->Cell(52.5,10,'Check-out Date: ' . date("d-m-Y", strtotime($row['check_out']))." (".$row1['check_out_time'].")",1,0,'L');
//             $this->MultiCell(80, 5 ,$text1, 1, 1); 
//             $this->Ln(10);

//             $this->SetFont('Arial','B',10); 
//             $this->Cell(185,10,'Room Details',1,1,'C',1);
//             $this->Ln(0);
//             $this->SetFont('Arial','B',8);
//             $this->Cell(30,10,'From',1,0,'L');
//             $this->Cell(30,10,'To',1,0,'L');
//             $this->Cell(55,10,'Room Type',1,0,'L');
//             $this->Cell(10,10,'Qty',1,0,'L');
//             $this->Cell(30,10,'Status',1,0,'L');
//             $this->Cell(30,10,'Amount (Rs.)',1,0,'L');
//             $this->Ln(10);
//             $this->SetFont('Arial','',8); 
//             $sql2 = mysqli_query($con, "SELECT * FROM reserved_rooms WHERE reservation_id = '".$_POST['id']."'");
//             while($row2 = mysqli_fetch_assoc($sql2)){
//                 $this->Cell(30,10,date("d-m-Y", strtotime($row2['date'])),1,0,'L');
//                 $this->Cell(30,10,date("d-m-Y", strtotime($row2['date'] . "+1 day")),1,0,'L');
//                 $this->Cell(55,10, fetchRoomInfo($row2['room_id'], 1),1,0,'L');
//                 $this->Cell(10,10,$row2['qty'],1,0,'L');
//                 $this->Cell(30,10,'Booked',1,0,'L');                
//                 $this->Cell(30,10,$row2['qty'] * fetchRoomInfo($row2['room_id'], 2),1,0,'L');
//                 $this->Ln(10);
//             }
//             $this->SetFont('Arial','B',8);
//             $this->Cell(30,10,'',0,0,'L');
//             $this->Cell(30,10,'',0,0,'L');
//             $this->Cell(55,10,'',0,0,'L');
//             $this->Cell(10,10,'',0,0,'L');
//             $this->Cell(30,10,'Grand Total:',1,0,'L');
//             $this->SetFont('Arial','',8); 
//             $this->Cell(30,10,'Rs. ' . $row['amount'],1,0,'L');
//             $this->Ln(10);
//             $this->SetFont('Arial','B',8);
//             $this->Cell(30,10,'',0,0,'L');
//             $this->Cell(30,10,'',0,0,'L');
//             $this->Cell(55,10,'',0,0,'L');
//             $this->Cell(10,10,'',0,0,'L');
//             $this->Cell(30,10,'Advance Paid:',1,0,'L');
//             $this->Cell(30,10,'Rs. ' . $row['paid'],1,1,'L');
//             $this->Ln(10);
//         }

//         function Terms(){
//             $this->SetFont('Arial','B',10);
//             $this->Cell(185,10,'Terms & Conditions',0,0,'L',1);
//             $this->Ln(15);
//             $this->SetFont('Arial','',8); 
//             $this->MultiCell(178,5,fetchTerms());              
//         }


//     }
    
//     $pdf = new PDF();
//     $pdf->AliasNbPages();
//     $pdf->AddPage();
//     $pdf->SetFont('Times','',12);
//     $pdf->Table();
//     $pdf->Terms();
    
//     $filename = "custompdf_$name_$time.pdf";

//     $pdf->Output($filename, 'F'); // save the pdf under filename
    
//     // Instantiation and passing `true` enables exceptions
//     $mail = new PHPMailer(true);
    
//     //Server settings
//     $mail->SMTPDebug = 0;                      // Enable verbose debug output
//     $mail->isSMTP();                                            // Send using SMTP
//     $mail->Host       = $host;                    // Set the SMTP server to send through
//     $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
//     $mail->Username   = $username;                     // SMTP username
//     $mail->Password   = $password;                               // SMTP password
//     $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
//     $mail->Port       = "465"; 
    
//     $mail->From = $from2;
//     $mail->FromName = $fromname;
//     $mail->AddAddress( $row['email'], $row['name'] );  //  in this case the variable has been passed
//     $mail->SMTPDebug = 0;  // use 2 for debugging the email send
    
//     $pdf_content = file_get_contents($filename);
    
//     $mail->WordWrap = 50;
//     $mail->AddStringAttachment($pdf_content, "custompdf_for_$name_$time.pdf", "base64", "application/pdf");  // note second item is name of emailed pdf
//     $mail->IsHTML(true);
//     $mail->Subject = "Room Booking Confirmation";
//     $mail->Body = "Dear $name,<br>
//     Your room booking has been confirmed. Please find the pdf attached to get the receipt for the same.<br><br>
//     Thank you";
//     $mail->Send();
//     unlink($filename);

// }

?>
