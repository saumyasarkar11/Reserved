<?php

require_once '../../includes/admin.db.php';
$con=mysqli_connect($db_host, $db_username, $db_password, $db_name)
or die(mysqli_error($con));

function fetchProperties($id){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM properties WHERE location_id = '$id' ORDER BY property_name ASC");    
    $output = '<option value="" selected hidden>---Select---</option>';
    $num = mysqli_num_rows($sql);
    while($row = mysqli_fetch_assoc($sql)){
        // if($num == 1){
        //     $output = '';
        //     $output .= '<option value="'.$row['property_id'].'" selected>'.$row['property_name'].'</option>';
        // } else {
            $output .= '<option value="'.$row['property_id'].'">'.$row['property_name'].'</option>';
        // }
        
    }
    return $output;
}

function fetchBookings($status, $prop){
    global $con;    
    $rows = array();
    $date = date("Y-m-d");
    if($status == 1){
        $sql = mysqli_query($con, "SELECT * FROM reservations WHERE status = 'Success' AND check_out >= '$date'  AND property_id = '$prop'");        
    } else if ($status == 2){
        $sql = mysqli_query($con, "SELECT * FROM reservations WHERE status = 'Success' AND check_out < '$date'  AND property_id = '$prop'");
    } else if($status == 3){
        $sql = mysqli_query($con, "SELECT * FROM reservations WHERE status = 'Cancelled' AND property_id = '$prop'");
    } else if($status == 4){
        $sql = mysqli_query($con, "SELECT * FROM reservations WHERE status = 'Session timed out' OR status='Payment Pending' AND property_id = '$prop'");
    } else {
        $sql = mysqli_query($con, "SELECT * FROM reservations WHERE status = 'Failed' AND property_id = '$prop'");
    }
    while($row = mysqli_fetch_assoc($sql)){
        $rows[] = $row;         
    }  
    
    return json_encode($rows);
}

function updateStatus($id, $status){
    global $con;
    $sql = mysqli_query($con, "UPDATE locations SET status='$status' WHERE location_id='$id'");
    if($sql){
        return "Status updated successfully!";
    } else {
        return "Something went wrong!";
    }
}

function updateLoc($id, $name){
    global $con;
    $sql = mysqli_query($con, "UPDATE locations SET location_name='$name' WHERE location_id='$id'");
    if($sql){
        return "Location name updated successfully!";
    } else {
        return "Something went wrong!";
    }
}

function updateSq($id, $name){
    global $con;
    $sql = mysqli_query($con, "UPDATE rooms SET sequence='$name' WHERE room_id='$id'");
    if($sql){
        return "Room sequence updated successfully!";
    } else {
        return "Something went wrong!";
    }
}


function setBookStatus(){
    $_SESSION['hotel'] = true;
}

if(isset($_POST['loc'])){
    echo fetchProperties($_POST['loc']);
}

if(isset($_POST['loc_name'])){
    echo updateLoc($_POST['loc_id'], $_POST['loc_name']);
}

if(isset($_POST['sq'])){
    echo updateSq($_POST['room_id'], $_POST['sq']);
}

if(isset($_POST['prop'])){ 
    echo fetchBookings($_POST['param'], $_POST['prop']);
}

if(isset($_POST['statusVal'])){
    echo updateStatus($_POST['id'], $_POST['statusVal']);
}

if(isset($_POST['bookRoom'])){
    echo setBookStatus();
}

?>