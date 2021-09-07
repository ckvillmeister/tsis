<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>

    <style>
    #btn_view_leaders, #btn_search_leader, #btn_search_member, #btn_submit, #btn_delete_ward {
      width:160px;
      border-radius: 10px;
    }
    </style>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Ward Information</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item active">Ward Info</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="overlay-wrapper">
            
            </div>

            <div class="row p-3 shadow-none m-3 bg-light rounded">
            	<div class="col-sm-12">
                    <div class="card card-widget widget-user">
                      <div class="widget-user-header bg-info">
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="<?php echo ($data['leader_info']['imgurl']) ? ROOT.$data['leader_info']['imgurl'] : ROOT.'public/image/avatar.png'; ?>">
                      </div>
                      <div class="card-footer mt-3">
                        <div class="row">
                          <div class="col-sm-12 text-center">
                            <h5 class="text-center"><?php echo $data['leader_info']['firstname'].' '.trim($data['leader_info']['middlename']).' '.$data['leader_info']['lastname'].' '.trim($data['leader_info']['suffix']); ?></h5>
                            <?php 
                              $purok = ($data['leader_info']['purok']) ? ' - PUROK '.$data['leader_info']['purok'] : '';
                              echo $data['leader_info']['barangay'].$purok.' LEADER'; 
                            ?>
                          </div>
                        </div>
                      </div>
                  </div>
                </div>
            </div>

            <div class="row p-3 shadow-none mr-3 ml-3 mb-3 bg-light rounded">
              <?php

              foreach ($data['members_info'] as $key => $member) {
              ?>
                <div class="col-sm-4">
                    <div class="card card-widget widget-user">
                      <div class="widget-user-header bg-warning">
                        <h6 style="text-shadow: 1px 1px white"><?php echo $member['firstname'].' '.trim($member['middlename']).' '.$member['lastname'].' '.trim($member['suffix']); ?></h6>
                      </div>
                      <div class="widget-user-image">
                        <img class="img-circle elevation-2" src="<?php echo ($member['imgurl']) ? ROOT.$member['imgurl'] : ROOT.'public/image/avatar.png'; ?>">
                      </div>
                      <div class="card-footer">
                        <div class="row">
                        </div>
                      </div>
                  </div>
                </div>
              <?php
              }
            ?>
            </div>

          </div>    
        </div>
      </section>
    </div>

  <?php require 'app/views/components/footer_banner.php'; ?>
</div>

<div class="modal fade" id="modal_message_box" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal_title"></h5>
      </div>
      <div class="modal-body">
        <h6 class="modal-body" id="modal_body"></h5>
      </div>
      <div class="modal-footer">
      
      </div>
    </div>
  </div>
</div>
</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="text/javascript" src="<?php echo ROOT.'public/js/ward.js'; ?>"></script>
</html>
