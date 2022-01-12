<?php
include_once 'includes/header.php';
include_once 'includes/sidebar.php';
?>
<div class="content-wrapper">
<?php            
  if(isset($_SESSION['SUCCESS']) && $_SESSION['SUCCESS'] !=''){
      echo '<div class="col-12"><div class="alert alert-success" role="alert"> '.$_SESSION['SUCCESS']. '</div></div>';
      unset($_SESSION['SUCCESS']);
  }
  if(isset($_SESSION['Failure']) && $_SESSION['Failure'] !=''){
      echo '<div class="col-12"><div class="alert alert-danger" role="alert"> '.$_SESSION['Failure']. '</div></div>';
      unset($_SESSION['Failure']);
  }
?>
  <div class="col-lg-12 grid-margin stretch-card">  
    <div class="card">
      <div class="card-body">        
        <h4 class="card-title"><?php echo fetchBookingTitle($_SERVER['QUERY_STRING']); ?> Bookings</h4>        
        <?php 
        if($_SESSION['type'] == "Property"){
          if($_SERVER['QUERY_STRING'] == 1 || $_SERVER['QUERY_STRING'] == 2 || $_SERVER['QUERY_STRING'] == 3 || $_SERVER['QUERY_STRING'] == 4 || $_SERVER['QUERY_STRING'] == 5){ 
        ?>        
        <div class="table-responsive">
          <table class="table table-bordered table-striped" id="dataTable">
            <thead>
                <th>Date</th>
                <th>Resv. No.*</th>
                <th>Name*</th>                        
                <th>Phone</th>
                <th>Email</th>
                <th>Check-In</th>
                <th>Check-Out</th>
                <th>Amt*</th>
                <th>Pay Id</th>
                <th>View</th>
                <th>Edit</th>
            </thead>
            <tbody>
                <?php echo fetchBookings($_SERVER['QUERY_STRING'], $_SESSION['prop_id']); ?>
            </tbody>
          </table>
        </div>
        <?php } else { ?>
        <script>
            window.location.href = "index.html";
        </script>
        <?php 
          }
        } else {
        ?>
        <div class="row mb-3">
          <div class="col-6">
            <label class="form-label">Location</label>
            <select class="form-control" id="location-select">
              <?php echo fetchLocations(); ?>
            </select>
          </div>
          <div class="col-6">
            <label class="form-label">Property</label>
            <select class="form-control" id="property-select">
              <option value="">---Select---</option>
            </select>
          </div>
        </div>  
        <div class="table-responsive">
        <table class="table table-bordered table-striped" id="dataTable1">
          <thead>
              <th>Date</th>
              <th>Resv. No.</th>
              <th>Name</th>                        
              <th>Phone</th>
              <th>Email</th>
              <th>Check-In</th>
              <th>Check-Out</th>
              <th>Amt</th>
              <th>Pay Id</th>
          </thead>
          <tbody id="content"></tbody>
        </table>
        </div>      
        <?php
        }
        ?>
      </div>
    </div>
  </div>
</div>
<?php
include_once 'includes/footer.php';
?>
