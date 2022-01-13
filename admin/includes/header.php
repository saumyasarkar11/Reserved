<?php
include_once 'includes/functions.php';
if(empty($_SESSION['email'])){
  header('location: login.php');
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <title>HRRS <?php echo $_SESSION['type']; ?> Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="vendors/mdi/css/materialdesignicons.min.css" />
    <link rel="stylesheet" href="vendors/base/vendor.bundle.base.css" />
    <!-- endinject -->
    <!-- inject:css -->
    <link rel="stylesheet" href="css/style.css" />
    <link rel="stylesheet" href="datatables/dataTables.min.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="images/logo-mini.jpg" />
  </head>

  <body>
    <div class="container-scroller">
      <!-- partial:partials/_navbar.html -->
      <nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="navbar-brand-wrapper d-flex justify-content-center">
          <div
            class="
              navbar-brand-inner-wrapper
              d-flex
              justify-content-between
              align-items-center
              w-100
            "
          >
            <a class="navbar-brand brand-logo" href="#"
              ><img src="images/logo.jpg" alt="logo"
            /></a>
            <a class="navbar-brand brand-logo-mini" href="#"
              ><img src="images/logo-mini.jpg" alt="logo"
            /></a>
            <button
              class="navbar-toggler navbar-toggler align-self-center"
              type="button"
              data-toggle="minimize"
            >
              <span class="mdi mdi-sort-variant"></span>
            </button>
          </div>
        </div>
        <div
          class="
            navbar-menu-wrapper
            d-flex
            align-items-center
            justify-content-end
          "
        >
          
          <ul class="navbar-nav navbar-nav-right">
            <!-- <li class="nav-item mr-4" style="float:right;">
                
            </li> -->
            <li class="nav-item nav-profile dropdown">
              <a
                class="nav-link dropdown-toggle"
                href="#"
                data-toggle="dropdown"
                id="profileDropdown"
              >
                <img src="images/faces/user.png" alt="profile" />
                <span class="nav-profile-name"><?php echo $_SESSION['type']." Admin"; ?></span>
              </a>
              <div
                class="dropdown-menu dropdown-menu-right navbar-dropdown"
                aria-labelledby="profileDropdown"
              >
                <a class="dropdown-item" href="settings.php">
                  <i class="mdi mdi-settings text-primary"></i>
                  Settings
                </a>
                <a class="dropdown-item" data-toggle="modal" data-target="#logoutModal">
                  <i class="mdi mdi-logout text-primary"></i>
                  Logout
                </a>
              </div>
            </li>
          </ul>
          <button
            class="
              navbar-toggler navbar-toggler-right
              d-lg-none
              align-self-center
            "
            type="button"
            data-toggle="offcanvas"
          >
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>

      <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select <span class="text-danger">Logout</span> below if you are ready to end your current session.</div>
        <div class="modal-footer">
             <button class="btn btn-danger" type="button" data-dismiss="modal">Cancel</button>
            <form action="code.php" method="post">
                <button class="btn btn-primary" type="submit" name="logout_btn" >Logout</button>
            </form>           
        </div>
      </div>
    </div>
  </div>