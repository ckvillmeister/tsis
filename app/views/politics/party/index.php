<!DOCTYPE html>
<html>

<head>
  <?php require 'app/views/components/header.php'; ?>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">

<div class="wrapper">
  <?php require 'app/views/components/navbar.php'; ?>
  <?php require 'app/views/components/sidebar.php'; ?>

    <div class="content-wrapper">
        <div class="content-header">
          <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1 class="m-0 text-dark">Political Party</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item active">Political Party</li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card">

            <div class="row shadow-none m-3 rounded">
              <div class="col-lg-12 align-self-center">
                <div class="btn-group">
                  <button class="btn btn-sm btn-primary" id="btn_new_candidate" data-toggle="modal" data-target="#modal_party_form"><icon class="fas fa-plus mr-3"></icon>New</button>
                  <button class="btn btn-sm btn-secondary" id="btn_active"><icon class="fas fa-check mr-2"></icon>Active</button>
                  <button class="btn btn-sm btn-danger" id="btn_trash"><icon class="fas fa-trash mr-2"></icon>Trash</button>
                </div>
              </div>
            </div>

            <div class="row shadow-none m-3 rounded">
              <div class="col-lg-12 align-self-center">
                
                <div id="parties" class="text-center">

                  <!-- <a class="btn btn-app bg-secondary col-sm-3 h-100">
                    <i style="font-size: 50pt" class="fas fa-users"></i> Products
                  </a>

                  <a class="btn btn-app bg-secondary col-sm-3 h-100">
                    <i style="font-size: 50pt" class="fas fa-users"></i> Products
                  </a> -->

                </div>

              </div>
            </div>

          </div>    
        </div>
      </section>

    </div>

    <div class="modal fade" id="modal_party_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Political Party Information</h5>
          </div>
          <div class="modal-body">

            <form id="frmParty">
              <div class="row mt-3">
                <div class="col-lg-3 align-self-center">
                    Code:
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control form-control-sm" name="code" id="code">
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-3 align-self-center">
                    Political Party Name:
                </div>
                <div class="col-lg-9">
                    <input type="text" class="form-control form-control-sm" name="name" id="name">
                </div>
              </div>

              <div class="row mt-3 mr-0 ml-0 rounded">
                <div class="col-lg-8">
                  <span id="message"></span>
                </div>
                <div class="col-lg-4">
                  <div class="float-right">
                    <button type="submit" class="btn btn-sm btn-info" id="btn_submit"><icon class="fas fa-thumbs-up mr-2"></icon>Submit</button>
                  </div>
                </div>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>

<?php require 'app/views/components/footer_banner.php'; ?>
</div>

</body>
<?php require 'app/views/components/footer.php'; ?>
<script type="text/javascript" src="<?php echo ROOT.'public/js/party.js'; ?>"></script>
</html>