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
        border-radius: 5px;
      }

      #table_member_list{
        font-size: 10pt
      }

      .col-header {
        font-size: 10pt
      }
    </style>

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Manage Supporters</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT; ?>main">Main</a></li>
                <li class="breadcrumb-item active">Manage Supporters</li>
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

            <div class="row shadow-none p-3">
              
                <div class="col-sm-6">
                    <a href="<?php echo ROOT; ?>ward/regular" class="btn btn-primary form-control" style="height: 180px"><i class="fas fa-users" style="font-size: 100pt"></i><br>Regular Voters</a>
                </div>
                <div class="col-sm-6">
                <a href="<?php echo ROOT; ?>ward/sk" class="btn btn-secondary form-control" style="height: 180px"><i class="fas fa-user-friends" style="font-size: 100pt"></i><br>Sangguniang Kabataan Voters</a>
                </div>
                <div class="col-sm-6">
                <a href="<?php echo ROOT; ?>ward/special" class="btn btn-info form-control mt-3" style="height: 180px"><i class="fas fa-user-secret" style="font-size: 100pt"></i><br>Special Ops</a>
                </div>
            </div>

          </div>    
        </div>
      </section>
    </div>

  <?php require 'app/views/components/footer_banner.php'; ?>
</div>

</body>
<?php require 'app/views/components/footer.php'; ?>
</html>
