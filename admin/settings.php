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
  <div class="row">
    <?php if($_SESSION['type'] == "Setup"){ ?>
    <div class="col-md-6 grid-margin stretch-card">  
        <div class="card">
            <div class="card-body">        
                <h4 class="card-title">Change Setup Password</h4>
                <form action="code.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" name="setupPassword" required>
                    </div>
                    <button type="submit" name="setPassword" class="btn btn-primary btn-sm">Save</button>
                </form>                     
            </div>
        </div>
    </div>
    <?php } if($_SESSION['type'] != "Property"){ ?>
    <div class="col-md-6 grid-margin stretch-card">  
        <div class="card">
            <div class="card-body">        
                <h4 class="card-title">Set Master Admin Password</h4>
                <form action="code.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" name="masterPassword" required>
                    </div>
                    <button type="submit" name="setPassword" class="btn btn-primary btn-sm">Save</button>
                </form>                    
            </div>
        </div>
    </div>
    <?php } if($_SESSION['type'] != "Setup"){ ?>
    <div class="col-md-6 grid-margin stretch-card">  
        <div class="card">
            <div class="card-body">        
                <h4 class="card-title">Set Property Password</h4>
                <form action="code.php" method="POST">
                    <div class="form-group">
                        <label class="form-label">Property</label>
                        <?php if($_SESSION['type'] == "Property"){ ?>
                        <select class="form-control" name="prop_id" required readonly>
                        <?php } else { ?>
                        <select class="form-control" name="prop_id" required><?php } ?>
                            <?php echo fetchPropertiesDropdown(); ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="text" class="form-control" name="propertyPassword" required>
                    </div>
                    <button type="submit" name="setPassword" class="btn btn-primary btn-sm">Save</button>
                </form>                    
            </div>
        </div>
    </div>
    <?php } ?>
  </div>
</div>
<?php
include_once 'includes/footer.php';
?>
