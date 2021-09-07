<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>

    <?php require 'app/views/components/footer_banner.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Access Rights<b><?php echo array_key_exists('rolename', $data['rolename']) ? ': '.$data['rolename']['rolename'] : ''; ?></b></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>accessrole">Access Role</a></li>
                <li class="breadcrumb-item active">Manage Access Rights</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content" id="access_rights">
        <div class="container-fluid">
          <div class="card">

            <?php
              foreach ($data['access_rights'] as $key => $category) {
            ?>
              <div class="card m-2">
                <div class="card-header">
                  <h5><?php echo $category['description']; ?></h5>
                </div>
                <div class="card-body">
                  <?php
                    $ctr = 1;
                    foreach ($category['access_codes'] as $key => $codes):
                        
                      if ($ctr == 1):
                        echo '<div class="row pt-1 pr-3 pl-3 pb-1">';
                      endif; 
                ?>
                      <div class="col-sm-6">
                        <div class="bg-light p-2">
                        <h5>
                          <input type="checkbox" value="<?php echo $codes['id']; ?>" class="mr-3" <?php echo ($codes['hasaccess']) ? 'checked' : ''; ?>><?php echo $codes['description']; ?>
                        </h5>
                        </div>
                      </div>
                <?php
                      
                      if ($ctr == 2):
                        echo '</div>';
                      endif;

                      $ctr++; 
                      
                      if ($ctr == 3):
                        $ctr = 1; 
                      endif; 
                    endforeach;
                  ?>
                  </div>
                </div>
              </div>
            <?php
              }
            ?>
          <div class="row m-2">
            <div class="col-sm-12">
              <div class="float-right">
                <button class="btn btn-lg btn-primary" id="btn_save_access_rights" value="<?php echo $_GET['id']; ?>">Save</button>
              </div>
            </div>
          </div>    
        </div>
      </section>
    </div>
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
<script type="text/javascript" src="<?php echo ROOT.'public/js/access_role.js'; ?>"></script>
</html>