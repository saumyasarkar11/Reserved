<?php
if(!isset($_POST['edit_btn'])){
    header("location: index.html");
    exit();
}
include 'includes/header.php';
include 'includes/sidebar.php';
$sql = mysqli_query($con, "SELECT * FROM rooms WHERE room_id = '".$_POST['edit_id']."'");
$row = mysqli_fetch_assoc($sql)
?>
<div class="content-wrapper">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">     
        <h4 class="card-title">Edit room</h4>
        <form action="code.php" method="POST">
            <input type="hidden" name="id" value="<?php echo $_POST['edit_id']; ?>">      
            <div class="form-group">                
                <label class="form-label">Property</label>
                <select class="form-control" name="property" required <?php echo fetchReadonlyStatus(); ?> required>
                  <?php echo fetchPropertiesDropdown2($row['property_id']); ?>
                </select>           
            </div>
            <div class="form-group">                
                <label class="form-label">Room Type</label>
                <input type="text" name="type" class="form-control" value="<?php echo $row['room_type']; ?>" <?php echo fetchReadonlyStatus(); ?> required>                
            </div>
            <div class="form-group">                
                <label class="form-label">Room Description</label>
                <textarea name="desc" class="form-control" rows="2"  <?php echo fetchReadonlyStatus(); ?> required><?php echo $row['room_desc']; ?></textarea>                
            </div>
            <div class="form-group">                
                <label class="form-label">Tariff</label>
                <input type="number" name="tariff" class="form-control" value="<?php echo $row['tariff']; ?>"  <?php echo fetchReadonlyStatus(); ?> required>                
            </div>
            <div class="form-group">                
                <label class="form-label">Number of Rooms</label>
                <input type="text" name="number" class="form-control" value="<?php echo $row['room_total']; ?>" required>                
            </div>            
            <a class="btn btn-danger" href="rooms.php">
                Cancel
            </a>
            <button type="submit" name="updateRooms" class="btn btn-success">
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