<?php
include_once 'includes/header.php';
include_once 'includes/sidebar.php';
$sql = mysqli_query($con, "SELECT * FROM configurations WHERE config_id='1'");
$row = mysqli_fetch_assoc($sql);
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
        <h4 class="card-title">Configurations</h4>
          <form action="code.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <label class="form-label">Title</label>
                <input type="text" class="form-control" name="title" value="<?php echo $row['title']; ?>">
            </div>
            <div class="form-group">
                <label class="form-label">Footer</label>
                <input type="text" class="form-control" name="footer" value="<?php echo $row['footer']; ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Pay Percent</label>
                <input type="number" class="form-control" name="pay" value="<?php echo $row['pay_percent']; ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Terms</label>
                <textarea class="form-control" name="terms" id="terms" rows="20" required><?php echo $row['terms']; ?></textarea>
            </div>
            <button type="submit" name="setConfig" class="btn btn-success btn-sm">Update</button>
          </form>                     
      </div>
    </div>
  </div>  
</div>
<?php
include_once 'includes/footer.php';
?>
