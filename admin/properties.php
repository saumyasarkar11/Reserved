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
        <h4 class="card-title">Properties&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <?php if($_SESSION['type'] == "Setup"){ ?>
          <button type="button" class="btn btn-dark btn-sm" data-toggle="modal" data-target="#addProperty">Add Property</button>
          <?php } ?>
        </h4>
        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="dataTable2">
                <thead>
                  <!-- <tr class="bg-info"> -->
                    <th>Name</th>
                    <th>Location</th>
                    <th>Address</th>
                    <th>Email</th>                    
                    <th>Phone</th>
                    <th>Status</th>
                    <!-- <th>Check in</th>
                    <th>Check out</th> -->
                    <th>Edit</th>
                  <!-- </tr> -->
                    
                </thead>
                <tbody>
                    <?php echo fetchProperties(); ?>
                </tbody>
            </table>
        </div>                       
      </div>
    </div>
  </div>
</div>
<?php
include_once 'includes/footer.php';
?>
