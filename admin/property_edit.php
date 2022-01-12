<?php
if(!isset($_POST['edit_btn'])){
    header("location: index.html");
    exit();
}
include 'includes/header.php';
include 'includes/sidebar.php';
$sql = mysqli_query($con, "SELECT * FROM properties WHERE property_id = '".$_POST['edit_id']."'");
$row = mysqli_fetch_assoc($sql)
?>
<div class="content-wrapper">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">     
        <h4 class="card-title">Edit property</h4>
        <form action="code.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $_POST['edit_id']; ?>">
            <div class="form-group">                
                <label class="form-label">Location</label>
                <select name="location" class="form-control" required>
                    <?php echo fetchLocationDropdown($row['location_id']); ?>
                </select>    
            </div>
            <div class="form-group">                
                <label class="form-label">Property Name</label>
                <input type="text" name="name" class="form-control" value="<?php echo $row['property_name']; ?>">                
            </div>
            <div class="form-group">                
                <label class="form-label">Address</label>
                <textarea name="address" class="form-control" rows="1"><?php echo $row['property_address']; ?></textarea>                
            </div>
            <div class="form-group">                
                <label class="form-label">Email</label>
                <input type="text" name="email" class="form-control" value="<?php echo $row['email']; ?>">                
            </div>
            <div class="form-group">                
                <label class="form-label">Phone</label>
                <input type="text" name="phone" minlength="10" class="form-control" value="<?php echo $row['phone']; ?>">
            </div>
            <div class="form-group">                
                <label class="form-label">Mojo Api Key</label>
                <input type="text" name="mojo1" class="form-control" value="<?php echo $row['mojo_api']; ?>" <?php echo fetchReadonlyStatus(); ?>>
            </div>
            <div class="form-group">                
                <label class="form-label">Mojo Private Token</label>
                <input type="text" name="mojo2" class="form-control" value="<?php echo $row['mojo_key']; ?>" <?php echo fetchReadonlyStatus(); ?>>
            </div>
            <div class="form-group">                
                <label class="form-label">Status</label>
                <select name="status" class="form-control">
                    <option value="<?php echo $row['status']; ?>" selected hidden><?php echo $row['status']; ?></option>
                    <option value="Open">Open</option>
                    <option value="Closed">Closed</option>
                </select>                
            </div>
            <div class="form-group">                
                <label class="form-label">Check in</label>
                <input type="time" name="chkin" class="form-control" value="<?php echo $row['check_in_time']; ?>">                
            </div>
            <div class="form-group">                
                <label class="form-label">Check out</label>
                <input type="time" name="chkout" class="form-control" value="<?php echo $row['check_out_time']; ?>">                
            </div>
            <a class="btn btn-danger" href="properties.php">
                Cancel
            </a>
            <button type="submit" name="updateProperty" class="btn btn-success">
                Update
            </button>                    
        </form> 
    </div>
  </div>    
</div>
<?php
include 'includes/footer.php';
include 'includes/header.php';
?>