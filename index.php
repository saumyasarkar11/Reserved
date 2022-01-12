<?php
  session_start();
  if(!empty($_SESSION['rooms-arr'])){
    session_unset();
  }
  header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
  header("Pragma: no-cache"); // HTTP 1.0.
  header("Expires: 0");
  include 'includes/header.php';
?>

  <div class="container-fluid">
    <?php
      if(!empty($_SESSION['status'])){
          echo '<div><div class="alert alert-danger" role="alert"> '.$_SESSION['status']. '</div></div>';
          unset($_SESSION['status']);
      }
    ?>
    <div class="row">&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="active-step">Step1</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="pointer">Step2</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="pointer">Step3</span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </div><br>
    <h3 class="mb-4">Step 1: Room Selection</h3>
    <form class="row" autocomplete="off">
      <div class="col-md-3">
        <div class="mb-3">
          <label>Select Location</label>
          <select class="form-select" id="location-select">
            <?php echo fetchLocations(); ?>
          </select>
        </div>
      </div>
      <div class="col-md-5">
        <div class="mb-3">
          <label>Select Property</label>
          <select class="form-select" id="property-select">
            <option value="" selected hidden>---Select---</option>
          </select>
        </div>
      </div>
    </form>
    
    <div id="filters" align="left">
      <div class="col-md-8 filter-card">
        <form action="billing.php" method="POST" autocomplete="off">
        <input type="hidden" name="loc" id="loc">
        <input type="hidden" name="prop" id="prop">
        <div class="row">
          <div class="col-md-3 mb-3" align="left">
            <label class="form-label">Check In</label>
            <input type="date" class="form-control" name="check-in" id="check-in" placeholder="Check-In">
          </div>
          <div class="col-md-3 mb-3" align="left">
            <label class="form-label">Check Out</label>
            <input type="date" class="form-control" name="check-out" id="check-out" placeholder="Check-Out">
          </div>
          <div class="col-md-3 mb-3" align="left">
            <label class="form-label">No.of rooms</label>
            <select class="form-select" id="no-rooms">
              <option value="" selected hidden>---Select---</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
            </select>
          </div>
          <div class="col-md-3">
            <label class="form-label">&nbsp;</label><br>
            <button type="button" class="btn btn-primary" id="check_avail">Check Availability</button>
          </div>
        </div>
      </div>
    </div><br>
    
    <div id="loader"><img src="assets/images/loader.gif"></div>
    <div id="property-info" class="table-responsive" align="center"></div>
    <div id="proceed-btn"><button class="btn btn-primary" id="proceed" type="submit">Proceed</button></div>
    </form>
  </div>

<?php
  include 'includes/footer.php';
?>
