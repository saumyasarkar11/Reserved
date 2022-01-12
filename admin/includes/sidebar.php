<div class="container-fluid page-body-wrapper">
<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="#">
        <i class="mdi mdi-home menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <!-- <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-circle-outline menu-icon"></i>
        <span class="menu-title">UI Elements</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
          <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
        </ul>
      </div>
    </li> -->
    <?php if($_SESSION['type'] != "Setup"){ ?>
    <li class="nav-item" id="book1">
      <a class="nav-link" href="bookings.php?1">
        <i class="mdi mdi-view-headline menu-icon"></i>
        <span class="menu-title">Current Bookings</span>
      </a>
    </li>
    <li class="nav-item" id="book4">
      <a class="nav-link" href="bookings.php?4">
        <i class="mdi mdi-view-headline menu-icon"></i>
        <span class="menu-title">Pending Bookings</span>
      </a>
    </li>
    <li class="nav-item" id="book5">
      <a class="nav-link" href="bookings.php?5">
        <i class="mdi mdi-view-headline menu-icon"></i>
        <span class="menu-title">Failed Bookings</span>
      </a>
    </li>
    <li class="nav-item" id="book2">
      <a class="nav-link" href="bookings.php?2">
        <i class="mdi mdi-view-headline menu-icon"></i>
        <span class="menu-title">Expired Bookings</span>
      </a>
    </li>
    <li class="nav-item" id="book3">
      <a class="nav-link" href="bookings.php?3">
        <i class="mdi mdi-view-headline menu-icon"></i>
        <span class="menu-title">Cancelled Bookings</span>
      </a>
    </li>
    <?php if($_SESSION['type'] == "Property"){ ?>
    <li class="nav-item">
      <a class="nav-link" id="bookRoom" href="book.php" target="_blank">
        <i class="mdi mdi-chart-pie menu-icon"></i>
        <span class="menu-title">Book room</span>
    </a>
    </li> 
    <?php } ?>
    <li class="nav-item">
      <a class="nav-link" href="rooms.php">
        <i class="mdi mdi-chart-pie menu-icon"></i>
        <span class="menu-title">Rooms</span>
      </a>
    </li>          
    <?php } if($_SESSION['type'] != "Property"){ ?>
    <li class="nav-item">
      <a class="nav-link" href="properties.php">
        <i class="mdi mdi-grid-large menu-icon"></i>
        <span class="menu-title">Properties</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="locations.php">
        <i class="mdi mdi-emoticon menu-icon"></i>
        <span class="menu-title">Locations</span>
      </a>
    </li>          
    <?php } if($_SESSION['type'] == "Setup"){ ?>
    <li class="nav-item">
      <a class="nav-link" href="hero.php">
        <i class="mdi mdi-file-document-box-outline menu-icon"></i>
        <span class="menu-title">Hero</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="logo.php">
        <i class="mdi mdi-file-document-box-outline menu-icon"></i>
        <span class="menu-title">Logo</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="configurations.php">
        <i class="mdi mdi-file-document-box-outline menu-icon"></i>
        <span class="menu-title">Configurations</span>
      </a>
    </li>
    <?php } ?>
  </ul>
</nav>

<!--Modals-->
<div class="modal fade" id="addProperty" tabindex="-1" role="dialog" aria-labelledby="addPropertyLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Property</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">
          <div class="form-group">
            <label class="form-label">Location</label>
            <select class="form-control" name="location">
              <?php echo fetchLocations(); ?>
            </select>
          </div>             
          <div class="form-group">
            <label class="form-label">Property Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Address</label>
            <textarea name="address" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Email</label>
            <input type="text" name="email" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Phone</label>
            <input type="text" name="phone" minlength="10" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <input type="text" name="password" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Api Key</label>
            <input type="text" name="key" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Auth Token</label>
            <input type="text" name="token" class="form-control" required>
          </div>
          <div class="form-group">                
            <label class="form-label">Check in</label>
            <input type="time" name="chkin" class="form-control" required>                
          </div>
          <div class="form-group">                
            <label class="form-label">Check out</label>
            <input type="time" name="chkout" class="form-control" required>                
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="addProperty" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addRoom" tabindex="-1" role="dialog" aria-labelledby="addLocationLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">        
         <div class="form-group">
            <label class="form-label">Property</label>
            <select class="form-control" name="property" required>
              <?php echo fetchPropertiesDropdown1(); ?>
            </select>
          </div>
          <div class="form-group">
            <label class="form-label">Room Type</label>
            <input type="text" name="type" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Room Description</label>
            <textarea name="desc" rows="6" class="form-control" required></textarea>
          </div>
          <div class="form-group">
            <label class="form-label">Tariff</label>
            <input type="text" name="tariff" class="form-control" required>
          </div>
          <div class="form-group">
            <label class="form-label">Number of Rooms</label>
            <input type="number" name="number" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="addRoom" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="addLocation" tabindex="-1" role="dialog" aria-labelledby="addLocationLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Room</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="code.php" method="POST">
        <div class="modal-body">        
          <div class="form-group">
            <label class="form-label">Location Name</label>
            <input type="text" name="name" class="form-control" required>
          </div>
          <div class="form-group">                
            <label class="form-label">Status</label>
            <select name="status" class="form-control">
                <option value="Open" selected>Open</option>
                <option value="Closed">Closed</option>
            </select>                
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" name="addLocation" class="btn btn-primary">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="main-panel">