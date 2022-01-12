<?php
require '../includes/ajax.db.php';
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
        return $row['room_type']." @ Rs. ".$row['tariff']. " / day";
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

?>
