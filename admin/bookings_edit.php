<?php
if(!isset($_POST['edit_btn'])){
    header("location: index.html");
    exit();
}
include 'includes/header.php';
include 'includes/sidebar.php';
$sql = mysqli_query($con, "SELECT * FROM reservations WHERE reservation_id = '".$_POST['edit_id']."'");
$row = mysqli_fetch_assoc($sql)
?>
<div class="modal fade" id="changeDates" tabindex="-1" role="dialog" aria-labelledby="changeDatesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Change booking date</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">
            <input type="hidden" name="qstr1" value="<?php echo $_POST['edit_q']; ?>">
          <input type="hidden" name="id1" value="<?php echo $_POST['edit_id']; ?>">
          <div class="form-group">
            <label class="form-label">Initial Check-out Date</label>
            <input type="date" class="form-control" value="<?php echo $row['check_out']; ?>" required readonly>
          </div>
          <div class="form-group">
            <label class="form-label">New Check-out Date</label>
            <input type="date" name="date" class="form-control" max="<?php echo date('Y-m-d', strtotime($row['check_out']. '- 1 day')); ?>" min="<?php echo date('Y-m-d', strtotime($row['check_in']. '+ 1 day')); ?>"  value="<?php echo $row['check_out']; ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="changeDate" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<div class="content-wrapper">
  <div class="col-lg-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">     
        <h4 class="card-title">Edit booking&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php if($_SESSION['type'] == "Property"){ ?>
          <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#changeDates">Change booking date</button>
          <?php } ?>
          </h4>
        <form action="code.php" method="POST">
            <div class="form-group">
                <input type="hidden" name="qstr" value="<?php echo $_POST['edit_q']; ?>">
                <input type="hidden" name="id" value="<?php echo $_POST['edit_id']; ?>">
                <label>Booking Status</label><br>
                <select name="status" id="status" class="form-control">
                    <option value="<?php echo $row['status']; ?>" selected hidden><?php echo $row['status']; ?></option>
                    <?php echo fetchBookingStatus($_POST['edit_q']); ?>
                </select><br>
                <label>Instamojo Id</label><br>
                <input type="text" name="payment_id" class="form-control" value="<?php echo $row['payment_id']; ?>"><br>
                <div id="note" style="display:none;">
                    <label>Cancellation Note</label><br>
                    <textarea class="form-control" id="noteText" name="note"></textarea><br>
                </div>
                <a class="btn btn-danger" href="bookings.php?<?php echo $_POST['edit_q']; ?>">
                    Cancel
                </a>
                <button type="submit" name="updateBooking" class="btn btn-success">
                    Update
                </button>
            </div>                    
        </form> 
    </div>
  </div>    
</div>
<?php
include 'includes/footer.php';
?>