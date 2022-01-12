<?php
session_start();
require 'ajax.db.php';

function fetchProperties($id){
    global $con;
    $output = array();
    $sql = mysqli_query($con, "SELECT * FROM properties WHERE location_id = '$id' AND status='Open' ORDER BY property_name ASC");    
    $output[0] = '<option value="" selected hidden>---Select---</option>';
    $num = mysqli_num_rows($sql);
    while($row = mysqli_fetch_assoc($sql)){
        if($num == 1){
            $output[0] = '';
            $output[0] .= '<option value="'.$row['property_id'].'" selected>'.$row['property_name'].'</option>';
        } else {
            $output[0] .= '<option value="'.$row['property_id'].'">'.$row['property_name'].'</option>';
        }
        
    }
    $output[1] = $num;
    return $output;
}

function fetchSpecDates($in, $out, $id, $total, $tariff, $rooms){
    global $con;
    $ini = $in;
    $output = '';    
    while($ini != $out){
        $temp = $total;   
        $num = 0;      
        $sql = mysqli_query($con, "SELECT qty FROM reserved_rooms WHERE room_id='$id' AND date='$ini' AND status = 'Booked'");
        while($row = mysqli_fetch_assoc($sql)){
            $num += $row['qty']; 
        }     
        $temp = $temp - $num;
        ($rooms > $temp) ? $criteria = $temp : $criteria = $rooms; 
        $output .= '<td><span>Rs. '.$tariff.'</span><br>Available Rooms: <span class="text-success"><b>'.$temp.'</b></span><br><select class="room_numbers" data-id="'.$ini.'" data-room="'.$id.'">';
        for($i=0; $i<=$criteria; $i++){
            $output .= '<option value="'.$i.'">'.$i.'</output>';
        }        
        $ini = date("Y-m-d", strtotime("$ini +1 day"));
    }
    return $output;
}

function fetchTableHeaders($in, $out){
    $output = '<th>ROOM TYPES</th>';
    while($in != $out){
        $output .= '<th>'.date("d-m-Y", strtotime($in)).'</th>';
        $in = date("Y-m-d", strtotime("$in +1 day"));
    }
    return $output;
}

function fetchTotalRow($in, $out){
    $output = '<td><b>Total Room(s) Selected</b></td>';
    while($in != $out){
        $output .= '<td><input name="'.$in.'" value="0" size="1" readonly></th>';
        $in = date("Y-m-d", strtotime("$in +1 day"));
    }
    return $output;
}

function fetchPropInfo($id, $in, $out, $rooms){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM rooms WHERE property_id = '$id' ORDER BY sequence ASC");    
    $output = '<table class="table table-bordered table-striped">'.fetchTableHeaders($in, $out);
    $num = mysqli_num_rows($sql);
    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<tr>
                        <td width="20%">
                            <b>'.$row['room_type'].'</b><br>
                            <a href="#" data-bs-toggle="modal" data-body="'.$row['room_desc'].'" data-id="Room Description: '.$row['room_type'].'" class="rm_desc" data-bs-target="#descModal">View Room Description</a>
                        </td>
                        '.fetchSpecDates($in, $out, $row['room_id'], $row['room_total'], $row['tariff'], $rooms).'
                    </tr>';
    }
    $output .= '<tr>'.fetchTotalRow($in, $out).'</tr>';
    $output .= '</table>';
    return $output;
}

function fetchRoomInfo($id){
    global $con;
    $sql = mysqli_query($con, "SELECT room_total FROM rooms WHERE room_id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    return $row['room_total'];
}

function finalAvail(){
    global $con;
    $output = '';
    $arr = array();
    $arr = $_SESSION['rooms-arr'];    
    $pattern="/(?<=\[)(.*?)(?=\[)/";    
    $total = 0;
    foreach($arr as $value){
        $value="[".str_replace("?", "[", $value)."[";
        preg_match_all($pattern, $value, $result);
        $date = date("d-m-Y", strtotime($result[0][0]));
        $room = $result[0][1];
        $no = $result[0][2];
        if($no != 0){
            $num = 0;
            $sql = mysqli_query($con, "SELECT qty FROM reserved_rooms WHERE room_id='$room' AND date='".$result[0][0]."'");
            while($row = mysqli_fetch_assoc($sql)){
                $num += $row['qty']; 
            } 
            (fetchRoomInfo($room) - $num) < $no ? $output = 0 : $output = 1;
        }        
    }
    return $output;
}

function setSession($rooms_arr, $chkin, $chkout, $prop){
    $_SESSION['rooms-arr'] = $rooms_arr;
    $_SESSION['last_activity'] = time();
    $_SESSION['chkin'] = $chkin;
    $_SESSION['chkout'] = $chkout;
    $_SESSION['prop'] = $prop;
    
    return 1;
}

if(isset($_POST['loc'])){
    echo json_encode(fetchProperties($_POST['loc']));
}

if(isset($_POST['prop']) && isset($_POST['chkin'])){
    echo fetchPropInfo($_POST['prop'], $_POST['chkin'], $_POST['chkout'], $_POST['rooms']);
}

if(isset($_POST['arr'])){
    echo setSession($_POST['arr'], $_POST['chk_in'], $_POST['chk_out'], $_POST['prop']);
}

if(isset($_POST['checkAvailFinal'])){
    echo finalAvail();
}

?>
