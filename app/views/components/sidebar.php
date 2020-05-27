<?php
  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');
  $link_2 = "";

  if (count($arr_url) > 1){
     $link_2 = ltrim($arr_url[1], '/');
  }

?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo ROOT; ?>main" class="brand-link"> 
    <div class="text-center">
      <span class="brand-text font-weight-light">
        <strong>TRINIDAD</strong>
        <h6>Supporters Information System</h6>
      </span>
    </div>
  </a>

  <div class="sidebar">
    <div class="mt-3 mb-3 d-flex">
    </div>

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
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
        <li class="nav-item has-treeview <?php if ($link=='report'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link=='report'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Report
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/ward_list" class="nav-link ml-4 <?php echo ($link_2 == 'ward_list') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Ward List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/election_result" class="nav-link ml-4 <?php echo ($link_2 == 'election_result') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Election Results</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview <?php if ($link=='leader'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link=='leader'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-user-ninja"></i>
            <p>
              Manage Leaders
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>leader/barangay_leader" class="nav-link ml-4 <?php echo ($link_2 == 'barangay_leader') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Barangay Leader</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>leader/purok_leader" class="nav-link ml-4 <?php echo ($link_2 == 'purok_leader') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Purok Leader</p>
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
  </div>
</aside>