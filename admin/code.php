<?php

include 'includes/functions.php';

if(isset($_POST['login'])) {
	$email=$_POST['email'];
	$password=md5($_POST['password']);
	$query= "SELECT * FROM admin_users WHERE email='$email'";
	$query_run= mysqli_query($con, $query);
    $query1= "SELECT property_id, email, password FROM properties WHERE email='$email'";
	$query_run1= mysqli_query($con, $query1);
    $num = mysqli_num_rows($query_run);
    $num1 = mysqli_num_rows($query_run1);
	$row = mysqli_fetch_assoc($query_run);
    $row1 = mysqli_fetch_assoc($query_run1);
	if ($num!=0 && $row['password']==$password) {
		$_SESSION['email'] = $row['email'];
        $_SESSION['type'] = $row['type'];
		if($row['type'] == "Master"){
			header('location: bookings.php?1');
		} else {
			header('location: properties.php?1');
		}
        
	} else if ($num1!=0 && $row1['password']==$password) {
		$_SESSION['email'] = $row1['email'];
        $_SESSION['type'] = "Property";
		$_SESSION['prop_id'] = $row1['property_id'];
        header('location: bookings.php?1');
	} else {
        $_SESSION['status'] = 'Invalid Email or Password';
        header('location: login.php');     
	}
}

if(isset($_POST['logout_btn'])){
    session_destroy();
	unset($_SESSION['email']);
	header('location: login.php');
}

if(isset($_POST['updateBooking'])){
	if(trim($_POST['payment_id']) == ""){
		$_POST['payment_id'] = "-";
	}
	
	if($_POST['status'] == "Success"){
		if(checkAvail($_POST['id'])){
			$sql = mysqli_query($con, "UPDATE reservations SET status='".$_POST['status']."', payment_id='".$_POST['payment_id']."' WHERE reservation_id='".$_POST['id']."'");
			mysqli_query($con, "UPDATE reserved_rooms SET status='Booked' WHERE reservation_id='".$_POST['id']."'");
			if($sql){
				$_SESSION['SUCCESS'] = 'Booking data updated!';
				header("location: bookings.php?".$_POST['qstr']);
			} else {
				$_SESSION['FAILURE'] = 'Something went wrong!';
				header("location: bookings.php?".$_POST['qstr']);
			}
		} else {
			$_SESSION['FAILURE'] = 'Rooms unavailable for booking';
			header("location: bookings.php?".$_POST['qstr']);	
		}
	}  else if($_POST['status'] == "Cancelled") {
		$sql = mysqli_query($con, "UPDATE reservations SET status='".$_POST['status']."', payment_id='".$_POST['payment_id']."', note= '".mysqli_real_escape_string($con, $_POST['note'])."' WHERE reservation_id='".$_POST['id']."'");
		mysqli_query($con, "UPDATE reserved_rooms SET status='".$_POST['status']."' WHERE reservation_id='".$_POST['id']."'");
		if($sql){
			$_SESSION['SUCCESS'] = 'Booking data updated!';
			?>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
			<script>
    		    $.ajax({
                  url: "../sendmail.php",
                  method: "POST",
                  data: {id: <?php echo $_POST['id']; ?>, type: 3},
                  success: function(data){
                      location.href = "bookings.php?" + <?php echo $_POST['qstr1']; ?>;
                  }
                })
    		</script>
			<?php
		} else {
			$_SESSION['FAILURE'] = 'Something went wrong!';
			header("location: bookings.php?".$_POST['qstr']);
		}
	} else {
		$sql = mysqli_query($con, "UPDATE reservations SET status='".$_POST['status']."', payment_id='".$_POST['payment_id']."' WHERE reservation_id='".$_POST['id']."'");
		if($sql){
			$_SESSION['SUCCESS'] = 'Booking data updated!';
			header("location: bookings.php?".$_POST['qstr']);
		} else {
			$_SESSION['FAILURE'] = 'Something went wrong!';
			header("location: bookings.php?".$_POST['qstr']);
		}
	}
	
}

if(isset($_POST['updateRooms'])){
	$sql = mysqli_query($con, "UPDATE rooms SET room_type='".$_POST['type']."', property_id='".$_POST['property']."', room_desc='".$_POST['desc']."', room_total='".$_POST['number']."', tariff='".$_POST['tariff']."' WHERE room_id='".$_POST['id']."'");
	if($sql){
		$_SESSION['SUCCESS'] = 'Room data updated!';
		header("location: rooms.php");
	} else {
		$_SESSION['FAILURE'] = 'Something went wrong!';
		header("location: rooms.php");
	}
}

if(isset($_POST['updateProperty'])){
	$sql = mysqli_query($con, "UPDATE properties SET property_name='".$_POST['name']."', property_address='".$_POST['address']."', email='".$_POST['email']."', phone='".$_POST['phone']."', status='".$_POST['status']."', check_in_time='".$_POST['chkin']."', check_out_time='".$_POST['chkout']."', mojo_api='".$_POST['mojo1']."' , mojo_key='".$_POST['mojo2']."'  WHERE property_id='".$_POST['id']."'");
	if($sql){
		$_SESSION['SUCCESS'] = 'Property data updated!';
		header("location: properties.php");
	} else {
		$_SESSION['FAILURE'] = 'Something went wrong!';
		header("location: properties.php");
	}
}

if(isset($_POST['uploadHero'])){
	$msg = '';
	$target_dir = "../assets/images/";
	$target_file = $target_dir . "hero";
	$imageFileType = strtolower(pathinfo(basename($_FILES["hero"]["name"]),PATHINFO_EXTENSION));

	$check = getimagesize($_FILES["hero"]["tmp_name"]);
	if($check == false) {
		$msg = "File is not an image.";
	}

	// Allow certain file formats
	if($imageFileType != "jpg") {
		$msg =  "Sorry, only JPG files are allowed.";
	}

	if ($msg == '') {
		unlink("../assets/images/hero.jpg");
		if (move_uploaded_file($_FILES["hero"]["tmp_name"], $target_file.".".$imageFileType)) {
			$_SESSION['SUCCESS'] = "The file ". htmlspecialchars(basename( $_FILES["hero"]["name"])). " has been uploaded.";
			header("location: hero.php");
		} else {
			$_SESSION['Failure'] = "The image could not be uploaded";
			header("location: hero.php");
		}
	} else {
		$_SESSION['Failure'] = $msg;
		header("location: hero.php");
	}
}

if(isset($_POST['addProperty'])){
	$password = md5($_POST['password']);
	$sql = mysqli_query($con, "INSERT INTO `properties` VALUES (NULL, '".$_POST['location']."', '".$_POST['name']."', '".$_POST['address']."', '".$_POST['chkin']."', '".$_POST['chkout']."', '".$_POST['key']."', '".$_POST['token']."', '".$_POST['phone']."', '".$_POST['email']."', '$password', 'Open')");
	if($sql){
		$_SESSION['SUCCESS'] = "Property Added Successfully!";
		header("location: properties.php");
	} else {
		$_SESSION['Failure'] = "Something went wrong";
		header("location: properties.php");
	}
}

if(isset($_POST['addRoom'])){
    $sql1 = mysqli_query($con, "SELECT sequence FROM rooms WHERE property_id='".$_POST['property']."' ORDER BY sequence DESC LIMIT 1");
    $row = mysqli_fetch_assoc($sql1);
	$sql = mysqli_query($con, "INSERT INTO `rooms` (`room_id`, `property_id`, `room_type`, `room_desc`, `room_total`, `tariff`, `sequence`) VALUES (NULL, '".$_POST['property']."', '".$_POST['type']."', '".$_POST['desc']."', '".$_POST['number']."', '".$_POST['tariff']."', '".($row['sequence'] + 1)."')");
	if($sql){
		$_SESSION['SUCCESS'] = "Room Added Successfully!";
		header("location: rooms.php");
	} else {
		$_SESSION['Failure'] = mysqli_error($con);
		header("location: rooms.php");
	}
}

if(isset($_POST['addLocation'])){
	$sql = mysqli_query($con, "INSERT INTO `locations` VALUES (NULL, '".$_POST['name']."', '".$_POST['status']."')");
	if($sql){
		$_SESSION['SUCCESS'] = "Location Added Successfully!";
		header("location: locations.php");
	} else {
		$_SESSION['Failure'] = "Something went wrong";
		header("location: locations.php");
	}
}

if(isset($_POST['setConfig'])){
	$sql = mysqli_query($con, "UPDATE configurations SET title='".$_POST['title']."', footer='".$_POST['footer']."', pay_percent='".$_POST['pay']."',terms = '".mysqli_real_escape_string($con, $_POST['terms'])."'");
	if($sql){
		$_SESSION['SUCCESS'] = "Configurations Updated Successfully!";
		header("location: configurations.php");
	} else {
		$_SESSION['Failure'] = "Something went wrong";
		header("location: configurations.php");
	}
}

if(isset($_POST['uploadDesktopLogo'])){
	$msg = '';
	$target_dir = "../assets/images/";
	$target_file = $target_dir . "logo1";
	$imageFileType = strtolower(pathinfo(basename($_FILES["logo"]["name"]),PATHINFO_EXTENSION));

	$check = getimagesize($_FILES["logo"]["tmp_name"]);
	if($check == false) {
		$msg = "File is not an image.";
	}

	// Allow certain file formats
	if($imageFileType != "jpg") {
		$msg =  "Sorry, only JPG files are allowed.";
	}

	if ($msg == '') {
		unlink("../assets/images/logo1.jpg");
		if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file.".".$imageFileType)) {
			$_SESSION['SUCCESS'] = "The file ". htmlspecialchars(basename( $_FILES["logo"]["name"])). " has been uploaded.";
			header("location: logo.php");
		} else {
			$_SESSION['Failure'] = "The image could not be uploaded";
			header("location: logo.php");
		}
	} else {
		$_SESSION['Failure'] = $msg;
		header("location: logo.php");
	}
}

if(isset($_POST['uploadMobileLogo'])){
	$msg = '';
	$target_dir = "../assets/images/";
	$target_file = $target_dir . "logo";
	$imageFileType = strtolower(pathinfo(basename($_FILES["logo"]["name"]),PATHINFO_EXTENSION));

	$check = getimagesize($_FILES["logo"]["tmp_name"]);
	if($check == false) {
		$msg = "File is not an image.";
	}

	// Allow certain file formats
	if($imageFileType != "jpg") {
		$msg =  "Sorry, only JPG files are allowed.";
	}

	if ($msg == '') {
		unlink("../assets/images/logo.jpg");
		if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file.".".$imageFileType)) {
			$_SESSION['SUCCESS'] = "The file ". htmlspecialchars(basename( $_FILES["logo"]["name"])). " has been uploaded.";
			header("location: logo.php");
		} else {
			$_SESSION['Failure'] = "The image could not be uploaded";
			header("location: logo.php");
		}
	} else {
		$_SESSION['Failure'] = $msg;
		header("location: logo.php");
	}
}

if(isset($_POST['setPassword'])){
	if(isset($_POST['setupPassword'])){
		$password = md5($_POST['setupPassword']);
		$sql = mysqli_query($con, "UPDATE admin_users SET password = '$password' WHERE type = 'Setup'");
	} else if(isset($_POST['masterPassword'])){
		$password = md5($_POST['masterPassword']);
		$sql = mysqli_query($con, "UPDATE admin_users SET password = '$password' WHERE type = 'Master'");
	} else {
		$password = md5($_POST['propertyPassword']);
		$sql = mysqli_query($con, "UPDATE properties SET password = '$password' WHERE property_id = '".$_POST['prop_id']."'");
	}
	if($sql){
		$_SESSION['SUCCESS'] = "Password Updated Successfully!";
		header("location: settings.php");
	} else {
		$_SESSION['Failure'] = "Something went wrong";
		header("location: settings.php");
	}
}

if(isset($_POST['changeDate'])){
    $sql = mysqli_query($con, "UPDATE reservations SET check_out = '".$_POST['date']."' WHERE reservation_id = '".$_POST['id1']."'");
    $sql1 = mysqli_query($con, "UPDATE reserved_rooms SET status = 'Cancelled' WHERE date >= '".$_POST['date']."' AND  reservation_id = '".$_POST['id1']."'");
    if($sql && $sql1){
		$_SESSION['SUCCESS'] = "Booking date updated successfully";
		?>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script>
		    $.ajax({
              url: "../sendmail.php",
              method: "POST",
              data: {id: <?php echo $_POST['id1']; ?>, type: 2},
              success: function(data){
                  location.href = "bookings.php?" + <?php echo $_POST['qstr1']; ?>;
              }
            })
		</script>
		<?php
	} else {
		$_SESSION['Failure'] = "Something went wrong";
		header("location: bookings.php?".$_POST['qstr1']);
	}
}
    
?>