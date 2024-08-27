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
              <h1 class="m-0 text-dark"><?php echo $data['party']['name'] ?></h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>main">Main</a></li>
                <li class="breadcrumb-item"><a href="<?php echo ROOT ?>politics/party">Political Party</a></li>
                <li class="breadcrumb-item active"><?php echo $data['party']['name'] ?></li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        <div class="container-fluid">
          <div class="card p-3">

            <div class="row">
              <div class="col-sm-2">
                Code:
              </div>
              <div class="col-sm-5">
                <b><?php echo $data['party']['code'] ?></b>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-sm-2">
                Name:
              </div>
              <div class="col-sm-5">
                <b><?php echo $data['party']['name'] ?></b>
              </div>
            </div>

            <?php 
            if (!($data['allied_party'])){ 
              sw:
            ?>
              <div class="row mt-3">
                <div class="col-sm-2">
                  Is Allied?:
                </div>
                <div class="col-sm-5">
                  <input type="checkbox" id="allied-switch" <?php echo ($data['party']['isallied']) ? 'checked' : '' ?> data-bootstrap-switch>
                </div>
              </div>
            <?php } 
            else{
              if ($data['allied_party']['id'] == $data['party']['id']){
                goto sw;
              }
            }
            ?>

            <div class="row mt-3" id="slate">

            </div>

          </div>    
        </div>
      </section>

    </div>

    <div class="modal fade" id="modal_add_member_form" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="modal_title">Political Party Information</h5>
          </div>
          <div class="modal-body">

            <form id="frmPartAddMember">
              <div class="row mt-3">
                <div class="col-lg-3 align-self-center">
                    Politican:
                </div>
                <div class="col-lg-9">
                    <select class="form-control form-control-sm rounded-0" name="politician" style="border: 0; outline: 0; border-bottom: 2px solid #17a2b8">
                      <option value="0">Select Politician</option>
                      <?php
                      foreach($data['candidates'] as $candidate){
                        $fullname = $candidate['lastname'].', '.$candidate['firstname'];
                        $fullname = ($candidate['middlename']) ? $fullname.' '.$candidate['middlename'] : $fullname;
                      ?>
                        <option value="<?php echo $candidate['id'] ?>">
                          <?php echo strtoupper($fullname) ?>
                        </option>
                      <?php
                      }
                      ?>
                    </select>
                </div>
              </div>

              <div class="row mt-3">
                <div class="col-lg-3 align-self-center">
                    Position:
                </div>
                <div class="col-lg-9">
                    <select class="form-control form-control-sm rounded-0" name="position" style="border: 0; outline: 0; border-bottom: 2px solid #17a2b8">
                      <option value="0">Select a Position</option>
                      <?php
                      foreach($data['positions'] as $key => $position){
                      ?>
                        <option value="<?php echo $key ?>">
                          <?php echo $position ?>
                        </option>
                      <?php
                      }
                      ?>
                    </select>
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
<script src="<?php echo ROOT.BOOTSTRAP; ?>plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
<script>
  var id = "<?php echo $data['party']['id'] ?>";
  get_slate(id, 1);

  $('#allied-switch').bootstrapSwitch();

  $("#allied-switch").on('switchChange.bootstrapSwitch', function(event, state) {
    $(this).attr('data-switch-value', event.target.checked);
    var stat = 0; 

    if ($(this).is(':checked')){
      stat = 1;
    }
    else{
      stat = 0;
    }

    $.ajax({
        url: 'set_party_allied',
          method: 'POST',
          data: {'id': id, 'status': stat},
          dataType: 'html',
        success: function(result) {

        },
        error: function(obj, err, ex){
          Swal.fire({
            title: "Error",
            text: err + ": " + obj.status + " " + ex,
            icon: "error",
            confirmButtonColor: "#b34045",
          });
      }
    })
  });

  $('#frmPartAddMember').on('submit', function(e){
    e.preventDefault();

    $.ajax({
        url: 'party_add_member?partyid='+id,
          method: 'POST',
          data: $(this).serialize(),
          dataType: 'html',
        success: function(result) {
          $('#modal_add_member_form').modal('hide');
          get_slate(id, 1);
        },
        error: function(obj, err, ex){
          Swal.fire({
            title: "Error",
            text: err + ": " + obj.status + " " + ex,
            icon: "error",
            confirmButtonColor: "#b34045",
          });
      }
    })
      
  });

  function get_slate(party_id, status){
    $.ajax({
        url: 'slate',
          method: 'POST',
          data: {id: party_id, status: status},
          dataType: 'html',
        success: function(result) {
          $('#slate').html(result);
        },
        error: function(obj, err, ex){
          Swal.fire({
            title: "Error",
            text: err + ": " + obj.status + " " + ex,
            icon: "error",
            confirmButtonColor: "#b34045",
          });
      }
    })
  }
</script>
</html>