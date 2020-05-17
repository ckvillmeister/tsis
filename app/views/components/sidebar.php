<?php
  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');

  $firstname = $_SESSION['firstname'];
  $middlename = $_SESSION['middlename'];
  $lastname = $_SESSION['lastname'];
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="main" class="brand-link" >
    <img src="<?php echo ROOT.'public/image/Trinidad_Logo.png'; ?>" alt="Municipality of Trinidad Logo" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    <span class="brand-text font-weight-light"><strong>TRINIDAD</strong><br><h6>Supporters Information System</h6></span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-5 pb-3 mb-3 d-flex">
      <div class="image">
        <!--<img src="#" class="img-circle elevation-2" alt="User Image">-->
      </div>
      <div class="info text-center">
        <a href="#" class="d-block"><?php echo $firstname.' '.$lastname; ?></a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>dashboard" class="nav-link <?php echo ($link == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>ward" class="nav-link <?php echo ($link == 'ward') ? 'active' : ''; ?>">
            <i class="nav-icon fas fas fa-users"></i>
            <p>
              Warding
            </p>
          </a>
        </li>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>voter" class="nav-link <?php echo ($link == 'voter') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-user-tag"></i>
            <p>
              Voter's Information
            </p>
          </a>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Report
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="report/ward_list" class="nav-link ml-4">
                <i class="far fa-circle nav-icon"></i>
                <p>Ward List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report/voters_list" class="nav-link ml-4">
                <i class="far fa-circle nav-icon"></i>
                <p>Voters List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="report/election_result" class="nav-link ml-4">
                <i class="far fa-circle nav-icon"></i>
                <p>Election Results</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="nav-icon fas fa-user-ninja"></i>
            <p>
              Manage Leaders
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="ward/barangay_leader" class="nav-link ml-4">
                <i class="far fa-circle nav-icon"></i>
                <p>Set Barangay Leader</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="ward/purok_leader" class="nav-link ml-4">
                <i class="far fa-circle nav-icon"></i>
                <p>Set Purok Leader</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?php if ($link=='accessrole' | $link=='accounts' | $link=='settings'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link=='accessrole' | $link=='accounts' | $link=='settings'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Maintenance
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>accessrole" class="nav-link <?php echo ($link == 'accessrole') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Access Roles</p>
              </a>
            </li>
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>accounts" class="nav-link <?php echo ($link == 'accounts') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>User Accounts</p>
              </a>
            </li>
            <li class="nav-item ml-4">
              <a href="<?php echo ROOT; ?>settings" class="nav-link <?php echo ($link == 'settings') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>System Settings</p>
              </a>
            </li>
          </ul>
        </li>
        
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>