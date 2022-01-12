<?php
session_start();
include '../includes/ajax.db.php';
$con=mysqli_connect($db_host, $db_username, $db_password, $db_name)
or die(mysqli_error($con));

function fetchBookingTitle($id){
    if($id == 1){
        return "Current";
    } else if($id == 2){
        return "Expired";
    } else if($id == 3){
        return "Cancelled";
    } else if($id == 4){
        return "Pending";
    } else {
        return "Failed";
    }
}

function fetchReadonlyStatus(){
    if($_SESSION['type'] == "Property"){
        return "readonly";
    }
}

function fetchReadonlyStatus1(){
    if($_SESSION['type'] == "Master"){
        return "readonly";
    }
}

function fetchBookings($status, $prop){
    global $con;
    $output = '';
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
        $output .= '<tr>
                        <td>'.substr($row['time'], 0, 10).'</td>
                        <td data-toggle="tooltip" title="'.$row['note'].'">'.$row['reservation_number'].'</td>
                        <td data-toggle="tooltip" title="'.$row['address'].'">'.$row['name'].'</td>                            
                        <td>'.$row['phone'].'</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['check_in'].'</td>
                        <td>'.$row['check_out'].'</td>
                        <td data-toggle="tooltip" title="Paid: '.$row['paid'].'">'.$row['amount'].'</td>
                        <td>'.$row['payment_id'].'</td>
                        <td>
                            <form action="../receipt.php" method="POST" target="_blank">
                                <input type="hidden" name="id" value="'.$row['reservation_id'].'">
                                <button type="submit" name="receipt" class="btn btn-primary btn-sm">View</button>
                            </form>
                        </td>';
        if($status != 3 && $status != 2){
            $output .= '<td>
                            <form action="bookings_edit.php" method="post">
                                <input type="hidden" name="edit_id" value="'.$row['reservation_id'].'">
                                <input type="hidden" name="edit_q" value="'.$_SERVER['QUERY_STRING'].'">
                                <button type="submit" name="edit_btn" class="btn btn-success btn-sm">
                                    Edit
                                </button>
                            </form>
                        </td>';
        } else {
            $output .= '<td>-</td>';
        }
        $output .= '</tr>';       
    }
    return $output;
}

function fetchLocations(){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM locations WHERE status='Open' ORDER BY location_name ASC");    
    $output = '<option value="" selected hidden>---Select---</option>';
    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
    }
    return $output;
}

function fetchPropertyName($id){
    global $con;
    $sql = mysqli_query($con, "SELECT property_name, location_id FROM properties WHERE property_id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    $sql1 = mysqli_query($con, "SELECT location_name FROM locations WHERE location_id = '".$row['location_id']."'");
    $row1 = mysqli_fetch_assoc($sql1);
    return $row['property_name'].", ".$row1['location_name'];
}

function fetchRooms(){
    global $con;
    $output = '';
    if($_SESSION['type'] == "Master"){
        $sql = mysqli_query($con, "SELECT * FROM rooms");
    } else {
        $sql = mysqli_query($con, "SELECT * FROM rooms WHERE property_id = '".$_SESSION['prop_id']."'");
    }

    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<tr>
                        <td>'.$row['room_type'].'</td>
                        <td>'.fetchPropertyName($row['property_id']).'</td>
                        <td data-toggle="tooltip" title="'.$row['room_desc'].'">View</td>                            
                        <td>'.$row['room_total'].'</td>
                        <td>'.$row['tariff'].'</td>
                        <td class="sequence" data-id="'.$row['room_id'].'" contenteditable>'.$row['sequence'].'</td>
                        <td>
                            <form action="rooms_edit.php" method="post">
                                <input type="hidden" name="edit_id" value="'.$row['room_id'].'">
                                <button type="submit" name="edit_btn" class="btn btn-success btn-sm">
                                    Edit
                                </button>
                            </form>
                        </td>
                    </tr>';
    }
    return $output;
}

function fetchLocationName($id){
    global $con;
    $sql = mysqli_query($con, "SELECT location_name FROM locations WHERE location_id = '$id'");
    $row = mysqli_fetch_assoc($sql);
    return $row['location_name'];
}

function fetchProperties(){
    global $con;
    $output = '';
    $sql = mysqli_query($con, "SELECT * FROM properties");

    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<tr>
                        <td>'.$row['property_name'].'</td>
                        <td>'.fetchLocationName($row['location_id']).'</td>
                        <td data-toggle="tooltip" title="'.$row['property_address'].'">View</td>
                        <td>'.$row['email'].'</td>
                        <td>'.$row['phone'].'</td>
                        <td>'.$row['status'].'</td>                  
                        <td>
                            <form action="property_edit.php" method="post">
                                <input type="hidden" name="edit_id" value="'.$row['property_id'].'">
                                <button type="submit" name="edit_btn" class="btn btn-success btn-sm">
                                    Edit
                                </button>
                            </form>
                        </td>
                    </tr>';
    }
    return $output;
}

function fetchLocationsTable(){
    global $con;
    $output = '';
    $sql = mysqli_query($con, "SELECT * FROM locations ORDER BY location_name ASC");
    $i=1;
    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<tr>
                        <td>'.$i.'</td>
                        <td class="location_name" data-id="'.$row['location_id'].'" contenteditable>'.$row['location_name'].'</td>
                        <td>
                            <select class="statusUpdate" data-id="'.$row['location_id'].'">
                                <option value="'.$row['status'].'" selected hidden>'.$row['status'].'</option>
                                <option value="Open">Open</option>
                                <option value="Closed">Closed</option>
                            </select>
                        </td>
                    </tr>';
        $i++;
    }
    return $output;
}

function fetchPropertiesDropdown(){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM properties");    
    $output = '<option value="" selected hidden>---Select---</option>';
    $num = mysqli_num_rows($sql);
    while($row = mysqli_fetch_assoc($sql)){
        if($row['property_id'] == $_SESSION['prop_id']){
            $output .= '<option value="'.$row['property_id'].'" selected>'.fetchPropertyName($row['property_id']).'</option>';
        } else {
            $output .= '<option value="'.$row['property_id'].'">'.fetchPropertyName($row['property_id']).'</option>';
        }
                
    }
    return $output;
}

function fetchPropertiesDropdown1(){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM properties WHERE status='Open'");    
    $output = '<option value="" selected hidden>---Select---</option>';
    $num = mysqli_num_rows($sql);
    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<option value="'.$row['property_id'].'">'.$row['property_name'].', '.fetchLocationName($row['location_id']).'</option>';
    }
    return $output;
}

function fetchPropertiesDropdown2($id){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM properties WHERE status='Open'");    
    $output = '<option value="" selected hidden>---Select---</option>';
    $num = mysqli_num_rows($sql);
    while($row = mysqli_fetch_assoc($sql)){
        if($id == $row['property_id']){
            $output .= '<option value="'.$row['property_id'].'" selected>'.$row['property_name'].', '.fetchLocationName($row['location_id']).'</option>';
        } else {
            $output .= '<option value="'.$row['property_id'].'">'.$row['property_name'].', '.fetchLocationName($row['location_id']).'</option>';
        }
        
    }
    return $output;
}

function fetchRoomsNo($id, $date){
    global $con;
    $sql1 = mysqli_query($con, "SELECT room_total FROM rooms WHERE room_id='$id'");
    $row1 = mysqli_fetch_assoc($sql1);
    $qty = 0;
    $sql2 = mysqli_query($con, "SELECT qty FROM reserved_rooms WHERE room_id='$id' AND date='$date' AND status = 'Booked'");
    while($row2 = mysqli_fetch_assoc($sql2)){
        $qty += $row2['qty'];
    }
    return $row1['room_total'] - $qty;
}

function checkAvail($id){
    global $con;
    $flag = 1;
    $sql = mysqli_query($con, "SELECT * FROM reserved_rooms WHERE reservation_id='$id'");
    while($row = mysqli_fetch_assoc($sql)){
        if(fetchRoomsNo($row['room_id'], $row['date']) - $row['qty'] < 0){
            $flag = 0;            
        }
    }
    return $flag;
}

function fetchLocationDropdown($i){
    global $con;
    $sql = mysqli_query($con, "SELECT * FROM locations WHERE status='Open' ORDER BY location_name ASC");    
    $output = '<option value="'.$i.'" selected hidden>'.fetchLocationName($i).'</option>';
    while($row = mysqli_fetch_assoc($sql)){
        $output .= '<option value="'.$row['location_id'].'">'.$row['location_name'].'</option>';
    }
    return $output;
}

function fetchBookingStatus($q){
    if($q == 1){
        $output = '<option value="Cancelled">Cancelled</option>';
    } else if($q == 2){
        $output = '<option value="Success">Success</option>';
    } else if($q == 4){
        $output = '<option value="Success">Success</option><option value="Failed">Failed</option>';
    } else if($q == 5){
        $output = '<option value="Success">Success</option>';
    }
    return $output;
}

?>