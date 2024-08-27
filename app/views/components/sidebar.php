<?php

  $url = $_GET['url'];
  $arr_url = explode('/', rtrim($url, '/'));
  $link = rtrim($arr_url[0], '/');
  $link_2 = "";

  if (count($arr_url) > 1){
     $link_2 = ltrim($arr_url[1], '/');
  }

?>

<aside class="main-sidebar sidebar-dark-info elevation-4">
  <!-- Brand Logo -->
  <a href="<?php echo ROOT; ?>main" class="brand-link"> 
    <!-- <div class="text-center"> -->
      <img src="<?php echo ROOT.$imgurl['desc']; ?>" class="brand-image img-circle elevation-3 mr-3">
      <span class="brand-text font-weight-light">
        <?php
              $sys_title_arr = explode(' ', $data['system_name']);
              $initials = '';
              foreach ($sys_title_arr as $key => $word) {
                 $initials .= substr($word, 0, 1);
              }
        ?>
        <strong><?php echo $initials ?></strong>
      </span>
    <!-- </div> -->
  </a>

  <div class="sidebar">

    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">

        <?php if ($accessrole_model->check_access($role, 'dashboard')): ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>dashboard" class="nav-link <?php echo ($link == 'dashboard') ? 'active' : ''; ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Dashboard
            </p>
          </a>
        </li>
        <?php endif; ?>

        <?php if ($accessrole_model->check_access($role, 'search')): ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>report/search" class="nav-link <?php echo ($link_2 == 'search') ? 'active' : ''; ?>">
            <i class="nav-icon fas fas fa-search"></i>
            <p>
              Search
            </p>
          </a>
        </li>
        <li class="nav-item">
        <?php endif; ?>

        <?php if ($accessrole_model->check_access($role, 'warding')): ?>
        <li class="nav-item">
          <a href="<?php echo ROOT; ?>ward" class="nav-link <?php echo ($link == 'ward' || $link == 'ward' && ($link_2 == 'regular' || $link_2 == 'sk')) ? 'active' : ''; ?>">
            <i class="nav-icon fas fas fa-users"></i>
            <p>
              Manage Supporters
            </p>
          </a>
        </li>
        <?php endif; ?>
          
        <?php if ($accessrole_model->check_access($role, 'report')): ?>
        <li class="nav-item has-treeview <?php if ($link=='report' & $link_2 != 'search'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link=='report' & $link_2 != 'search'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-file-alt"></i>
            <p>
              Generate Reports
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <?php if ($accessrole_model->check_access($role, 'wardlist')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/ward_list" class="nav-link <?php echo ($link_2 == 'ward_list') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Ward List</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'electionresults')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/election_result" class="nav-link <?php echo ($link_2 == 'election_result') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Election Results</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'comparison')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/comparison" class="nav-link <?php echo ($link_2 == 'comparison') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Comparison</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'supporters')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/supporters" class="nav-link <?php echo ($link_2 == 'supporters') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Supporters</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'summary')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>report/summary" class="nav-link <?php echo ($link_2 == 'summary') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Summary</p>
              </a>
            </li>
            <?php endif; ?>

          </ul>
        </li>
        <?php endif; ?>

        <?php if ($accessrole_model->check_access($role, 'leaders')): ?>
        <li class="nav-item has-treeview <?php if ($link=='leader'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link=='leader'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-user-ninja"></i>
            <p>
              Manage Leaders
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <?php if ($accessrole_model->check_access($role, 'brgyleader')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>leader/barangay_leader" class="nav-link <?php echo ($link_2 == 'barangay_leader') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Barangay Leader</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'purokleader')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>leader/purok_leader" class="nav-link <?php echo ($link_2 == 'purok_leader') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Purok Leader</p>
              </a>
            </li>
            <?php endif; ?>

          </ul>
        </li>
        <?php endif; ?>

        <li class="nav-item has-treeview <?php if ($link == 'politics' & ($link_2 == '' | $link_2 == 'profile' | $link_2 == 'party' | $link_2 == 'manage')) { echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if ($link == 'politics' & ($link_2 == '' | $link_2 == 'profile' | $link_2 == 'party' | $link_2 == 'manage')){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-vote-yea"></i>
            <p>
              Political Candidates
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <?php if ($accessrole_model->check_access($role, 'politician')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>politics" class="nav-link <?php echo ($link == 'politics' & ($link_2 == '' | $link_2 == 'profile')) ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Politician Info</p>
              </a>
            </li>
            <?php endif; ?>

            <li class="nav-item">
              <a href="<?php echo ROOT; ?>politics/party" class="nav-link <?php echo ($link == 'politics' & ($link_2 == 'party' | $link_2 == 'manage')) ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Political Party</p>
              </a>
            </li>

          </ul>
        </li>

        <?php if ($accessrole_model->check_access($role, 'maintenance')): ?>
        <li class="nav-item has-treeview <?php if (($link == 'voter' & $link_2 == '') | ($link == 'settings' & $link_2 == 'barangay') | $link=='accessrole' | $link=='accounts' | $link=='settings'){ echo 'menu-open'; } ?>">
          <a href="#" class="nav-link <?php if (($link == 'voter' & $link_2 == '') | ($link == 'settings' & $link_2 == 'barangay') | $link=='accessrole' | $link=='accounts' | $link=='settings'){ echo 'active'; } ?>">
            <i class="nav-icon fas fa-wrench"></i>
            <p>
              Maintenance
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <?php if ($accessrole_model->check_access($role, 'barangay')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>settings/barangay" class="nav-link <?php echo ($link == 'settings' & $link_2 == 'barangay') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Barangays</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'voters')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>voter" class="nav-link <?php echo ($link == 'voter' & $link_2 == '') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Voters Information</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'roles')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>accessrole" class="nav-link <?php echo ($link == 'accessrole') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Access Roles</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'accounts')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>accounts" class="nav-link <?php echo ($link == 'accounts') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>User Accounts</p>
              </a>
            </li>
            <?php endif; ?>

            <?php if ($accessrole_model->check_access($role, 'system')): ?>
            <li class="nav-item">
              <a href="<?php echo ROOT; ?>settings" class="nav-link <?php echo ($link == 'settings' & $link_2 == '') ? 'active' : ''; ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>System Settings</p>
              </a>
            </li>
            <?php endif; ?>

          </ul>
        </li>
        <?php endif; ?>

    </nav>
  </div>
</aside>