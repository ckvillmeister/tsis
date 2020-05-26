<?php
  $firstname = $_SESSION['firstname'];
  $middlename = $_SESSION['middlename'];
  $lastname = $_SESSION['lastname'];
?>

<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <!--<li class="nav-item d-none d-sm-inline-block">
      <a href="index3.html" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li>-->
  </ul>

  <!-- SEARCH FORM -->
  <div class="form-inline ml-3">
    <div class="input-group input-group-sm">
      <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
      <div class="input-group-append">
        <button class="btn btn-navbar" type="submit">
          <i class="fas fa-search"></i>
        </button>
      </div>
    </div>
  </div>

  <ul class="navbar-nav ml-auto">
   
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
      <a class="nav-link" data-toggle="dropdown" href="#">
        <img class="img-circle elevation-1" src="public/image/avatar25x25.jpg">
        <b></b>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <div class="card-outline">
          <div class="card-body box-profile">
            <div class="text-center">
              <img class="profile-user-img img-fluid img-circle" src="public/image/avatar100x100.jpg">
            </div>
            <h3 class="profile-username text-center"><?php echo strtoupper($firstname.' '.$lastname); ?></h3>
          </div>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file ml-3 mr-3"></i> Account Settings
          </a>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file ml-3 mr-3"></i> Change Password
          </a>
          <a href="main/logout" class="dropdown-item">
            <i class="fas fa-file ml-3 mr-3"></i> Logout
          </a>
        </div>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
          class="fas fa-th-large"></i></a>
    </li>
  </ul>
</nav>