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
        <h4 class="card-title">Upload Hero</h4>
          <form action="code.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="file" class="form-control-file" name="hero" required>
            </div>
            <button type="submit" name="uploadHero" class="btn btn-primary btn-sm">Upload</button>
          </form>                     
      </div>
    </div>
  </div>
  <div class="col-lg-12 grid-margin stretch-card">  
    <div class="card">
      <div class="card-body">        
        <h4 class="card-title">Current Hero</h4>
        <img src="../assets/images/hero.jpg" width="500px" alt="current_hero">                       
      </div>
    </div>
  </div>
</div>
<?php
include_once 'includes/footer.php';
?>
