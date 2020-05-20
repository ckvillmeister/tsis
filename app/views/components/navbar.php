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
        <!--<i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">15</span>-->
        <?php echo strtoupper($firstname.' '.$lastname); ?>
      </a>
      <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <span class="dropdown-item dropdown-header">Accounts</span>
        <div class="dropdown-divider"></div>
        <!--<a href="#" class="dropdown-item">
          <i class="fas fa-envelope mr-5"></i> 4 new messages
          <span class="float-right text-muted text-sm">3 mins</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-users mr-5"></i> 8 friend requests
          <span class="float-right text-muted text-sm">12 hours</span>
        </a>
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item">
          <i class="fas fa-file mr-5"></i> 3 new reports
          <span class="float-right text-muted text-sm">2 days</span>
        </a>-->
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
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button"><i
          class="fas fa-th-large"></i></a>
    </li>
  </ul>
</nav>